<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_parte = "select cod_almox, ds_almox from tb_almox where fl_status = 'A' and fl_empresa = '$cod_cli'";
$res_parte = mysqli_query($link, $sql_parte);

if(mysqli_num_rows($res_parte) > 0){

	while ($parte = mysqli_fetch_assoc($res_parte)) {
		$array_parte[] = array(
			'almox'	=> $parte['cod_almox']."".$parte['ds_almox'],
			'cod_almox'  	=> $parte['cod_almox'],
		);
	}

}else{

	$array_parte[] = array(
		'almox'			=> "NÃO ENCONTRADO.",
		'cod_almox'  	=> "0",
	);

}

echo (json_encode($array_parte));
$link->close();
?>