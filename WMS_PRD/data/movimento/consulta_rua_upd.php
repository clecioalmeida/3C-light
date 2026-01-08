<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_galpao = $_REQUEST['id_galpao'];
$cod_prod = $_REQUEST['cod_prod'];

$sql_parte = "SELECT distinct ds_prateleira FROM tb_posicao_pallet where ds_galpao = '$id_galpao' and produto = '$cod_prod'";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte = mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		'rua' => $parte['ds_prateleira'],
	);
}

echo (json_encode($array_parte));
$link->close();
?>