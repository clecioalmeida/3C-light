<?php
	require_once("bd_class.php");

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql_recebimento = "select * from tb_recebimento" or die(mysqli_error($sql));
	
	$select_recebimento = mysqli_query($link, $sql_recebimento);
 
?>