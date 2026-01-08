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

$nr_pedido	 	= $_POST["nr_pedido"];
$cod_almox 		= $_POST["nr_matricula"];
$doc_material 	= $_POST["doc_material"];
$nr_ped_sap 	= $_POST["nr_ped_sap"];
$ds_tipo 		= $_POST["ds_tipo"];
$ds_frete 		= $_POST["ds_frete"];
$dt_separa 		= $_POST["d_separa"];
$dt_pedido 		= $_POST["d_pedido"];
$dt_limite 		= $_POST["d_limite"];
$hr_limite 		= $_POST["h_limite"];
$ds_prd 		= $_POST["ds_prd"];
$ds_obs_sac 	= $_POST["ds_obs_sac"];
$ds_cat 		= $_POST["ds_cat"];
$ds_dest_comp 	= $_POST["ds_dest_comp"];


$sql = "update tb_pedido_coleta set cod_almox = '$cod_almox', ds_destino = '$ds_dest_comp', doc_material = '$doc_material', nr_ped_sap = '$nr_ped_sap', ds_tipo = '$ds_tipo', produto = '$ds_cat', ds_frete = '$ds_frete',dt_pedido = '$dt_pedido', dt_separa = '$dt_separa',  dt_limite = '$dt_limite', hr_limite = '$hr_limite', ds_prd = '$ds_prd',  ds_obs_sac = '$ds_obs_sac', usr_update = '$id', dt_update = '$date' where nr_pedido = '$nr_pedido'";
$res = mysqli_query($link,$sql);

if(mysqli_affected_rows($link) > 0){

	echo "Pedido alterado com sucesso.";

}else{

	echo "Ocorreu um erro.";

}

$link->close();
?>