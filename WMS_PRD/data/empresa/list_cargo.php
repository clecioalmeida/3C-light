<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$sql = "select * from tb_cargo where fl_status = 1"; 
$res = mysqli_query($link,$sql); 

$link->close();
?>