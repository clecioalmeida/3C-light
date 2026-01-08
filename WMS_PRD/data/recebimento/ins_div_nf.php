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

$ds_div = $_POST['ds_div'];

$sql = "insert into tb_div_nf (ds_divergencia, fl_empresa, usr_create, dt_create) values ('$ds_div', '$cod_cli', '$id', '$date')";
$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {

	echo "Divergência criada com sucesso.";

} else {

	echo "Erro no cadastro.";

}

$link->close();
?>