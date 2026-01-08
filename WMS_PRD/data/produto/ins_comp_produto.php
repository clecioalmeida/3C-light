<?php
session_start();
	require_once("bd_class.php");
	
	$prod_comp = $_POST['prod_comp'];
	$cod_produto = $_POST['cod_produto'];
	$nr_qtde_comp = $_POST['nr_qtde_comp'];

	$_SESSION['prod_comp']=$prod_comp;
	
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql_kit = "update tb_produto set fl_comp = '$prod_comp', nr_qtde_comp = '$nr_qtde_comp', fl_tipo_comp = '2' where cod_produto = '$cod_produto'";

	$resultado_id = mysqli_query($link, $sql_kit) or die( mysqli_error( $link ) );
$link->close();
?>