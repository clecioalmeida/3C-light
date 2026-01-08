<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$cod_rec = $_REQUEST['cod_rec'];
	
	$sql_glp = "select distinct ds_galpao from tb_posicao_pallet where nr_nf_entrada = '$cod_rec'" or die(mysqli_error($sql_glp));
	$res_glp = mysqli_query($link, $sql_glp);
	
	while ($glp=mysqli_fetch_assoc($res_glp)) {
		$array_glp[] = array(
			'ds_galpao' => $glp['ds_galpao'],
		);
	}
	
	echo(json_encode($array_glp));
$link->close();
?>