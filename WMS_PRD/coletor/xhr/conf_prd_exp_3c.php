<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$barcode_exp 	= $_POST['barcode_exp_3c'];
$nr_pedido 		= $_POST['nr_pedido'];
$nr_qtde 		= $_POST['nr_qtde'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_init="select t1.produto, t1.fl_status, coalesce(sum(t2.nr_qtde),0)-coalesce(sum(t1.nr_qtde_exp),0) as conferir
from tb_pedido_coleta_produto t1
left join tb_pedido_conferencia t2 on t1.nr_pedido = t2.nr_pedido and t1.produto = t2.produto
where t1.nr_pedido = '$nr_pedido' and t1.produto = '$barcode_exp'";
$res_init=mysqli_query($link, $query_init);
$init=mysqli_fetch_assoc($res_init);
$produto = $init['produto'];
$conferir = $init['conferir'];
$fl_status = $init['fl_status'];

if($produto > 0){

	if($conferir == 0 && $fl_status <> 'C' && $fl_status <> 'F'){

		$retorno = array(
			'info' => "0",
		);

		echo(json_encode($retorno));

	}else{

		$retorno = array(
			'info' => "1",
		);

		echo(json_encode($retorno));

	}

}else{

	$retorno = array(
		'info' => "3",
	);

	echo(json_encode($retorno));

}

$link->close();
?>