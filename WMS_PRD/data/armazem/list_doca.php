<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$SQL = "select * from tb_doca"; 
$res = mysqli_query($link,$SQL); 
$tr = mysqli_num_rows($res);			
$link->close();
?>