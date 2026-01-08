<?php
	require_once("bd_class.php");

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'C' and fl_status = 1" or die(mysqli_error($sql));

	$sql_usr = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'U' and fl_status = 1" or die(mysqli_error($sql));
	$res_usr = mysqli_query($link, $sql_usr);  
	
	$select_cliente = mysqli_query($link, $sql);

	$sql_fornecedor = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'D' and fl_status = 1" or die(mysqli_error($sql));
	
	$select_fornecedor = mysqli_query($link, $sql_fornecedor);

	$sql_tp = "select cod_tipo, nm_tipo from tb_tipo where ds_tipo = 1";  
    $res_tp = mysqli_query($link, $sql_tp);  

    $sql_tipo2 = "select t1.* from tb_tipo t1
    left join tb_recebimento t2 on t1.cod_tipo = t2.tp_rec
    where ds_tipo = 1";
    $res_tipo2 = mysqli_query($link, $sql_tipo2);    
 
?>