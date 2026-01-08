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
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_almox = $_POST["cod_almox"];

$sql_parte = "select cod_almox, ds_almox from tb_almox where fl_status = 'A' and fl_empresa = '$cod_cli' and cod_almox = '$cod_almox'";
$res_parte = mysqli_query($link, $sql_parte);

if(mysqli_num_rows($res_parte) > 0){

	$parte = mysqli_fetch_assoc($res_parte);
	
	$array_parte = array(
		'info' 			=> "0",
		'cod_almox'		=> $parte['cod_almox'],
		'ds_almox'  	=> $parte['cod_almox']." - ".$parte['ds_almox'],
	);

}else{

	$array_parte = array(
		'info' 			=> "1",
		'cod_almox'		=> "",
		'ds_almox'  	=> "DESTINO NÃO ENCONTRADO.",
	);

}

echo (json_encode($array_parte));
$link->close();
?>