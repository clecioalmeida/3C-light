<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION['cod_cli'];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_prod 			= $_POST['cod_cli'];

$sql_parte = "select cod_produto, nm_produto, cod_prod_cliente from tb_produto where cod_prod_cliente = '$cod_prod' and fl_status = 'A' and fl_empresa = '$cod_cli'";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte = mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		'info'			=> '0',
		'cod_produto'	=> $parte['cod_prod_cliente'],
		'nm_produto'  	=> $parte['cod_prod_cliente']." - ".$parte['nm_produto'],
	);
}

echo (json_encode($array_parte));
$link->close();
?>