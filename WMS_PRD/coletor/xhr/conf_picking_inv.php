<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$localInv = $_POST['localInv'];
$barcode = $_POST['barcode'];
$nr_qtde_inv = $_POST['nr_qtde_inv'];
$nr_vol_inv = $_POST['nr_vol_inv'];

$end = explode("-", $localInv);

if(isset($end[0]) && isset($end[1]) && isset($end[2]) && isset($end[3])){

	$id_end = $end[0];
	$rua = strtoupper($end[1]);
	$col = $end[2];
	$alt = $end[3];

	$cod_prod_cliente = explode("-", $barcode);

	$cod_cliente = $cod_prod_cliente[0];

	$query_init = "select cod_produto, nm_produto
	from tb_produto
	where cod_prod_cliente = '$barcode'";
	$res_init = mysqli_query($link, $query_init);
	while ($init = mysqli_fetch_assoc($res_init)) {
		$cod_produto = $init['cod_produto'];
		$nm_produto = $init['nm_produto'];

		$upd_col = "INSERT into tb_inv_tarefa (id_inv, id_produto, id_galpao, id_rua, id_coluna, id_altura, nr_volume, fl_status, fl_tipo, user_create, dt_create) values ('', '$cod_produto', '', '$rua', '$col', '$alt', '$nr_vol_inv', 'A', 'R', '$id', '$date')";
		$res_col = mysqli_query($link1, $upd_col);

		$nTar=mysqli_insert_id($link1);

		if($res_col){

			$ins_conf = "INSERT into tb_inv_conf (id_tar, cont_1, cont_2, dt_conf_1, user_create, dt_create) values ('$nTar', '$nr_qtde_inv', '', '$date', '$id', '$date')";
			$res_conf = mysqli_query($link, $ins_conf);

			$retorno = array(
				'info' => "Tarefa gravada com sucesso.",
			);

			echo(json_encode($retorno));

		}else{

			$retorno = array(
				'info' => "Erro na gravação da tarefa.",
			);

			echo(json_encode($retorno));

		}
	}


}else{

	$array_estoque = array(

		'info' => "<h3 style='background-color: #FF7F50'>O endereção não foi digitado corretamente.</h3>",
	);

	echo (json_encode($array_estoque));

	exit();

}

$link->close();
?>