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

require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_ped    	= $_POST['nr_ped'];
$fl_st    	= $_POST['fl_st'];

if($fl_st == "X" || $fl_st == "f"){

	echo "Pedidos com separação finalizada não podem ser estornados.";

}else{

	$sql = "update tb_pedido_conferencia set fl_status = 'E' WHERE nr_pedido = '$nr_ped'";
	$resultado_id = mysqli_query($link, $sql);

	$sql_est = "update tb_pedido_coleta_produto set fl_status = 'A', nr_qtde_conf = NULL, usr_ini_col = NULL, dt_init_col = NULL, usr_fim_coleta = NULL, dt_fim_coleta = NULL, fl_conferido = NULL WHERE nr_pedido = '$nr_ped'";
	$res_est = mysqli_query($link, $sql_est);

	$sql_ped = "update tb_pedido_coleta set fl_status = 'A' WHERE nr_pedido = '$nr_ped'";
	$res_ped = mysqli_query($link, $sql_ped);

	$sql_col = "update tb_coleta_pedido set fl_status = 'E' WHERE nr_pedido = '$nr_ped'";
	$res_col = mysqli_query($link, $sql_col);

	$ins_lg = "insert into tb_log_produto (cod_item, ds_ref, id_ref, ds_rotina, ds_obs, usr_create, dt_create) values ('$nr_ped', 'PEDIDO', '$nr_ped', 'SEPARAÇÃO', 'ESTORNO DE SEPARAÇÃO', '$id', '$date')";
	$res_LG = mysqli_query($link,$ins_lg);

	echo "Separação estornada! Garanta que os produtos foram fisicamente devolvidos.";

}


$link->close();
?>