<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$sql = "select * from tb_empresa where fl_status = 'A'"; 
$res = mysqli_query($link,$sql); 

$link->close();
?>