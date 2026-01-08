<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_col 			= $_POST["cod_col"];
$nrPedidoProd 		= $_POST["nrPedidoProd"];
$nrPedidoProdItem 	= $_POST["nrPedidoProdItem"];

$upd_prd = "update tb_pedido_coleta_produto set fl_status = 'E' where cod_ped = '$cod_col'";
$res_prd = mysqli_query($link,$upd_prd);

if(mysqli_affected_rows($link) > 0){

	$upd_col = "update tb_coleta_pedido set fl_status = 'E' where produto = '$nrPedidoProdItem'";
	$res_col = mysqli_query($link,$upd_col);

	echo "Produto excluído.";

}else{

	echo "Erro na exclusão do produto.";

}
$link->close();
?>