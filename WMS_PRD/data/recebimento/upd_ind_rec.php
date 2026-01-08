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

$id_ind 	= $_POST['id_ind'];
$ds_mes 	= $_POST['ds_mes'];
$ds_ano 	= $_POST['ds_ano'];
$nr_nf 		= $_POST['nr_nf'];
$nr_nf_div 	= $_POST['nr_nf_div'];

$ds_data = $ds_mes."-".$ds_ano;

$upd_ind="update tb_fc_rec_sap set ds_data = '$ds_data', nf_rec = '$nr_nf', nf_rec_div = '$nr_nf_div' where id = '$id_ind'";
$etq = mysqli_query($link,$upd_ind);

if(mysqli_affected_rows($link) > 0){

	echo 'Período alterado.';

}else{

	echo 'Erro no cadastro.';

}

$link->close();
?>