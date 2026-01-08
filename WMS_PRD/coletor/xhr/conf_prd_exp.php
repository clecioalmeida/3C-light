<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$barcode_exp 	= $_POST['barcode_exp'];
$nr_pedido 		= $_POST['nr_pedido'];
$nr_qtde 		= $_POST['nr_qtde'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_init="select t1.produto, coalesce(t1.nr_qtde_conf,0) as qtde_conf, coalesce(sum(t1.nr_qtde_conf),0)-coalesce(sum(t1.nr_qtde_exp),0) as conferir
from tb_pedido_coleta_produto t1
where t1.nr_pedido = '$nr_pedido' and t1.produto = '$barcode_exp'";
$res_init=mysqli_query($link, $query_init);
$init=mysqli_fetch_assoc($res_init);
$produto = $init['produto'];
$conferir = $init['conferir'];
$qtde_conf = $init['qtde_conf'];

if($produto > 0){

	if($qtde_conf == 0){

		$retorno = array(
			'info' => "2",
		);

		echo(json_encode($retorno));

	}else if($conferir == 0){

		$retorno = array(
			'info' => "1",
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

?>