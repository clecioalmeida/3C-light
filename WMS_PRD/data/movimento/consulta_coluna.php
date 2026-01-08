<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rua = $_REQUEST['id_rua'];
$id_galpao = $_REQUEST['id_galpao'];

$sql_coluna = "SELECT distinct ds_coluna FROM tb_posicao_pallet where ds_prateleira = '$id_rua' and ds_galpao = '$id_galpao' order by ds_coluna asc";
$res_coluna = mysqli_query($link, $sql_coluna);

while ($coluna = mysqli_fetch_assoc($res_coluna)) {
	$array_coluna[] = array(
		//'id'	=> $parte['id'],
		'coluna' => $coluna['ds_coluna'],
		//'ds_descricao' => $parte['ds_descricao'],
	);
}

echo (json_encode($array_coluna));
$link->close();
?>