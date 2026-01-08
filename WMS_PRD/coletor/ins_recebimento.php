<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nm_fornecedor 		= strtoupper(trim($_POST['nm_fornecedor']));
$nr_placa 			= strtoupper(trim($_POST['nr_placa']));
$nm_mot 			= strtoupper(trim($_POST['nm_mot']));
$dt_recebimento 	= $_POST['dt_recebimento'];
$ds_galpao 			= $_POST['ds_galpao'];
$ds_endereco 		= explode('-',strtoupper($_POST['ds_endereco']));
$id_end 			= $ds_endereco[0];
$ds_rua 			= $ds_endereco[1];
$ds_coluna 			= $ds_endereco[2];
$ds_altura 			= $ds_endereco[3];
$cod_produto 		= $_POST['cod_produto'];
$nr_serial 			= $_POST['nr_serial'];
$ds_material        = $_POST['ds_material'];
$ds_kva 			= strtoupper($_POST['ds_kva']);
$ds_lp 				= strtoupper($_POST['ds_lp']);
$ds_ano 			= strtoupper($_POST['ds_ano']);
$ds_enr 			= strtoupper($_POST['ds_enr']);
$ds_fabr 			= strtoupper($_POST['ds_fabr']);
$ds_obs 			= strtoupper($_POST['ds_obs']);
$nr_qtde 			= str_replace(",", ".", $_POST['nr_qtde']);

$sql = "INSERT into tb_recebimento_ag (
	cod_cli, nm_fornecedor, nm_placa, nm_motorista, fl_status, dt_recebimento_real, fl_empresa, 
	id_end, ds_galpao, ds_rua, ds_coluna, ds_altura, ds_kva, ds_lp, ds_ano, ds_fabr, cod_produto, 
	nr_serial, nr_qtde, usr_create, dt_create, ds_enr
	) values (
		'5', '$nm_fornecedor', '$nr_placa', '$nm_mot', 'A', '$dt_recebimento', '5','$id_end', '$ds_galpao', '$ds_rua', 
		'$ds_coluna', '$ds_altura','$ds_kva','$ds_lp','$ds_ano','$ds_fabr', '$cod_produto','$nr_serial','$nr_qtde', 
		'$id', '$date', '$ds_material'
		)";

$res_id = mysqli_query($link, $sql);
$nRec = mysqli_insert_id($link);

if (mysqli_affected_rows($link) > 0) {

	$retorno = array(
		'info' => "0",
		'id_rec' => $nRec,
	);

	echo (json_encode($retorno));
} else {

	$retorno = array(
		'info' => "1",
	);

	echo (json_encode($retorno));
}

$link->close();