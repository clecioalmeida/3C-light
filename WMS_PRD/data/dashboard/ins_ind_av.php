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

$ds_data 	= $_POST['ds_data'];
$sku_int 	= $_POST['sku_int'];
$vlr_int 	= str_replace(",",".",$_POST['vlr_int']);
$sku_for 	= $_POST['sku_for'];
$vlr_for 	= str_replace(",",".",$_POST['vlr_for']);
$sku_cli 	= $_POST['sku_cli'];
$vlr_cli 	= str_replace(",",".",$_POST['vlr_cli']);
$sku_total 	= $_POST['sku_total'];
$vlr_total 	= str_replace(",",".",$_POST['vlr_total']);

$query_qtde="select id, date(ds_data) from tb_fc_avaria where ds_data = '$ds_data' and fl_status = 'A' and fl_tipo = 'A'";
$qtde = mysqli_query($link,$query_qtde);

if(mysqli_num_rows($qtde) > 0){
	
	$dados = mysqli_fetch_assoc($qtde);

	$upd_ind="update tb_fc_avaria set sku_int = '$sku_int', vlr_int = '$vlr_int', sku_for = '$sku_for', vlr_for = '$vlr_for', vlr_cli = '$vlr_cli', sku_total = '$sku_total', vlr_total = '$vlr_total' where id = '".$dados['id']."'";
	$etq = mysqli_query($link,$upd_ind);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.';

	}else{

		echo 'Erro no cadastro1.';

	}

}else{

	$ins_etq="insert into tb_fc_avaria (ds_data, sku_int, vlr_int, sku_for, vlr_for, sku_cli, vlr_cli, sku_total, vlr_total, fl_tipo, fl_status, fl_empresa, usr_create, dt_create) values ('$ds_data', '$sku_int', '$vlr_int', '$sku_for', '$vlr_for', '$sku_cli', '$vlr_cli', '$sku_total', '$vlr_total', 'A', 'A', '$cod_cli', '$id', '$date')";
	$etq = mysqli_query($link,$ins_etq);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.';

	}else{

		echo 'Erro no cadastro2.';

	}

}

$link->close();
?>