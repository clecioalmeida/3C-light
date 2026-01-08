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

$ds_mes 		= $_POST['ds_mes'];
$ds_ano 		= $_POST['ds_ano'];
$nr_sku_qtde 	= $_POST['nr_sku_qtde'];
$nr_sku_sobra 	= $_POST['nr_sku_sobra'];
$nr_sku_falta 	= $_POST['nr_sku_falta'];
$nr_ac_sku 		= $_POST['nr_ac_sku'];
$vlr_ini 		= $_POST['vlr_ini'];
$vlr_sobra 		= $_POST['vlr_sobra'];
$vlr_falta 		= $_POST['vlr_falta'];
$vlr_fim 		= $_POST['vlr_fim'];
$vlr_div 		= $_POST['vlr_div'];

$ds_data = $ds_mes."-".$ds_ano;

$query_qtde="select id, ds_data from tb_fc_inv_dep where ds_data = '$ds_data' and fl_tipo = 'C'";
$qtde = mysqli_query($link,$query_qtde);

if(mysqli_num_rows($qtde) > 0){
	
	$dados = mysqli_fetch_assoc($qtde);

	$upd_ind="update tb_fc_inv_dep set nr_sku_qtde = '$nr_sku_qtde', nr_sku_sobra = '$nr_sku_sobra', nr_sku_falta = '$nr_sku_falta', nr_ac_sku = '$nr_ac_sku', vlr_ini = '$vlr_ini', vlr_sobra = '$vlr_sobra', vlr_falta = '$vlr_falta', vlr_fim = '$vlr_fim', vlr_div = '$vlr_div' where id = '".$dados['id']."'";
	$etq = mysqli_query($link,$upd_ind);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.';

	}else{

		echo 'Erro no cadastro.';

	}

}else{

	$ins_etq="insert into tb_fc_inv_dep (ds_data, nr_sku_qtde, nr_sku_sobra, nr_sku_falta, nr_ac_sku, vlr_ini, vlr_sobra, vlr_falta, vlr_fim, vlr_div, fl_tipo, fl_status, fl_empresa, usr_create, dt_create) values ('$ds_data', '$nr_sku_qtde', '$nr_sku_sobra', '$nr_sku_falta', '$nr_ac_sku', '$vlr_ini', '$vlr_sobra', '$vlr_falta', '$vlr_fim', '$vlr_div', 'C', 'A', '$cod_cli', '$id', '$date')";
	$etq = mysqli_query($link,$ins_etq);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.';

	}else{

		echo 'Erro no cadastro.';

	}

}

$link->close();
?>