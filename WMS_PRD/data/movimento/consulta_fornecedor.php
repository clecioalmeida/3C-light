<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_parte = "select cod_cliente, nm_cliente from tb_cliente where fl_status = 'A' and fl_tipo = 'F'";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte = mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		'cod_cliente'	=> $parte['cod_cliente'],
		'nm_cliente'  	=> $parte['nm_cliente'],
	);
}

echo (json_encode($array_parte));
$link->close();
?>