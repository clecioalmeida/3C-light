<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_pedido = $_REQUEST['id_pedido'];
$cod_prod = $_REQUEST['cod_produto'];

$sql_parte = "SELECT sum(nr_qtde_conf) as total FROM tb_coleta_pedido where nr_pedido = '$id_pedido' and produto = '$cod_prod'";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte = mysqli_fetch_assoc($res_parte)) {
	$total = $parte['total'];
	if ($total > 0) {

		$array_info[] = array(
			'info' => "1",
		);
		echo (json_encode($array_info));

	} else {

		$array_info[] = array(
			'info' => "0",
		);
		echo (json_encode($array_info));
	}
}
$link->close();
?>