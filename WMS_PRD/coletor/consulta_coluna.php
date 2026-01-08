<?php
require_once 'xhr/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_REQUEST['id_inv'];
$id_local = $_REQUEST['id_local'];
$id_rua = $_REQUEST['id_rua'];

$sql_end = "select distinct id_coluna
from tb_inv_tarefa
where id_inv = '$id_inv' and id_galpao = '$id_local' and id_rua = '$id_rua'";
$res_end = mysqli_query($link, $sql_end);

while ($end = mysqli_fetch_assoc($res_end)) {
	$array_end[] = array(
		'id_coluna' => $end['id_coluna'],
	);
}

echo (json_encode($array_end));
$link->close();
?>