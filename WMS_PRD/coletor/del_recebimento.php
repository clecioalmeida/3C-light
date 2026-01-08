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

$cod_rec 			= $_POST['cod_rec'];

$sql = "update tb_recebimento_ag set
	fl_status = 'E'
    where cod_recebimento = '$cod_rec'";
$res_id = mysqli_query($link, $sql);

if (mysqli_affected_rows($link) > 0) {

	$retorno = array(
		'info' => "0",
	);

	echo (json_encode($retorno));
} else {

	$retorno = array(
		'info' => "1",
	);

	echo (json_encode($retorno));
}

$link->close();