<?php
require_once 'xhr/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_REQUEST['id_inv'];

$sql_end = "select t1.id, t1.id_galpao, t2.ds_apelido, t2.nome
from tb_inv_prog t1
left join tb_armazem t2 on t1.id_galpao = t2.id
where t1.id = '$id_inv'";
$res_end = mysqli_query($link, $sql_end);

while ($end = mysqli_fetch_assoc($res_end)) {
	$array_end[] = array(
		'id_galpao' => $end['id_galpao'],
		'nome' => $end['nome'],
		'ds_apelido' => $end['ds_apelido'],
	);
}

echo (json_encode($array_end));
$link->close();
?>