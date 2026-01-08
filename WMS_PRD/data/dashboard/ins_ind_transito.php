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
$nr_prazo 	= str_replace(",",".",$_POST['nr_prazo']);
$nr_atraso 	= str_replace(",",".",$_POST['nr_atraso']);

$query_qtde="select id, date(ds_data) from tb_fc_tran where ds_data = '$ds_data' and fl_status = 'A'";
$qtde = mysqli_query($link,$query_qtde);

if(mysqli_num_rows($qtde) > 0){
	
	$dados = mysqli_fetch_assoc($qtde);

	$upd_ind="update tb_fc_tran set nr_prazo = '$nr_prazo', nr_atraso = '$nr_atraso' where id = '".$dados['id']."'";
	$etq = mysqli_query($link,$upd_ind);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.';

	}else{

		echo 'Erro no cadastro.';

	}

}else{

	$ins_etq="insert into tb_fc_tran (ds_data, nr_prazo, nr_atraso, fl_status, fl_empresa, usr_create, dt_create) values ('$ds_data', '$nr_prazo', '$nr_atraso', 'A', '$cod_cli', '$id', '$date')";
	$etq = mysqli_query($link,$ins_etq);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.';

	}else{

		echo 'Erro no cadastro.';

	}

}

$link->close();
?>