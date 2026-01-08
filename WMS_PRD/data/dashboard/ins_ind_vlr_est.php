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

$source = array('R$ ', '.', ',');
$replace = array('', '', '.');

$ds_data 	= $_POST['ds_data'];
$vlr_total  = $_POST['vlr_total'];
$vlr_medio 	=$_POST['vlr_medio'];

$query_qtde="select id, ds_data from tb_fc_est where ds_data = '$ds_data' and fl_tipo = 'V'";
$qtde = mysqli_query($link,$query_qtde);

if(mysqli_num_rows($qtde) > 0){
	
	echo "Dados já existem.";

}else{

	$ins_etq = "insert into tb_fc_est (ds_data, vlr_total, vlr_medio, fl_tipo, fl_empresa, usr_create, dt_create) values ('$ds_data', '$vlr_total', '$vlr_medio', 'V', '$cod_cli', '$id', '$date')";
	$etq = mysqli_query($link,$ins_etq);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.'.$vlr_total." - ".$vlr_medio;

	}else{

		echo 'Erro no cadastro.'.$vlr_total." - ".$vlr_medio;

	}

}

$link->close();
?>