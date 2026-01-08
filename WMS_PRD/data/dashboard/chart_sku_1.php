<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id         = $_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}

?>
<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

/* PESO TRANSPORTADOR POR DIA */

$sql="select count(produto) as total_sku
from tb_posicao_pallet
where fl_empresa = '$cod_cli' and fl_status <> 'E'
group by produto";
$res = mysqli_query($link, $sql);

$total_sku = mysqli_num_rows($res);

$array_parte[] = array(
	'info'			=> '0',
	'mes' 			=> "Dezembro",
	'total_sku' 	=> $total_sku,
);
echo (json_encode($array_parte));
$link->close();
?>
