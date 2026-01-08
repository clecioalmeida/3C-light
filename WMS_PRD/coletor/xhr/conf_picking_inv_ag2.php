<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id=$_SESSION["id"];
	$cod_cli=$_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$localInv = $_POST['localInv'];
$barcode = $_POST['barcode'];
$nr_qtde_inv = $_POST['nr_qtde_inv'];
$nr_vol_inv = $_POST['nr_vol_inv'];
$nrInvConf = $_POST['nrInvConf'];

$end = explode("-", $localInv);

$id_end = $end[0];
$rua = strtoupper($end[1]);
$col = $end[2];
$alt = $end[3];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$query_init = "select cod_produto, nm_produto
from tb_produto
where cod_prod_cliente = '$barcode'";
$res_init = mysqli_query($link, $query_init);
while ($init = mysqli_fetch_assoc($res_init)) {
	$cod_produto = $init['cod_produto'];
	$nm_produto = $init['nm_produto'];
}

$query_tar = "select id
from tb_inv_tarefa
where id_inv = '$nrInvConf' and id_produto = '$cod_produto' and id_rua = '$rua' and id_coluna = '$col' and id_altura = '$alt'";
$res_tar = mysqli_query($link, $query_tar);

if(mysqli_num_rows($res_tar) > 0){

	$tar = mysqli_fetch_assoc($res_tar);
	$tarefa = $tar['id'];

	$upd_tar = "update tb_inv_conf set cont_2 = '$nr_qtde_inv' where id_tar = '$tarefa'";
	$res_tar = mysqli_query($link1, $upd_tar);

		$retorno = array(
			'info' => "Tarefa alterada com sucesso.",
			'tarefa' => $tarefa,
		);

		echo(json_encode($retorno));


}else{

	$upd_col = "INSERT into tb_inv_tarefa (id_inv, id_produto, id_galpao, id_rua, id_coluna, id_altura, nr_volume, fl_status, fl_tipo, fl_empresa, user_create, dt_create) values ('$nrInvConf', '$cod_produto', '', '$rua', '$col', '$alt', '$nr_vol_inv', 'A', 'R', '$cod_cli', '$id', '$date')";
	$res_col = mysqli_query($link1, $upd_col);

	$nTar=mysqli_insert_id($link1);

	if($res_col){

		$ins_conf = "INSERT into tb_inv_conf (id_tar, cont_1, dt_conf_1, user_create, dt_create) values ('$nTar', '$nr_qtde_inv', '$date', '$id', '$date')";
		$res_conf = mysqli_query($link, $ins_conf);

		$retorno = array(
			'info' => "Tarefa gravada com sucesso.",
			'tarefa' => $tarefa,
			'produto' => $cod_produto,
			'INV' => $nrInvConf,
			'rua' => $rua,
			'coluna' => $col,
			'altura' => $alt,
		);

		echo(json_encode($retorno));

	}else{

		$retorno = array(
			'info' => "Erro na gravação da tarefa.",
		);

		echo(json_encode($retorno));

	}

}

$link->close();
?>