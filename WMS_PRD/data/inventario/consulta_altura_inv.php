<?php 
	require_once('bd_class_dsv.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_coluna = $_REQUEST['id_coluna'];
	$rua = $_REQUEST['id_rua'];
	$id_galpao_inv = $_REQUEST['id_galpao_inv'];
	
	$sql_parte = "SELECT distinct altura FROM tb_endereco where coluna = '$id_coluna' and  rua = '$rua' and galpao = '$id_galpao_inv'";
	$res_parte = mysqli_query($link, $sql_parte);
	
	while ($parte=mysqli_fetch_assoc($res_parte)) {
		$array_parte[] = array(
			//'id'	=> $parte['id'],
			'altura' => $parte['altura'],
			//'ds_descricao' => $parte['ds_descricao'],
		);
	}	

	echo(json_encode($array_parte));
$link->close();
?>