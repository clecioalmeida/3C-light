<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$rua = $_REQUEST['id_rua'];
	$galpao = $_REQUEST['id_galpao'];
	$coluna = $_REQUEST['id_coluna'];
	
	$sql_col = "select distinct altura from tb_endereco where galpao = '$galpao' and rua = '$rua' and coluna = '$coluna'";
	$res_col = mysqli_query($link, $sql_col);
	
	while ($col=mysqli_fetch_assoc($res_col)) {
		$array_end[] = array(
			'altura' => $col['altura'],
		);
	}
	
	

	echo(json_encode($array_end));
$link->close();
?>