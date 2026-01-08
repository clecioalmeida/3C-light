<?php
	require_once('bd_class.php');

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$big_select="set sql_big_selects=1";
	$res_select = mysqli_query($link,$big_select);

	$SQL = "select t1.*
	from tb_portaria t1
	where t1.fl_status <> 'F'";
	$res = mysqli_query($link,$SQL);
	
	$link->close();
?>