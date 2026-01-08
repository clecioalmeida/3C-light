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

$nr_pedido 		= $_POST['pedido'];
$barcode 		= $_POST['barcode'];
$nr_qtde_conf 	= $_POST['nr_qtde_conf'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$query_init = "select COALESCE(sum(nr_qtde_conf),0) as nr_qtde_conf
from tb_pedido_coleta_produto
where nr_pedido = '$nr_pedido' and produto = '$barcode'";
$res_init = mysqli_query($link, $query_init);
while ($init = mysqli_fetch_assoc($res_init)) {
	$conf = $init['nr_qtde_conf'];
}

if($conf == $nr_qtde_conf){

	$upd_col = "update tb_pedido_coleta_produto set nr_qtde_exp = '$nr_qtde_conf', fl_conferido = 'S', fl_status = 'C' where nr_pedido = '$nr_pedido' and produto = '$barcode'";
	$res_col = mysqli_query($link, $upd_col);

	if($res_col){

		$query_conf = "select coalesce(sum(nr_qtde_conf),0) as total_conf
		from tb_coleta_pedido
		where nr_pedido = '$nr_pedido' and produto = '$barcode'";
		$res_conf = mysqli_query($link, $query_conf);
		$tr_conf = mysqli_num_rows($res_conf);

		while ($conf = mysqli_fetch_assoc($res_conf)) {
			$array_estoque = array(
				'info' => "<span style='background-color: #98FB98'>Quantidade conferida.</span>",
			);
		}

		echo (json_encode($array_estoque));
	}

}else{

	$sql = "insert into tb_ocorrencias (nm_ocorrencia, nm_depto, criticidade, dt_abertura, fl_status, cod_origem, fl_empresa, user_create, dt_create) values ('100 - Quantidade conferida divergente da separação.', 'EXPEDIÇÃO', 'MÉDIA', '$date', 'A', '$nr_pedido', '$cod_cli', '$id', '$date')";
	$resultado_id = mysqli_query($link, $sql);

	$array_estoque = array(

		'info' => "Quantidade digitada não confere com a quantidade coletada!",
		'conf' => $conf,
		'nr_qtde_conf' => $nr_qtde_conf,
	);

	echo (json_encode($array_estoque));

	exit();

}

$link->close();
?>