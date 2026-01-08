<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_conf 	= $_POST['cod_exp'];
$nr_qtde 	= $_POST['nr_qtde_exp'];

$sql = "update tb_pedido_coleta_produto set nr_qtde_exp = '$nr_qtde' WHERE cod_ped = '$cod_conf'";
$resultado_id = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){

	echo "Conferência alterada!";

}else{

	echo "Conferência não pode ser alterada.";

}

$link->close();
?>