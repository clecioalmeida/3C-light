<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$SQL = "select * from tb_cliente where fl_status = 'A' and fl_tipo = 'F'"; 
$res = mysqli_query($link,$SQL); 


$link->close();
?>