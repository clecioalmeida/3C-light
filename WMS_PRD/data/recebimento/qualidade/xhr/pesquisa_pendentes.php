<?php 
require_once('xhr/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$sql_ocorrencia = "select * from tb_ocorrencias where fl_status = 'A' or fl_status = 'P' order by cod_ocorrencia desc"; 
$res_ocorrencia = mysqli_query($link,$sql_ocorrencia); 
$tr_ocorrencia = mysqli_num_rows($res_ocorrencia);

$link->close();
?>