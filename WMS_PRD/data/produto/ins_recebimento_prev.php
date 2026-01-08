<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli  	= $_SESSION['cod_cli'];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nm_fornecedor 				= "REPOSIÇÃO";
$dt_recebimento_previsto 	= $_POST['dt_prev'][0];
$tp_recebimento 			= "N";
$tp_prd 					= "N";	

$sql = "insert into tb_recebimento (cod_cli, nm_fornecedor, dt_recebimento_previsto, tp_recebimento, tp_prd, fl_status, fl_empresa, usr_create, dt_create) values ($cod_cli, '$nm_fornecedor', '$dt_recebimento_previsto', '$tp_recebimento', '$tp_prd', 'A', '$cod_cli', '$id', '$date')";
$resultado_id = mysqli_query($link, $sql);
$nRec = mysqli_insert_id($link);


if ($resultado_id) {

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
?>