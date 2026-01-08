<?php 
session_start();
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_nf = $_POST['id_nf'];
	$id_rec = $_POST['id_rec'];
	$_SESSION['id_nf']=$id_nf;
	$_SESSION['id_rec']=$id_rec;
	
	$sql_parte = "select * from tb_nf_entrada where cod_nf_entrada = '$id_nf'";
	$res_parte = mysqli_query($link, $sql_parte);	
	
$link->close();
	?>
	