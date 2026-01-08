<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$SQL = "select * from tb_galpao where fl_status = 1";
$res = mysqli_query($link,$SQL);
$link->close();
?>