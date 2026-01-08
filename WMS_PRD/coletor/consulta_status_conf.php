<?php
require_once 'xhr/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_POST['id_inv'];
$id_local = $_POST['id_local'];
$id_rua = $_POST['id_rua'];
$id_coluna = $_POST['id_coluna'];

$sql_end = "select status_conf from tb_inv_conf where id_";
$res_end = mysqli_query($link, $sql_end);

while ($end = mysqli_fetch_assoc($res_end)) {
	$array_end[] = array(
		'id_altura' => $end['id_altura'],
	);
}

echo (json_encode($array_end));
$link->close();
?>