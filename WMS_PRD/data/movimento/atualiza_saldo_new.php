<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$nr_pedido = $_POST['fin_col'];

$query_cod = "select t1.cod_estoque, t1.nr_qtde_col, t2.nr_qtde
from tb_coleta_pedido t1
left join tb_posicao_pallet t2 on t1.cod_estoque = t2.cod_estoque
where t1.nr_pedido = '$nr_pedido'";
$res_col = mysqli_query($link, $query_cod);
while ($parte = mysqli_fetch_assoc($res_col)) {
	$cod_estoque 	= $parte['cod_estoque'];
	$nr_qtde_col 	= $parte['nr_qtde_col'];
	$nr_qtde 		= $parte['nr_qtde'];
	$qtde 			= $nr_qtde - $nr_qtde_col;

	$sql_saldo = "update tb_posicao_pallet set nr_qtde = '$qtde', nr_qtde_ant = '$nr_qtde', nr_pedido_ant = '$nr_pedido', user_update = '$id', dt_update = '$date' where cod_estoque = '$cod_estoque'";
	$saldo = mysqli_query($link1, $sql_saldo);

	$sql_col = "update tb_coleta_pedido set fl_status = 'F' where cod_estoque = '$cod_estoque'";
	$col = mysqli_query($link, $sql_col);

}

if (mysqli_affected_rows($link1) > 0) {

	$sql_ped = "update tb_pedido_coleta set fl_status = 'F' where nr_pedido = '$nr_pedido'";
	$ped = mysqli_query($link1, $sql_ped);

	$sql_prd = "update tb_pedido_coleta_produto set usr_fim_coleta = '$id', dt_fim_coleta = '$date', fl_status = 'F' where nr_pedido = '$nr_pedido'";
	$prd = mysqli_query($link1, $sql_prd);

	$retorno[] = array(
		'info' => "0",
	);

	echo (json_encode($retorno));

} else {

	$retorno[] = array(
		'info' => "1",
	);

	echo (json_encode($retorno));

}

$link->close();
?>