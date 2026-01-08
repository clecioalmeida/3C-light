<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"])){

	header("Location:index.php");
	exit;

}else{

	$id = $_SESSION["id"];
}
?>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_fun = $_POST["id_fun"];


$upd_ped = "update tb_funcionario set fl_status = 'E' where id = '$id_fun'";
$res_ped = mysqli_query($link,$upd_ped);

if(mysqli_affected_rows($link) > 0){

	echo "Registro excluído.";

}else{

	echo "Registro não excluído.";

}

$link->close();
?>