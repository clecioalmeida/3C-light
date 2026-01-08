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

$id_ind = $_POST['id_ind'];

$upd_ind="update tb_fc_cron set fl_status = 'E' where id = '$id_ind'";
$etq = mysqli_query($link,$upd_ind);

if(mysqli_affected_rows($link) > 0){

	echo 'Dados cadastrados.';

}else{

	echo 'Erro no cadastro.';

}

$link->close();
?>