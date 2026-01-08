<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:index.php");
  exit;

}else{

  $id=$_SESSION["id"];
  $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_minuta	 	= $_POST["cod_minuta"];
$dt_minuta 		= $_POST["dt_minuta"];
$hr_entrada 	= $_POST["hr_entrada"];
$hr_saida 		= $_POST["hr_saida"];
$nr_placa 		= $_POST["nr_placa"];
$tp_veiculo 	= $_POST["tp_veiculo"];
$ds_transporte 	= $_POST["ds_transporte"];
$km_ini 		= $_POST["km_ini"];
$km_fim 		= $_POST["km_fim"];
$nr_averba 		= $_POST["nr_averba"];
$fl_comprovante = $_POST["fl_comprovante"];
$ds_tipo 		= $_POST["ds_tipo"];
$ds_obs 		= $_POST["ds_obs"];


$sql = "update tb_minuta set dt_minuta = '$dt_minuta', hr_entrada = '$hr_entrada', hr_saida = '$hr_saida', nr_placa = '$nr_placa', tp_veiculo = '$tp_veiculo', ds_transporte = '$ds_transporte', km_ini = '$km_ini', km_fim = '$km_fim', ds_tipo = '$ds_tipo', nr_averba = '$nr_averba', fl_comprovante = '$fl_comprovante', ds_obs = '$ds_obs' where cod_minuta = '$cod_minuta'";
$res = mysqli_query($link,$sql);

if(mysqli_affected_rows($link) > 0){

	echo "Romaneio alterado com sucesso.";

}else{

	echo "Ocorreu um erro.";

}

$link->close();
?>