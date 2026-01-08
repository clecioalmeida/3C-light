<?php
session_start();
	require_once("bd_class.php");
	
	$id_kit = $_POST['id_kit'];
	$cod_estoque = $_POST['cod_estoque'];
	$cod_estoque_sbst = $_POST['cod_estoque_sbst'];

	$_SESSION['id_kit']=$id_kit;
	
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql_kit = " insert into tb_kit_var (id_kit, cod_estoque, cod_estoque_sbst) values ('$id_kit', '$cod_estoque', '$cod_estoque_sbst') ";

	$resultado_id = mysqli_query($link, $sql_kit) or die( mysqli_error( $link ) );
$link->close();
?>