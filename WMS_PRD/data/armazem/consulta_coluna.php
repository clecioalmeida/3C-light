<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rua = $_REQUEST['id_rua'];

$sql_parte = "SELECT distinct coluna FROM tb_endereco where rua = '$id_rua' order by coluna+0 asc";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte = mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		'coluna' => $parte['coluna'],
	);
}

echo (json_encode($array_parte));
$link->close();
?>