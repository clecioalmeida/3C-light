<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rua = $_REQUEST['id_rua'];
$id_inv = $_REQUEST['id_inv'];

$sql_end = "select distinct id_coluna from tb_inv_tarefa where id_inv = '$id_inv' and id_rua = '$id_rua' order by id_coluna asc";
$res_end = mysqli_query($link, $sql_end);

while ($end = mysqli_fetch_assoc($res_end)) {
	$array_end[] = array(
		'id_coluna' => $end['id_coluna'],
	);
}

echo (json_encode($array_end));
$link->close();
?>