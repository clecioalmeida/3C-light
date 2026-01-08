<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_galpao = $_REQUEST['id_galpao'];

$sql_parte = "SELECT distinct rua FROM tb_endereco where galpao = '$id_galpao' order by rua asc";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte = mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		'rua' => $parte['rua'],
	);
}

echo (json_encode($array_parte));
$link->close();
?>