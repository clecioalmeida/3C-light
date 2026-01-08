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

$id_ind 		= $_POST['id_ind'];
$ds_data 		= $_POST['ds_data'];
$qtd_ipal_prev 	= $_POST['qtd_ipal_prev'];
$qtd_ipal_exe 	= $_POST['qtd_ipal_exe'];
$nr_irreg_seg 	= $_POST['nr_irreg_seg'];
$nr_acd_fat 	= $_POST['nr_acd_fat'];

$upd_ind="update tb_fc_seg set ds_data = '$ds_data', nr_irreg_seg = '$nr_irreg_seg', nr_acd_fat = '$nr_acd_fat', usr_update = '$id', dt_update = '$date' where id = '$id_ind'";
$etq = mysqli_query($link,$upd_ind);

if(mysqli_affected_rows($link) > 0){

	echo 'Dados cadastrados.';

}else{

	echo 'Erro no cadastro.';

}

$link->close();
?>