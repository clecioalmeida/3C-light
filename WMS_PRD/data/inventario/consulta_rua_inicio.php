<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$galpao = $_REQUEST['id_galpao'];

$sql_end = "select distinct rua from tb_endereco where galpao = '$galpao' order by rua";
$res_end = mysqli_query($link, $sql_end);

while ($end = mysqli_fetch_assoc($res_end)) {
	$array_end[] = array(
		'rua' => $end['rua'],
	);
}

echo (json_encode($array_end));
$link->close();
?>