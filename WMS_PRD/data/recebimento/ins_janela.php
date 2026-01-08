<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
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

$dt_janela 			= $_POST['dt_janela'];
$hr_janela 			= $_POST['hr_janela'];
$ds_solicitante   	= $_POST['ds_solicitante'];
$ds_motivo   		= $_POST['ds_motivo'];

$sql = "insert into tb_janela (dt_janela, ds_janela, ds_solicitante, ds_motivo, fl_status, fl_tipo, fl_empresa, usr_create, dt_create) values ('$dt_janela', '$hr_janela', '$ds_solicitante', '$ds_motivo', 'A', 'E', '$cod_cli', '$id', '$date')";
$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {

	echo "Janela adicional criada com sucesso.";

} else {

	echo "Erro no cadastro.";

}

$link->close();
?>