<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rua = $_REQUEST['id_rua'];
$id_galpao = $_REQUEST['id_galpao'];

$sql_coluna = "SELECT distinct coluna FROM tb_endereco where rua = '$id_rua' and galpao = '$id_galpao'";
$res_coluna = mysqli_query($link, $sql_coluna);

while ($coluna = mysqli_fetch_assoc($res_coluna)) {
	$array_coluna[] = array(
		'coluna' => $coluna['coluna'],
	);
}

echo (json_encode($array_coluna));
$link->close();
?>