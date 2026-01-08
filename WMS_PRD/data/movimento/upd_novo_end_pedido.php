<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$cod_col = $_REQUEST['cod_col'];
$cod_produto = $_REQUEST['cod_produto'];
$ds_galpao = $_REQUEST['ds_galpao'];
$ds_prateleira = $_REQUEST['ds_prateleira'];
$ds_coluna = $_REQUEST['ds_coluna'];
$ds_altura = $_REQUEST['ds_altura'];
$nr_qtde = $_REQUEST['nr_qtde'];
$nr_qtde_new = $_REQUEST['nr_qtde_new'];
$nr_qtde_old = $_REQUEST['nr_qtde_old'];
$id_pedido = $_REQUEST['id_pedido'];
//$cod_estoque = $_REQUEST['cod_estoque'];

$query_produto = "select produto, cod_estoque from tb_posicao_pallet where ds_galpao = '$ds_galpao' and ds_prateleira = '$ds_prateleira' and ds_coluna = '$ds_coluna' and ds_altura = '$ds_altura' and produto = '$cod_produto'";
$res_produto = mysqli_query($link, $query_produto);
$tr = mysqli_num_rows($res_produto);

if ($tr > 0) {

	while ($dados = mysqli_fetch_assoc($res_produto)) {
		$cod_estoque = $dados['cod_estoque'];

		echo $cod_estoque;

		$update_end = "update tb_coleta_pedido set nr_qtde_col = '$nr_qtde' where cod_col = '$cod_col'";
		$res_upd = mysqli_query($link, $update_end);

		$insert_end = "insert into tb_coleta_pedido (nr_pedido, produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_qtde_col, fl_status, cod_estoque, usr_create, dt_create) values ('$id_pedido', '$cod_produto', '$ds_galpao', '$ds_prateleira', '$ds_coluna', '$ds_altura', '$nr_qtde_new', 'M', '$cod_estoque', '$id', now())";
		$res_ins = mysqli_query($link1, $insert_end);

		if (mysqli_affected_rows($link1)) {

			$array_info[] = array(
				'info' => "0",
			);
			echo (json_encode($array_info));

		} else {

			$array_info[] = array(
				'info' => "1",
			);
			echo (json_encode($array_info));
		}
	}

} else {

	$array_info[] = array(
		'info' => "2",
	);
	echo (json_encode($array_info));

}
$link->close();
?>