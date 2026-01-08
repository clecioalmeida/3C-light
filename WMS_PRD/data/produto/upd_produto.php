<?php
session_start();  
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
	$cod_cli  	= $_SESSION['cod_cli'];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto 		= $_POST['cod_produto'];
$nm_cliente 		= $_POST['nm_cliente'];
$nm_produto 		= $_POST['nm_produto'];
$cod_prod_cliente 	= $_POST['cod_prod_cliente'];
$tp_separacao 		= $_POST['tp_separacao'];
$codncm 			= $_POST['codncm'];
$ean 				= $_POST['ean'];
$fl_lote 			= $_POST['fl_lote'];
$peso 				= $_POST['peso'];
$curva 				= $_POST['curva'];
$peso_bruto 		= $_POST['peso_bruto'];
$detalhe_produto 	= $_POST['detalhe_produto'];
$nr_estoque_min 	= $_POST['nr_estoque_min'];
$unid 				= $_POST['unid'];
$volume 			= $_POST['volume'];
$unid_controle 		= $_POST['unid_controle'];
$altura 			= $_POST['altura'];
$compr 				= $_POST['compr'];
$largura 			= $_POST['largura'];
$cod_identificacao 	= $_POST['cod_identificacao'];
$multiplo 			= $_POST['multiplo'];
$aloc_aut 			= $_POST['aloc_aut'];

$sql = "update tb_produto set nm_produto ='$nm_produto', tp_separacao ='$tp_separacao', codncm ='$codncm', ean ='$ean', fl_lote ='$fl_lote', peso ='$peso', curva ='$curva', peso_bruto ='$peso_bruto', detalhe_produto ='$detalhe_produto', nr_estoque_min ='$nr_estoque_min', unid ='$unid', volume ='$volume', unid_controle ='$unid_controle', compr ='$compr', largura ='$largura', altura ='$altura', cod_identificacao ='$cod_identificacao', multiplo ='$multiplo',  aloc_aut ='$aloc_aut', usr_update = '$id', dt_update = '$date' WHERE cod_produto = '$cod_produto'" or die(mysqli_error($sql));

$resultado_id = mysqli_query($link, $sql);

if($resultado_id){

	echo 'Dados cadastrados com sucesso';

} else {
	echo 'Dados não cadastrados';

}
$link->close();

?>