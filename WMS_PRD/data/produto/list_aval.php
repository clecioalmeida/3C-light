<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$sql_aval = "select * from tb_avaliacao"; 
$res_aval = mysqli_query($link,$sql_aval); 
$link->close();
?>
