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

$nr_matr = $_POST["nr_matr"];

$sql_parte = "select id, nr_matricula, upper(ds_nome) as ds_nome from tb_funcionario where fl_status = 'A' and nr_matricula = '$nr_matr'";
$res_parte = mysqli_query($link, $sql_parte);


if(mysqli_num_rows($res_parte) > 0){

	$parte = mysqli_fetch_assoc($res_parte);
	$array_parte = array(
		'info' 				=> "0",
		'nr_matricula'		=> $parte['nr_matricula'],
		'ds_req'  			=> $parte['nr_matricula']." - ".$parte['ds_nome'],
	);

}else{

	$array_parte = array(
		'info' 			=> "1",
	);

}

echo (json_encode($array_parte));
$link->close();
?>