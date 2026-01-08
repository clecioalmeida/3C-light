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
$sku_int 		= $_POST['sku_int'];
$vlr_int 		= $_POST['vlr_int'];
$sku_for 		= $_POST['sku_for'];
$vlr_for 		= $_POST['vlr_for'];
$sku_cli 		= $_POST['sku_cli'];
$vlr_cli 		= $_POST['vlr_cli'];
$sku_total 		= $_POST['sku_total'];
$vlr_total 		= $_POST['vlr_total'];

$upd_ind="update tb_fc_avaria set sku_int = '$sku_int', vlr_int = '$vlr_int', sku_for = '$sku_for', vlr_for = '$vlr_for', sku_cli = '$sku_cli', vlr_cli = '$vlr_cli', sku_total = '$sku_total', vlr_total = '$vlr_total', usr_update = '$id', dt_update = '$date' where id = '$id_ind'";
$etq = mysqli_query($link,$upd_ind);

if(mysqli_affected_rows($link) > 0){

	echo 'Dados cadastrados.';

}else{

	echo 'Erro no cadastro.';

}

$link->close();
?>