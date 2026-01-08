<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$nr_pedido = $_REQUEST['nr_pedido'];
	
	$sql_parte = "select t1.nr_pedido, t2.nm_cliente 
	from tb_pedido_coleta t1
	left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente
	where t1.nr_pedido = '$nr_pedido'";
	$res_parte = mysqli_query($link, $sql_parte);
	
	while ($parte=mysqli_fetch_assoc($res_parte)) {
		$array_parte[] = array(
			'nm_cliente'	=> $parte['nm_cliente'],
			//'parte' => $parte['parte'],
			//'ds_descricao' => $parte['ds_descricao'],
		);
	}
	
	

	echo(json_encode($array_parte));
$link->close();
?>