<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
	$id_oper 	= $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$ds_data 	= $_POST['ds_data'];
$nr_nf 		= $_POST['nr_nf'];
$nr_nf_div 	= $_POST['nr_nf_div'];

//$ds_data = $ds_mes."-".$ds_ano;

$query_qtde="select id, ds_data from tb_fc_rec_sap where ds_data = '$ds_data'";
$qtde = mysqli_query($link,$query_qtde);

if(mysqli_num_rows($qtde) > 0){

	$upd_ind="update tb_fc_rec_sap set nf_rec = '$nr_nf', nf_rec_div = '$nr_nf_div' where id = '$id_ind'";
	$etq = mysqli_query($link,$upd_ind);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.';

	}else{

		echo 'Erro no cadastro.';

	}

}else{

	$ins_etq="insert into tb_fc_rec_sap (ds_data, nf_rec, nf_rec_div, fl_empresa, fl_status, usr_create, dt_create) values ('$ds_data', '$nr_nf', '$nr_nf_div', '$id_oper', 'A', '$id', '$date')";
	$etq = mysqli_query($link,$ins_etq);

	if(mysqli_affected_rows($link) > 0){

		echo 'Dados cadastrados.';

	}else{

		echo 'Erro no cadastro.';

	}

}

$link->close();
?>