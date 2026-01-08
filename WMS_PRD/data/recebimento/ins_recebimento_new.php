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

$cod_cli 					= $_POST['cod_cli'];
$nm_fornecedor 				= $_POST['nm_fornecedor'];
$nr_peso_previsto 			= $_POST['nr_peso_previsto'];
$dt_recebimento_previsto 	= $_POST['dt_recebimento_previsto'];
$nr_volume_previsto 		= $_POST['nr_volume_previsto'];
$nm_transportadora 			= $_POST['nm_transportadora'];
$nm_motorista 				= $_POST['nm_motorista'];
$nm_placa 					= $_POST['nm_placa'];
$dt_recebimento_real 		= $_POST['dt_recebimento_real'];
$tp_rec 					= $_POST['tp_rec'];
$nr_insumo 					= $_POST['nr_insumo'];
$ds_obs 					= $_POST['ds_obs'];

if ($tp_rec == '21') {

	$sql = " insert into tb_recebimento (cod_cli, nm_fornecedor, nr_peso_previsto, dt_recebimento_previsto, nr_volume_previsto, nm_transportadora, nm_motorista, nm_placa, dt_recebimento_real, fl_status, tp_rec, nm_user_criado_por, dt_user_criado_por, nr_insumo) values (110, '$nm_fornecedor', '$nr_peso_previsto', '$dt_recebimento_previsto', '$nr_volume_previsto', '$nm_transportadora', '$nm_motorista', '$nm_placa', '$dt_recebimento_real', 'K', '$tp_rec', '$id', now(), '$nr_insumo'";
	$resultado_id = mysqli_query($link, $sql);
	$id_rec = mysqli_insert_id($link);

} else {

	$sql = "insert into tb_recebimento (cod_cli, nm_fornecedor, nr_peso_previsto, dt_recebimento_previsto, nr_volume_previsto, nm_transportadora, nm_motorista, nm_placa, dt_recebimento_real, fl_status, tp_rec, nm_user_criado_por, dt_user_criado_por, nr_insumo) values (110, '$nm_fornecedor', '$nr_peso_previsto', '$dt_recebimento_previsto', '$nr_volume_previsto', '$nm_transportadora', '$nm_motorista', '$nm_placa', '$dt_recebimento_real', 'A', '$tp_rec', '$id', now(), '$nr_insumo')";
	$resultado_id = mysqli_query($link, $sql);
	$id_rec = mysqli_insert_id($link);

}

if ($resultado_id) {

	$retorno[] = array(
		'info' 						=> "0",
		'cod_cli' 					=> $cod_cli;
		'nm_fornecedor' 			=> $nm_fornecedor;
		'nr_peso_previsto' 			=> $nr_peso_previsto;
		'dt_recebimento_previsto' 	=> $dt_recebimento_previsto;
		'nr_volume_previsto' 		=> $nr_volume_previsto;
		'nm_transportadora' 		=> $nm_transportadora;
		'nm_motorista' 				=> $nm_motorista;
		'nm_placa' 					=> $nm_placa;
		'dt_recebimento_real' 		=> $dt_recebimento_real;
		'tp_rec' 					=> $tp_rec;
		'nr_insumo' 				=> $nr_insumo;
		'ds_obs' 					=> $ds_obs;
		'cod_rec' 					=> $id_rec;
	);

	echo (json_encode($retorno));

} else {

	$retorno[] = array(
		'info' => "1",
	);

	echo (json_encode($retorno));

}

$link->close();
?>