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

$upd_col = "update tb_pedido_coleta_produto set nr_qtde_exp = '$nr_qtde_conf', fl_status = 'C' where nr_pedido = '$nr_pedido' and produto = '$barcode'";
$res_col = mysqli_query($link, $upd_col);

if(mysqli_affected_rows($link) > 0){

	$sql = "insert into tb_ocorrencias (nm_ocorrencia, tipo, ds_responsavel, nm_depto, criticidade, dt_abertura, fl_status, cod_origem, ds_obs, fl_empresa, user_create, dt_create) values ('Pedido conferido parcialmente', '', '$id', 'Conferência', 'A', '$date', 'A', '$pedido', '', '$cod_cli', '$id', '$date')";
	$resultado_id = mysqli_query($link, $sql);

	$query_conf = "select coalesce(sum(nr_qtde_conf),0) as total_conf
	from tb_coleta_pedido
	where nr_pedido = '$nr_pedido' and produto = '$barcode'";
	$res_conf = mysqli_query($link, $query_conf);
	$tr_conf = mysqli_num_rows($res_conf);

	$conf = mysqli_fetch_assoc($res_conf);

	$total_conf = $conf['total_conf'];

	$array_estoque = array(

		'info' => "0",
		'text' => "Quantidade conferida.",
		'conf' => $total_conf,
		'nr_qtde_conf' => "<h3 style='background-color: #98FB98'><span>Conferido: ".$nr_qtde_conf."</span></h3>",

	);

	echo (json_encode($array_estoque));

}else{

	$array_estoque = array(

		'info' => "1",
		'text' => "Conferencia não registrada.",

	);

	echo (json_encode($array_estoque));

}

$link->close();
?>