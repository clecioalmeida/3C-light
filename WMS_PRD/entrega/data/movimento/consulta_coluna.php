<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_rua = $_REQUEST['id_rua'];
	
	$sql_coluna = "SELECT distinct coluna, id FROM tb_endereco where rua = '$id_rua'";
	$res_coluna = mysqli_query($link, $sql_coluna);
	
	while ($coluna=mysqli_fetch_assoc($res_coluna)) {
		$array_coluna[] = array(
			'id'	=> $coluna['id'],
			'coluna' => $coluna['coluna'],
			//'ds_descricao' => $parte['ds_descricao'],
		);
	}
	
	

	echo(json_encode($array_coluna));