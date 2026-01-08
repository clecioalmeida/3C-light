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

$ds_data 	= $_POST['ds_data'];
$nr_ped 	= $_POST['nr_ped'];
$nr_at 		= $_POST['nr_at'];

$ins_etq="insert into tb_fc_cron (ds_data, nr_ped, nr_at, fl_empresa, fl_status, usr_create, dt_create) values ('$ds_data', '$nr_ped', '$nr_at', '$cod_cli', 'A', '$id', '$date')";
$etq = mysqli_query($link,$ins_etq);

if(mysqli_affected_rows($link) > 0){

	echo 'Dados cadastrados.';

}else{

	echo 'Erro no cadastro.';

}

$link->close();
?>