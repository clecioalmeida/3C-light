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

$nm_fornecedor 				= $_POST['nm_fornecedor'];
$nr_insumo 					= $_POST['nr_insumo'];
$nr_peso_previsto 			= $_POST['nr_peso_previsto'];
$nr_volume_previsto 		= $_POST['nr_volume_previsto'];
$nm_transportadora 			= $_POST['nm_transportadora'];
$nm_motorista 				= $_POST['nm_motorista'];
$dt_ag_disp 				= $_POST['dt_ag_disp'];
$nm_placa 					= $_POST['nm_placa'];
$ds_obs 					= $_POST['ds_obs'];	
$id_janela 					= $_POST['id_janela'];

$sql = "insert into tb_recebimento_ag (
	cod_cli, nm_fornecedor, dt_recebimento_previsto, nr_peso_previsto,  nr_volume_previsto, nm_transportadora, nm_motorista, 
	nm_placa, tp_veiculo, fl_status, fl_empresa, usr_create, dt_create, nr_insumo, ds_obs
	) values (
		$cod_cli, '$nm_fornecedor', '$dt_ag_disp', '$nr_peso_previsto',  '$nr_volume_previsto', '$nm_transportadora', 
		'$nm_motorista', '$nm_placa', '$tp_veiculo', 'S', '$cod_cli', '$id', '$date', '$nr_insumo', '$ds_obs'
		)";
$resultado_id = mysqli_query($link, $sql);
$nRec = mysqli_insert_id($link);

if($resultado_id){

	$sql_ag = "update tb_janela set fl_status = 'C', cod_rec = '$nRec' where id = '$id_janela'";
	$res_ag = mysqli_query($link, $sql_ag);

	$retorno[] = array(
		'info' => "0",
		'id_rec' => $nRec,
	);

	echo (json_encode($retorno));

}else{

	$retorno[] = array(
		'info' => "1",
	);

	echo (json_encode($retorno));

}

$link->close();
?>