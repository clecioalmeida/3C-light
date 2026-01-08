<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

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

$ds_data 		= $_POST['ds_data'];
$nr_sku_blq 	= $_POST['nr_sku_blq'];
$vlr_sku_blq 	= str_replace(",",".",$_POST['vlr_sku_blq']);
$nr_est_qld 	= $_POST['nr_est_qld'];
$vlr_est_qld 	= str_replace(",",".",$_POST['vlr_est_qld']);

$query_qtde="select id, date(ds_data) from tb_fc_qld where ds_data = '$ds_data' and fl_status = 'A'";
$qtde = mysqli_query($link,$query_qtde);

if(mysqli_num_rows($qtde) > 0){
	
	$dados = mysqli_fetch_assoc($qtde);

	$upd_ind="update tb_fc_qld set nr_sku_blq = '$nr_sku_blq', vlr_sku_blq = '$vlr_sku_blq', nr_est_qld = '$nr_est_qld', vlr_est_qld = '$vlr_est_qld' where id = '".$dados['id']."'";
	$etq = mysqli_query($link,$upd_ind);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.';

	}else{

		echo 'Erro no cadastro.';

	}

}else{

	$ins_etq="insert into tb_fc_qld (ds_data, nr_sku_blq, vlr_sku_blq, nr_est_qld, vlr_est_qld, fl_status, fl_empresa, usr_create, dt_create) values ('$ds_data', '$nr_sku_blq', '$vlr_sku_blq', '$nr_est_qld', '$vlr_est_qld', 'A', '$cod_cli', '$id', '$date')";
	$etq = mysqli_query($link,$ins_etq);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.';

	}else{

		echo 'Erro no cadastro.';

	}

}

$link->close();
?>