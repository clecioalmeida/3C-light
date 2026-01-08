<?php
require_once 'bd_class_dsv.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_REQUEST['id_inv'];

$sql_end = "select distinct id_rua from tb_inv_tarefa where id_inv = '$id_inv' order by id_rua asc";
$res_end = mysqli_query($link, $sql_end);

while ($end = mysqli_fetch_assoc($res_end)) {
	$array_end[] = array(
		'id_rua' => $end['id_rua'],
	);
}

echo (json_encode($array_end));
$link->close();
?>