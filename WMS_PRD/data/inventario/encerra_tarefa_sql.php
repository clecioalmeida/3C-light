<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

//Verifica número do pedido
$Query1="select id as id_tar from tb_inv_tarefa where fl_status = 'A'";
$res1 = mysqli_query($link,$Query1);
while ($dados=mysqli_fetch_assoc($res1)) {
	$id_tar=$dados['id_tar'];	

	$query_conf="select t1.*, t2.*
	from tb_inv_tarefa t1
	left join tb_inv_conf t2 on t1.id = t2.id_tar
	where t1.id = '$id_tar'";
	$res_conf=mysqli_query($link, $query_conf);

	while ($dados_conf = mysqli_fetch_assoc($res_conf)) {
		$id_galpao=$dados_conf['id_galpao'];
		$id_rua=$dados_conf['id_rua'];
		$id_coluna=$dados_conf['id_coluna'];
		$id_altura=$dados_conf['id_altura'];
		$ds_embalagem=$dados_conf['ds_embalagem'];
		$id_inv=$dados_conf['id_inv'];
		$id_produto=$dados_conf['id_produto'];
		$nr_qtde=$dados_conf['cont_2'];
		$fl_tipo=$dados_conf['fl_tipo'];
	}

	$selec_id="select id from tb_endereco where rua = '$id_rua' and galpao = '$id_galpao' and coluna = '$id_coluna' and altura = '$id_altura'";
	$res_id=mysqli_query($link, $selec_id);
	while ($dados_id = mysqli_fetch_assoc($res_id)) {
		$id_end=$dados_id['id'];
	}

	if($id_produto == '47144'){

		$ins_saldo="insert into tb_posicao_pallet (produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, ds_embalagem, nr_qtde, nm_user_mov, dt_user_mov, fl_status, id_endereco, fl_tipo, id_tar) values ('$id_produto', '$id_galpao', '$id_rua', '$id_coluna', '$id_altura', '$ds_embalagem', '$nr_qtde', '$id', now(), 'I', '$id_end', 'D', '$id_tar');";
		$res_saldo=mysqli_query($link, $ins_saldo);

		$ins_ocor="insert into tb_ocorrencias (nm_ocorrencia, tipo, fl_resp_cli, finalizadora, criticidade, dt_abertura, fl_status, cod_origem, user_create, dt_create) values ('Produto não identificado no inventário', 'A', 'N', 'N', 'M', now(), 'A', '$id_tar', '$id', now())";
		$res_ocor=mysqli_query($link, $ins_ocor);

	} else {

		$ins_saldo="insert into tb_posicao_pallet (produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, ds_embalagem, nr_qtde, nm_user_mov, dt_user_mov, fl_status, id_endereco, fl_tipo, id_tar) values ('$id_produto', '$id_galpao', '$id_rua', '$id_coluna', '$id_altura', '$ds_embalagem', '$nr_qtde', '$id', now(), 'I', '$id_end', 'N', '$id_tar');";
		$res_saldo=mysqli_query($link, $ins_saldo);

	}

	$updt_conf="update tb_inv_tarefa set fl_status = 'X' where id = '$id_tar'";
	$res_updt=mysqli_query($link1, $updt_conf);
	//$tr_upd=mysqli_affected_rows($link1);

	if(mysqli_affected_rows($link1) > 0){

		echo "Tarefa $id_tar encerrada com sucesso.";

	}else{

		echo "Não funcionou.";

	}
}

$link->close();
?>