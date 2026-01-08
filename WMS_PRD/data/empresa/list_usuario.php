<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$sql = "select t1.id, t1.nm_user, t1.nm_login, t1.id_op, t1.id_depto, t2.nm_cargo
		from tb_usuario t1
        left join tb_cargo t2 on t1.id_depto = t2.cod_cargo
		where t1.fl_status = 'A' and t1.fl_tipo = 'U'"; 
$res = mysqli_query($link,$sql); 

$link->close();
?>