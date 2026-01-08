<?php 
require_once('bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select * from tb_saldo_produto where fl_status = 1" ;

$res = mysqli_query($link,$SQL); 
$tr = mysqli_num_rows($res);  

$sql_recebimento = "select t1.*, t2.* from tb_saldo_produto t1 left join tb_recebimento t2 on t1.cod_c_v = t2.cod_recebimento where t1.fl_status = 1" or die(mysqli_error($sql_recebimento));

$res_recebimento = mysqli_query($link,$sql_recebimento); 
$tr = mysqli_num_rows($res_recebimento); 


$link->close();
?>
