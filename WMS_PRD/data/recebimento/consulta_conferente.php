<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();
	
	$sql_usr = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'U' and fl_status = 1 and fl_nivel = 2" or die(mysqli_error($sql_usr));
	$res_usr = mysqli_query($link, $sql_usr);
	
	while ($conf=mysqli_fetch_assoc($res_usr)) {
		$array_conf[] = array(
			//'id'	=> $parte['id'],
			'cod_cliente' => $conf['cod_cliente'],
			'nm_cliente' => $conf['nm_cliente'],
		);
	}
	
	

	echo(json_encode($array_conf));
$link->close();
?>