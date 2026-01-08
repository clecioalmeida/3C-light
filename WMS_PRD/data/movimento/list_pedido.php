<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$pedido = $_POST['pedido'];

$sql_ped = "select distinct(nr_pedido), t1.cod_cliente, t1.dt_pedido, t1.dt_limite, t1.hr_limite, t1.fl_status, t2.nm_cliente from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente where (t1.nr_pedido like '%$pedido%' or t2.nm_cliente like '%$pedido%' or t1.dt_limite like '%$pedido%') and t1.fl_empresa = '$cod_cli' ORDER BY t1.dt_limite desc";
    
$ped = mysqli_query($link,$sql_ped);
$tr = mysqli_num_rows($ped);
$link->close();
?>