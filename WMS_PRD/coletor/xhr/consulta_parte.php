<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_torre = $_REQUEST['id_torre'];

	$query="SET SQL_BIG_SELECTS=1";
	$res_query=mysqli_query($link, $query);
	
	$sql_parte = "select t1.id, t1.parte from tb_tp_torre t1 left join tb_tipo_torre t2 on t1.id_torre = t2.id where t2.id = '$id_torre'";
	$res_parte = mysqli_query($link, $sql_parte);
	
	while ($parte=mysqli_fetch_assoc($res_parte)) {
		$array_parte[] = array(
			'id'	=> $parte['id'],
			'parte' => $parte['parte'],
			//'ds_descricao' => $parte['ds_descricao'],
		);
	}
	
	

	echo(json_encode($array_parte));

