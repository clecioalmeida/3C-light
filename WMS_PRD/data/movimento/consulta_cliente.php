<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$cod_cliente_pedido = $_REQUEST['cod_cliente_pedido'];
	
	$select_dest = "select cod_cliente, nm_cliente, nr_cnpj_cpf, ds_ie_rg from tb_cliente where cod_cliente = '$cod_cliente_pedido'";
	$res_dest = mysqli_query($link,$select_dest);
	
	while ($dest=mysqli_fetch_assoc($res_dest)) {
		$array_dest[] = array(
			'cod_cliente'	=> $dest['cod_cliente'],
			'nr_cnpj_cpf' => $dest['nr_cnpj_cpf'],
			'ds_ie_rg' => $dest['ds_ie_rg'],
		);
	}

	echo(json_encode($array_dest));

$link->close();
?>