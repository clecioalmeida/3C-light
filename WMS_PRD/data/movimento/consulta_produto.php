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
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();
	
	$select_dest = "select cod_produto, nm_produto from tb_produto where fl_empresa = '$cod_cli'";
	$res_dest = mysqli_query($link,$select_dest);
	
	while ($dest=mysqli_fetch_assoc($res_dest)) {
		$array_dest[] = array(
			'cod_produto'	=> $dest['cod_produto'],
			'nm_produto' => $dest['nm_produto'],
		);
	}

	echo(json_encode($array_dest));

$link->close();
?>