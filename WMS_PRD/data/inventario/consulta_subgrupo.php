<?php 
	require_once('bd_class_dsv.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$cod_grupo = $_REQUEST['id_grupo'];
	
	$sql_sgrupo = "select cod_sub_grupo, nm_sub_grupo from tb_sub_grupo where cod_grupo = '$cod_grupo'";
	$res_sgrupo = mysqli_query($link, $sql_sgrupo);
	
	while ($sgrupo=mysqli_fetch_assoc($res_sgrupo)) {
		$array_sgrupo[] = array(
			'cod_sub_grupo' => $sgrupo['cod_sub_grupo'],
			'nm_sub_grupo' => $sgrupo['nm_sub_grupo'],
		);
	}
	
	

	echo(json_encode($array_sgrupo));
$link->close();
?>