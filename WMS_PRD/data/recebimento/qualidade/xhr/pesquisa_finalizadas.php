<?php 
require_once('xhr/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$sql_ocor_finalizada = "select * from tb_ocorrencias where fl_status = 'F'"; 
$res_ocor_finalizada = mysqli_query($link,$sql_ocor_finalizada); 
$tr_ocor_finalizada = mysqli_num_rows($res_ocor_finalizada);

$link->close();
?>