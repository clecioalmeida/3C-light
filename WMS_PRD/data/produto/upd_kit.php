<?php
	require_once("bd_class.php");
	
	$id = $_POST['id'];
	$descricao = $_POST['descricao'];
	$ean = $_POST['ean'];
	$controle_lote = $_POST['controle_lote'];
	$detalhe_kit = $_POST['detalhe_kit'];
	$estoque_minimo = $_POST['estoque_minimo'];
	$volume_padrao = $_POST['volume_padrao'];
	$cod_identificacao = $_POST['cod_identificacao'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$sql = "update tb_kit set descricao = '$descricao', ean = '$ean', controle_lote = '$controle_lote', detalhe_kit = '$detalhe_kit', estoque_minimo = '$estoque_minimo', volume_padrao = '$volume_padrao', cod_identificacao = '$cod_identificacao' WHERE id = '$id' ";

	
	$resultado_id = mysqli_query($link, $sql);
 
		if($resultado_id){
		 
		    echo 'Dados alterados com sucesso';
		 
		} else {
		    echo 'Dados não alterados';

		};

		$link->close();

?>