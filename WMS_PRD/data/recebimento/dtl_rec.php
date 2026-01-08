 <?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:../../index.php");
    exit;

} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION['cod_cli'];
}
?>
<?php
 date_default_timezone_set('America/Sao_Paulo');
 $date = date("Y-m-d H:i:s");

 require_once 'bd_class.php';
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $cod_recebimento            = $_POST['cod_recebimento'];
$nm_fornecedor              = $_POST['nm_fornecedor'];
$nr_insumo                  = $_POST['nr_insumo'];
$nm_motorista               = $_POST['nm_motorista'];
$dt_recebimento_previsto    = $_POST['dt_recebimento_previsto'];
$nr_peso_previsto           = $_POST['nr_peso_previsto'];
$nr_volume_previsto         = $_POST['nr_volume_previsto'];
$nm_transportadora          = $_POST['nm_transportadora'];
$nm_placa                   = $_POST['nm_placa'];
$obs                        = $_POST['obs'];
$id_janela                  = $_POST['id_janela'];
$dt_ag_disp                 = $_POST['dt_ag_disp'];

$sql_dt = "SELECT id FROM tb_janela
WHERE cod_rec = '$cod_recebimento'" or die(mysqli_error($sql_dt));
$res_dt = mysqli_query($link, $sql_dt);
$rec=mysqli_fetch_assoc($res_dt);

$id_old = $rec['id'];

if($id_old == $id_janela){

	$sql = "update tb_recebimento set nm_fornecedor = '$nm_fornecedor', nr_insumo = '$nr_insumo', nm_motorista =  '$nm_motorista', dt_recebimento_previsto =  '$dt_recebimento_previsto', nr_peso_previsto = '$nr_peso_previsto', nr_volume_previsto = '$nr_volume_previsto', nm_transportadora = '$nm_transportadora', nm_placa = '$nm_placa', ds_obs = '$obs', usr_update = '$id', dt_update = '$date' WHERE cod_recebimento = '$cod_recebimento'";
	$resultado_id = mysqli_query($link, $sql);

	if(mysqli_affected_rows($link) > 0){ 

		echo "Ordem de recebimento alterada!";

	}else{ 


		echo "Erro no cadastro!";

	} 

}else{

	$sql_jan = "SELECT fl_status FROM tb_janela
	WHERE id = '$id_janela'" or die(mysqli_error($sql_dt));
	$res_jan = mysqli_query($link, $sql_jan);
	$status=mysqli_fetch_assoc($res_jan);

	if($status['fl_status'] == "A"){

		$sql = "update tb_recebimento set nm_fornecedor = '$nm_fornecedor', nr_insumo = '$nr_insumo', nm_motorista =  '$nm_motorista', dt_recebimento_previsto =  '$dt_ag_disp', nr_peso_previsto = '$nr_peso_previsto', nr_volume_previsto = '$nr_volume_previsto', nm_transportadora = '$nm_transportadora', nm_placa = '$nm_placa', ds_obs = '$obs', usr_update = '$id', dt_update = '$date' WHERE cod_recebimento = '$cod_recebimento'";
		$resultado_id = mysqli_query($link, $sql);

		if(mysqli_affected_rows($link) > 0){ 

			$upd_old = "update tb_janela set cod_rec = NULL, fl_status = 'A' WHERE id = '$id_old'";
			$res_old = mysqli_query($link, $upd_old);

			$upd_new = "update tb_janela set cod_rec = '$cod_recebimento', fl_status = 'S' WHERE id = '$id_janela'";
			$res_new = mysqli_query($link, $upd_new);

			echo "Ordem de recebimento alterada!";

		}else{ 


			echo "Erro no cadastro!";

		}



	}else{

		echo "A janela escolhida foi ocupada recentemente. Por favor selecione outra janela.";

	} 

}


$link->close();
?>