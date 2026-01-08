<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

//$idOp = $_REQUEST['idOp'];

$sql_parte = "SELECT cod_fornecedor, nm_fornecedor 
from tb_fornecedor where fl_status = 'A'";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte = mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		'id_forn' => $parte['cod_fornecedor'],
		'nm_for' => $parte['nm_fornecedor'],
	);
}

echo (json_encode($array_parte));
$link->close();
?>