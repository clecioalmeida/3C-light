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

$id_ind 		= $_POST['id_ind'];
$nr_nf_rec		= $_POST['nr_nf_rec'];
$nr_forn_rec 	= $_POST['nr_forn_rec'];
$nr_sku_rec 	= $_POST['nr_sku_rec'];

$upd_ind="update tb_fc_sku_rec set nr_nf_rec = '$nr_nf_rec', nr_forn_rec = '$nr_forn_rec', nr_sku_rec = '$nr_sku_rec', usr_update = '$id', dt_update = '$date' where id = '$id_ind'";
$etq = mysqli_query($link,$upd_ind);

if(mysqli_affected_rows($link) > 0){

	echo 'Período alterado.';

}else{

	echo 'Erro no cadastro.';

}

$link->close();
?>