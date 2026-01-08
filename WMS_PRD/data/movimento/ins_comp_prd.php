<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {


	$id 		= $_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto 	= $_REQUEST['cod_produto'];
$nr_qtde_pedido = $_REQUEST['nr_qtde_pedido'];
$nr_doc_comp 	= $_REQUEST['nr_doc_comp'];
$nr_pedido 		= $_REQUEST['nr_pedido'];
$ds_rua 		= $_REQUEST['ds_rua'];
$ds_coluna 		= $_REQUEST['ds_coluna'];
$ds_altura 		= $_REQUEST['ds_altura'];

$ins_qtde = "insert into tb_pedido_coleta_produto (nr_pedido, produto, nr_qtde, nr_qtde_conf, nr_qtde_exp, nr_doc_comp, fl_status, fl_tipo, fl_empresa, fl_conferido, usr_fim_conf, dt_fim_conf, usr_fim_coleta, dt_fim_coleta, usr_lib_exp, dt_lib_exp, usr_create, dt_create) values ('$nr_pedido', '$cod_produto', '$nr_qtde_pedido', '$nr_qtde_pedido', '$nr_qtde_pedido', '$nr_doc_comp', 'F', 'C', '$cod_cli', 'S', '$id', '$date', '$id', '$date', '$id', '$date','$id', '$date')";
$res_ins_qtde = mysqli_query($link, $ins_qtde);
$nCod = mysqli_insert_id($ins_qtde);

$ins_conf = "insert into tb_pedido_conferencia (cod_col, nr_pedido, produto, ds_prateleira, ds_coluna, ds_altura, nr_qtde, fl_conferido, fl_status, usr_create, dt_create) values ('$nCod', '$nr_pedido', '$cod_produto', '$ds_rua', '$ds_coluna', '$ds_altura', '$nr_qtde_pedido', 'C', 'F', '$id', '$date')";
$res_conf = mysqli_query($link, $ins_conf);

if ($res_conf) {

	$retorno[] = array(
		'info' => "1",
	);
	echo (json_encode($retorno));

} else {

	$retorno[] = array(
		'info' => "4",
	);
	echo (json_encode($retorno));

	exit();

}

$link->close();
?>