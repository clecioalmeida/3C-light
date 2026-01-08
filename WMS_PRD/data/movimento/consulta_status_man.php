<?php

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_REQUEST['nr_pedido'];

$sql = "select distinct nr_pedido from tb_pedido_manuseio where nr_pedido = '$nr_pedido'";
$res = mysqli_query($link, $sql);
//$tr = mysqli_num_rows($res);
if (mysqli_num_rows($res) > 0) {

	$retorno[] = array(
		'info' => "0",
	);

	echo (json_encode($retorno));

} else {

	$retorno[] = array(
		'info' => "1",
	);

	echo (json_encode($retorno));

}
$link->close();
?>