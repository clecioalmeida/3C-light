<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_coluna = $_REQUEST['id_coluna'];
$cod_prod = $_REQUEST['cod_prod'];

$sql_parte = "SELECT distinct ds_altura FROM tb_posicao_pallet where ds_coluna = '$id_coluna' and produto = '$cod_prod'";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte = mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		'altura' => $parte['ds_altura'],
	);
}

echo (json_encode($array_parte));
$link->close();
?>