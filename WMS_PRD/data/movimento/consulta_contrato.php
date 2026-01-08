<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$cod_cliente = $_REQUEST['cod_cliente'];
	
	$select_dest = "select *  from tb_contrato where id_cliente = '$cod_cliente'";
	$res_dest = mysqli_query($link,$select_dest);
	
	while ($dest=mysqli_fetch_assoc($res_dest)) {
		$array_dest[] = array(
			'id'	=> $dest['id'],
			'ds_descricao' => $dest['ds_descricao'],
		);
	}

	echo(json_encode($array_dest));

$link->close();
?>