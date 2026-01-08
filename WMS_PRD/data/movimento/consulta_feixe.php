<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rua = $_REQUEST['id_rua'];
$id_modulo = $_REQUEST['id_modulo'];

$sql_end = "select distinct ds_embalagem from tb_posicao_pallet where ds_prateleira = '$id_rua' and ds_coluna = '$id_modulo' order by ds_embalagem asc";
$res_end = mysqli_query($link, $sql_end);

while ($end = mysqli_fetch_assoc($res_end)) {
	$array_end[] = array(
		'ds_embalagem' => $end['ds_embalagem'],
	);
}

echo (json_encode($array_end));
$link->close();
?>