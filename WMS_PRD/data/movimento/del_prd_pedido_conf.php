<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}

?>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_conf 			= $_POST["cod_conf"];
$cod_col 			= $_POST["cod_col"];
$nrPedidoProdSep 	= $_POST["nrPedidoProdSep"];
$nrPedidoProdItem 	= $_POST["nrPedidoProdItem"];

$upd_conf = "update tb_pedido_conferencia set fl_status = 'E', usr_update = '$id', dt_update = '$date' where cod_conferencia = '$cod_conf'";
$res_conf = mysqli_query($link,$upd_conf);

if(mysqli_affected_rows($link) > 0){

	$upd_col = "update tb_coleta_pedido set fl_status = 'M' where cod_col = '$cod_col'";
	$res_col = mysqli_query($link,$upd_col);

	$upd_prd = "update tb_pedido_coleta_produto set fl_status = 'M', fl_conferido = NULL where produto = '$nrPedidoProdItem'";
	$res_prd = mysqli_query($link,$upd_prd);

	$upd_ped = "update tb_pedido_coleta set fl_status = 'M' where nr_pedido = '$nrPedidoProdSep'";
	$res_ped = mysqli_query($link,$upd_ped);

	if(mysqli_affected_rows($link) > 0){

		echo "Pedido atualizado.";

	}else{

		echo "Pedido não atualizado.";

	}

	echo "Separação excluída.";

}else{

	echo "Erro na exclusão da separação.";

}
$link->close();
?>