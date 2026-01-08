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

$criticidade 		= $_POST['criticidade'];
$tipo 				= $_POST['tipo'];
$cod_origem 		= $_POST['cod_origem'];
$nm_ocorrencia 		= $_POST['nm_ocorrencia'];
$ds_responsavel 	= $_POST['ds_responsavel'];
$nm_depto 			= $_POST['nm_depto'];
$dt_final 			= $_POST['dt_final'];
$ds_obs 			= $_POST['ds_obs'];

$sql = "insert into tb_ocorrencias (nm_ocorrencia, tipo, ds_responsavel, nm_depto, criticidade, dt_abertura, fl_status,	cod_origem, ds_obs, fl_empresa, user_create, dt_create) values ('$nm_ocorrencia', '$tipo', '$ds_responsavel', '$nm_depto', '$criticidade', '$date', 'A', '$cod_origem', '$ds_obs', '$cod_cli', '$id', '$date')";
$resultado_id = mysqli_query($link, $sql);


if (mysqli_affected_rows($link)){

		echo "Ocorrência cadastrada com sucesso!";


}else{

		echo "Erro no cadastro!";

}

$link->close();
?>