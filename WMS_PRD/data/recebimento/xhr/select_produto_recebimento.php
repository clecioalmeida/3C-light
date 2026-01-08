<?php
	require_once("bd_class.php");

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "select cod_produto, nm_produto from tb_produto" or die(mysqli_error($sql));
	
	$select_produto = mysqli_query($link, $sql);

	$sql_local = "select id, nome from tb_armazem" or die(mysqli_error($sql));
	
	$select_local = mysqli_query($link, $sql_local);

	$sql_sgrupo = "select cod_sub_grupo, nm_sub_grupo from tb_sub_grupo" or die(mysqli_error($sql));
	
	$select_subgrupo = mysqli_query($link, $sql_sgrupo);

	$sql_grupo = "select cod_grupo, nm_grupo from tb_grupo" or die(mysqli_error($sql));
	
	$select_grupo = mysqli_query($link, $sql_grupo);

	$sql_cliente = "select cod_cliente, nm_cliente from tb_cliente where fl_status = 1" or die(mysqli_error($sql));
	
	$select_cliente = mysqli_query($link, $sql_cliente);

	$sql_galpao = "select * from tb_galpao where fl_status = 1" or die(mysqli_error($sql));
	
	$select_galpao = mysqli_query($link, $sql_galpao);
 
?>