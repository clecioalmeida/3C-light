<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id=$_SESSION["id"];
}
?>
<?php
require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_cli 			= $_POST['cod_cli'];
$nm_produto 		= $_POST['nm_produto'];
$cod_prod_cliente 	= $_POST['cod_prod_cliente'];
$codncm 			= $_POST['codncm'];
$ean 				= $_POST['ean'];
$peso 				= $_POST['peso'];
$peso_bruto 		= $_POST['peso_bruto'];
$detalhe_produto 	= $_POST['detalhe_produto'];
$nr_estoque_min 	= $_POST['nr_estoque_min'];
$unid 				= $_POST['unid'];
$volume 			= $_POST['volume'];
$unid_controle 		= $_POST['unid_controle'];
$altura 			= $_POST['altura'];
$cod_grupo 			= $_POST['cod_grupo'];
$cod_sub_grupo 		= $_POST['cod_sub_grupo'];
$compr 				= $_POST['compr'];
$largura 			= $_POST['largura'];
$cod_identificacao 	= $_POST['cod_identificacao'];
$multiplo 			= $_POST['multiplo'];
$id_armazem 		= $_POST['id_armazem'];

$sql = " insert into tb_produto (cod_cli, nm_produto, cod_prod_cliente, codncm, ean, peso, peso_bruto, detalhe_produto, nr_estoque_min, unid, volume, unid_controle, altura, cod_grupo, cod_sub_grupo, compr, largura, cod_identificacao, multiplo, id_armazem, fl_status, user_create, dt_create) values ('$cod_cli', '$nm_produto',  '$cod_prod_cliente', '$codncm', '$ean', '$peso', '$peso_bruto', '$detalhe_produto', '$nr_estoque_min', '$unid', '$volume', '$unid_controle', '$altura', '$cod_grupo', '$cod_sub_grupo', '$compr', '$largura', '$cod_identificacao', '$multiplo', '$id_armazem', 'A', '$id', now())";
$resultado_id = mysqli_query($link, $sql);
$nPrd = mysqli_insert_id($link);

if(mysqli_affected_rows($link) > 0){
	$array_conf = array(
		'info' => "0",
		"cod_produto" = $nPrd,
		"cod_prod_cliente" = $cod_prod_cliente,
		"nm_produto" = $nm_produto,
	);

	echo(json_encode($array_conf));
}else{

	$array_conf = array(
		'info' => "Não foi possível cadastrar o produto.",
	);

	echo(json_encode($array_conf));

}

$link->close();
?>