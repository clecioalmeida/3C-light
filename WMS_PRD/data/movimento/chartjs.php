<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	/* Pedidos por mês */

	$pedido_mes=sprintf("select count(nr_pedido) as total, MONTH(dt_pedido) as mes from tb_pedido_coleta group by YEAR(dt_pedido), MONTH(dt_pedido)");
	$res_pedido_mes = mysqli_query($link, $pedido_mes);

	$data = array();
	foreach ($res_pedido_mes as $dados) {
		$data[] = $dados;
	}

	print json_encode($data);
$link->close();
	?>