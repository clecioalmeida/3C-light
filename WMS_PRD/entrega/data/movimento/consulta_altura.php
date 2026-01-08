<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_coluna = $_REQUEST['id_coluna'];
	
	$sql_parte = "SELECT distinct altura FROM tb_endereco where coluna = '$id_coluna'";
	$res_parte = mysqli_query($link, $sql_parte);
	
	while ($parte=mysqli_fetch_assoc($res_parte)) {
		$array_parte[] = array(
			//'id'	=> $parte['id'],
			'altura' => $parte['altura'],
			//'ds_descricao' => $parte['ds_descricao'],
		);
	}
	
	

	echo(json_encode($array_parte));