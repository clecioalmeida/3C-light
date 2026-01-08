<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto = $_REQUEST['cod_produto'];
$nr_pedido = $_REQUEST['nr_pedido'];

$sql_col = "select distinct produto from tb_posicao_pallet where cod_produto = '$cod_produto' and fl_bloq = 'S'";
$res_col = mysqli_query($link, $sql_col);

if (mysqli_num_rows($res_col) > 0) {

	$retorno[] = array(
		'info' => "0",
	);
	echo (json_encode($retorno));

}else{

	$query_sts = "select distinct fl_status from tb_pedido_coleta_produto where nr_pedido = '$nr_pedido'";
	$res_sts = mysqli_query($link, $query_sts);
	while ($status = mysqli_fetch_assoc($res_sts)) {
		$retorno[] = array(
			'info' => "1",
			'status' => $status['fl_status'],
		);
	}
	echo (json_encode($retorno));
}

$link->close();
?>