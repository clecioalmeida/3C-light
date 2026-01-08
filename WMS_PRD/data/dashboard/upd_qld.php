<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_ind 		= $_POST['id_ind'];
$nr_sku_blq 	= $_POST['nr_sku_blq'];
$vlr_sku_blq 	= $_POST['vlr_sku_blq'];
$nr_est_qld 	= $_POST['nr_est_qld'];
$vlr_est_qld 	= $_POST['vlr_est_qld'];

$upd_ind="update tb_fc_qld set nr_sku_blq = '$nr_sku_blq', vlr_sku_blq = '$vlr_sku_blq', nr_est_qld = '$nr_est_qld', vlr_est_qld = '$vlr_est_qld', usr_update = '$id', dt_update = '$date' where id = '$id_ind'";
$etq = mysqli_query($link,$upd_ind);

if(mysqli_affected_rows($link) > 0){

	echo 'Dados cadastrados.';

}else{

	echo 'Erro no cadastro.';

}

$link->close();
?>