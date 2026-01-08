<?php
session_start();
	require_once("bd_class.php");
	
	$id_kit = $_POST['id_kit'];
	$cod_estoque = $_POST['cod_estoque'];
	$quantidade = $_POST['quantidade'];

	$_SESSION['id_kit']=$id_kit;
	
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql_kit = " insert into tb_kit_produto (id_kit, cod_estoque, quantidade) values ('$id_kit', '$cod_estoque', '$quantidade') ";

	$resultado_id = mysqli_query($link, $sql_kit) or die( mysqli_error( $link ) );
$link->close();
?>