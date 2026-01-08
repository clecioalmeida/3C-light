<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id = $_REQUEST['id'];
	
	$sql_parte = "SELECT * FROM tb_doca where ds_local = '$id'";
	$res_parte = mysqli_query($link, $sql_parte);
	
	while ($parte=mysqli_fetch_assoc($res_parte)) {
		$array_parte[] = array(
			'id'	=> $parte['id'],
			'fl_tipo' => $parte['fl_tipo'],
			'ds_doca' => $parte['ds_doca'],
		);
	}	

	echo(json_encode($array_parte));
$link->close();
?>