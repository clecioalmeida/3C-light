<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_galpao = $_REQUEST['id_galpao'];
	
	$sql_parte = "SELECT distinct rua, rua FROM tb_endereco where galpao = '$id_galpao'";
	$res_parte = mysqli_query($link, $sql_parte);
	
	while ($parte=mysqli_fetch_assoc($res_parte)) {
		$array_parte[] = array(
			//'id'	=> $parte['id'],
			'rua' => $parte['rua'],
			//'ds_descricao' => $parte['ds_descricao'],
		);
	}
	
	

	echo(json_encode($array_parte));