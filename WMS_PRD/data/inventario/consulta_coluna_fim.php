<?php 
	require_once('bd_class_dsv.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$rua = $_REQUEST['rua_fim'];
	$galpao = $_REQUEST['galpao'];
	$coluna = $_REQUEST['coluna_ini'];
	
	$sql_col = "select distinct coluna from tb_endereco where galpao = '$galpao' and rua = '$rua' and coluna >= '$coluna'";
	$res_col = mysqli_query($link, $sql_col);
	
	while ($col=mysqli_fetch_assoc($res_col)) {
		$array_end[] = array(
			'coluna' => $col['coluna'],
		);
	}	

	echo(json_encode($array_end));
$link->close();
?>