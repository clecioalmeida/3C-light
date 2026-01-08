<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id=$_SESSION["id"];
	$id_oper=$_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
$data_atual = (new DateTime($date))->format('H:i');

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_recebimento = $_POST['cod_rec'];

$sql = "update tb_recebimento set fl_status = 'CR', dt_chegada = '$date' WHERE cod_recebimento = '$cod_recebimento'";
$resultado_id = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){ 

	$sql_rec = "select t1.nm_placa, t1.nm_fornecedor, t1.nm_motorista, count(t3.cod_nf_entrada) as total_prd, t4.ds_janela 
	from tb_recebimento t1 
	left join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec
	left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
	left join tb_janela t4 on t1.cod_recebimento = t4.cod_rec
	where t1.cod_recebimento = '$cod_recebimento'";
	$res_rec = mysqli_query($link,$sql_rec);
	$tr_rec = mysqli_num_rows($res_rec);

	if($tr_rec > 0){

		$dados = mysqli_fetch_assoc($res_rec);
		$nm_fornecedor 	= $dados['nm_fornecedor'];
		$nm_motorista 	= $dados['nm_motorista'];
		$nm_placa 		= $dados['nm_placa'];
		$total_prd 		= $dados['total_prd'];
		$ds_janela 		= $dados['ds_janela'];
		$tolerancia = date("H:i",strtotime("$ds_janela + 15 minutes"));

		$ins_reg="insert into tb_portaria (usr_chegada, dt_chegada, ds_placa, ds_veiculo, ds_empresa, ds_nome, ds_dpto, ds_contato, ds_motivo, dt_saida, fl_status, ds_galpao, ds_doca, ds_obs, usr_create, dt_create) values ('$id', '$date', '$nm_placa', '', '$nm_fornecedor', '$nm_motorista', '', '', '', '', 'CR', '', '', '', '$id', '$date')";
		$res_reg = mysqli_query($link,$ins_reg);

		if(mysqli_affected_rows($link) > 0){

			echo "Chegada confirmada!";

		}else{

			echo "Erro no cadastro!(Erro 2)";

		}

		if($total_prd == 0){

			$ins_oc="insert into tb_ocorrencias (criticidade, tipo, cod_origem, nm_ocorrencia, ds_responsavel, nm_depto, dt_final, ds_obs, fl_status, dt_abertura) values ('B', 'G', '$cod_recebimento', 'AGENDAMENTO RECEBIDO SEM A INCLUSÃO PRÉVIA DE NOTAS FISCAIS', '', 'RECEBIMENTO', '', '', 'A', '$date')";
			$res_oc = mysqli_query($link,$ins_oc);

			if(mysqli_affected_rows($link) != 1){

				echo "Erro no cadastro da ocorrência!(Erro 3)";

			}

		}

		$hora1 = explode(":",$tolerancia);
		$hora2 = explode(":",$data_atual);
		$acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60);
		$acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60);
		$resultado = $acumulador2 - $acumulador1;
		$hora_ponto = floor($resultado / 3600);
		$min_ponto = floor($resultado / 60);
		$resultado2 = $resultado - ($min_ponto * 60);

		if($hora_ponto >= 0 && $min_ponto > 0){

			$ins_oc="insert into tb_ocorrencias (criticidade, tipo, cod_origem, nm_ocorrencia, ds_responsavel, nm_depto, dt_final, ds_obs, fl_status, dt_abertura, user_create, dt_create) values ('B', 'G', '$cod_recebimento', 'FORNECEDOR ATRASOU A CHEGADA', '', 'RECEBIMENTO', '', '', 'A', '$date','$id', '$date')";
			$res_oc = mysqli_query($link,$ins_oc);

		}

	}else{

		echo "OR não encontrada!";

	}	

}else{

	echo "Erro no cadastro!(Erro 1)";

}

$link->close();
?>