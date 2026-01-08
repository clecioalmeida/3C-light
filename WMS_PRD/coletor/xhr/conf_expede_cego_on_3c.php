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

$nr_pedido 		= $_POST['nr_pedido'];
$barcode 		= $_POST['barcode_exp_3c'];
$nr_qtde_conf 	= $_POST['nr_qtde_conf'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$query_init = "select COALESCE(sum(nr_qtde),0) as nr_qtde_conf
from tb_pedido_conferencia
where nr_pedido = '$nr_pedido' and produto = '$barcode'";
$res_init = mysqli_query($link, $query_init);
while ($init = mysqli_fetch_assoc($res_init)) {
	$conf = $init['nr_qtde_conf'];
}

if($conf == $nr_qtde_conf){

	$upd_col = "update tb_pedido_coleta_produto set nr_qtde_exp = '$nr_qtde_conf', fl_status = 'C' where nr_pedido = '$nr_pedido' and produto = '$barcode'";
	$res_col = mysqli_query($link, $upd_col);

	if($res_col){

		$query_conf = "select coalesce(sum(nr_qtde_conf),0) as total_conf
		from tb_coleta_pedido
		where nr_pedido = '$nr_pedido' and produto = '$barcode'";
		$res_conf = mysqli_query($link, $query_conf);
		$tr_conf = mysqli_num_rows($res_conf);

		while ($conf = mysqli_fetch_assoc($res_conf)) {
			$array_estoque = array(

				'info' => "0",
				'text' => "Quantidade conferida.",
				'conf' => $conf,
				'nr_qtde_conf' => "<h3 style='background-color: #98FB98'><span>Conferido: ".$nr_qtde_conf."</span></h3>",

			);
		}

		echo (json_encode($array_estoque));
	}

}else{

	$array_estoque = array(

		'info' => "1",
		'text' => "Quantidade digitada não confere com a quantidade coletada!",
		'conf' => $conf,
		'nr_qtde_conf' => "<h3 style='background-color: #A52A2A;color:white'><span>Não confere: ".$nr_qtde_conf."</span></h3>",
	);

	echo (json_encode($array_estoque));

	exit();

}

$link->close();
?>