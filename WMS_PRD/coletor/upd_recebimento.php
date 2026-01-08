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

$cod_rec 			= $_POST['cod_rec'];
$nm_fornecedor 		= $_POST['nm_fornecedor'];
$nr_placa 			= strtoupper($_POST['nr_placa']);
$nm_mot 			= strtoupper($_POST['nm_mot']);
$dt_recebimento 	= $_POST['dt_recebimento'];
$ds_galpao 			= $_POST['ds_galpao'];
$ds_endereco 		= explode('-',strtoupper($_POST['ds_endereco']));
$id_end 			= $ds_endereco[0];
$ds_rua 			= $ds_endereco[1];
$ds_coluna 			= $ds_endereco[2];
$ds_altura 			= $ds_endereco[3];
$cod_produto 		= $_POST['cod_produto'];
$nr_serial 			= $_POST['nr_serial'];
$ds_kva 			= strtoupper($_POST['ds_kva']);
$ds_lp 				= strtoupper($_POST['ds_lp']);
$ds_ano 			= strtoupper($_POST['ds_ano']);
$ds_enr 			= strtoupper($_POST['ds_enr']);
$ds_fabr 			= strtoupper($_POST['ds_fabr']);
$ds_obs 			= strtoupper($_POST['ds_obs']);
$nr_qtde 			= str_replace(",", ".", $_POST['nr_qtde']);

$sql = "UPDATE tb_recebimento_ag set
	nm_fornecedor = '$nm_fornecedor', nm_placa = '$nr_placa', nm_motorista = '$nm_mot', dt_recebimento_real = '$dt_recebimento', 
    id_end = '$id_end', ds_galpao = '$ds_galpao', ds_rua = '$ds_rua', ds_coluna = '$ds_coluna', cod_produto = '$cod_produto', 
	ds_altura = '$ds_altura', ds_kva = '$ds_kva', ds_lp = '$ds_lp', ds_ano = '$ds_ano', 
    ds_enr = '$ds_enr', nr_qtde = '$nr_qtde', ds_fabr = '$ds_fabr', ds_obs = '$ds_obs'
    where cod_recebimento = '$cod_rec'";
$res_id = mysqli_query($link, $sql);

if (mysqli_affected_rows($link) > 0) {

	$retorno = array(
		'info' => "0",
		'qtde' => $nr_qtde,
	);

	echo (json_encode($retorno));

} else {

	$retorno = array(
		'info' => "1",
		'qtde' => $nr_qtde,
	);

	echo (json_encode($retorno));

}

$link->close();