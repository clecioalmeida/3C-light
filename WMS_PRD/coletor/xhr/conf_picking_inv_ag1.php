<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$localInv 		= $_POST['localInv'];
$barcode 		= $_POST['barcode'];
$nr_qtde_inv 	= $_POST['nr_qtde_inv'];
$nr_vol_inv 	= $_POST['nr_vol_inv'];
$nr_tar 		= $_POST['nr_tar'];

$end = explode("-", $localInv);

$id_end = $end[0];
$rua = strtoupper($end[1]);
$col = $end[2];
$alt = $end[3];

$cod_prod_cliente = explode("-", $barcode);

$cod_cliente 	= $cod_prod_cliente[0];
$id_etq 		= $cod_prod_cliente[1];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_tar = "select id_estoque, id_etq
from tb_inv_tarefa
where id = '$nr_tar'";
$res_tar = mysqli_query($link, $sql_tar);
while ($tarefa = mysqli_fetch_assoc($res_tar)) {
	$id_estoque 	= $tarefa['id_estoque'];
	$id_etiqueta 	= $tarefa['id_etq'];

	if($id_etiqueta == $id_etq){

		$query_init = "select cod_produto, nm_produto
		from tb_produto
		where cod_prod_cliente = '$barcode'";
		$res_init = mysqli_query($link, $query_init);
		while ($init = mysqli_fetch_assoc($res_init)) {
			$cod_produto = $init['cod_produto'];
			$nm_produto = $init['nm_produto'];
		}

		$ins_conf = "INSERT into tb_inv_conf (id_tar, cont_1, cont_2, dt_conf_1, user_create, dt_create) values ('$nr_tar', '$nr_qtde_inv', '0', '$date', '$id', '$date')";
		$res_conf = mysqli_query($link, $ins_conf);

		$retorno = array(
			'info' => "Tarefa gravada com sucesso.",
		);

		echo(json_encode($retorno));


	}else{

		$retorno = array(
			'info' => "Volume bipado não é o volume solicitado no inventário.",
		);

		echo(json_encode($retorno));

	}

}

$link->close();
$link1->close();
?>