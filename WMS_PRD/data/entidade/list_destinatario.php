<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$SQL = "select * from tb_cliente where fl_tipo = 'D' and cod_cli is null and fl_status = 1"; 
$res = mysqli_query($link,$SQL); 


$link->close();
?>