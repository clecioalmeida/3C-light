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
//$qtd_ipal_prev 	= $_POST['qtd_ipal_prev'];
//$qtd_ipal_exe 	= $_POST['qtd_ipal_exe'];
$nr_irreg_seg 	= $_POST['nr_irreg_seg'];
$nr_acd_fat 	= $_POST['nr_acd_fat'];

$ds_data = $ds_mes."-".$ds_ano;

$query_qtde="select id, ds_data from tb_fc_seg where ds_data = '$ds_data' and fl_status = 'A'";
$qtde = mysqli_query($link,$query_qtde);

if(mysqli_num_rows($qtde) > 0){
	
	$dados = mysqli_fetch_assoc($qtde);

	$upd_ind="update tb_fc_seg set nr_irreg_seg = '$nr_irreg_seg', nr_acd_fat = '$nr_acd_fat', usr_update = '$id', dt_update = '$date' where id = '".$dados['id']."'";
	$etq = mysqli_query($link,$upd_ind);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.';

	}else{

		echo 'Erro no cadastro.';

	}

}else{

	$ins_etq="insert into tb_fc_seg (ds_data, nr_irreg_seg, nr_acd_fat, fl_status, fl_empresa, usr_create, dt_create) values ('$ds_data', '$nr_irreg_seg', '$nr_acd_fat', 'A', '$cod_cli', '$id', '$date')";
	$etq = mysqli_query($link,$ins_etq);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.';

	}else{

		echo 'Erro no cadastro.';

	}

}

$link->close();
?>