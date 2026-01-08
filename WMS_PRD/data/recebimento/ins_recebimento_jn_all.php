<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli  	= $_SESSION['cod_cli'];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

//$cod_rec 					= $_POST['cod_rec_all'];
$nm_fornecedor 				= $_POST['nm_fornecedor'];
$nr_insumo 					= $_POST['nr_insumo'];
$nr_peso_previsto 			= $_POST['nr_peso_previsto'];
$nr_volume_previsto 		= $_POST['nr_volume_previsto'];
$ds_tipo_vol 				= $_POST['ds_tipo_vol'];
$nm_transportadora 			= $_POST['nm_transportadora'];
$nm_motorista 				= $_POST['nm_motorista'];
$nm_placa 					= $_POST['nm_placa'];
$dt_recebimento_real 		= $_POST['dt_recebimento_real'];
$tp_recebimento 			= $_POST['tp_recebimento'];
$obs 						= $_POST['ds_obs'];	

$sql = "insert into tb_recebimento (cod_cli, nm_fornecedor, nr_peso_previsto, nr_volume_previsto, ds_tipo_vol, nm_transportadora, nm_motorista, nm_placa, dt_recebimento_real, tp_recebimento, fl_status, fl_empresa, usr_create, dt_create, nr_insumo, ds_obs) values ($cod_cli, '$nm_fornecedor', '$nr_peso_previsto', '$nr_volume_previsto', '$ds_tipo_vol', '$nm_transportadora', '$nm_motorista', '$nm_placa', '$dt_recebimento_real', '$tp_recebimento', 'A', '$cod_cli', '$id', '$date', '$nr_insumo', '$obs')";
$resultado_id = mysqli_query($link, $sql);
$nRec = mysqli_insert_id($link);


if ($resultado_id) {

	foreach ($_POST["cod_rec_all"] as $cod_rec) {

		$sql_upd = "update tb_recebimento_ag set cod_rec = '$nRec' where cod_recebimento = '$cod_rec'";
		$res_upd = mysqli_query($link, $sql_upd);
	}

	$retorno[] = array(
		'info' => "0",
		'id_rec' => $nRec,
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