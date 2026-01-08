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
$nr_total_rec 	= $_POST['nr_total_rec'];
$nr_total_ex 	= $_POST['nr_total_ex'];

$upd_ind="update tb_fc_rec set nr_total_rec = '$nr_total_rec', nr_total_ex = '$nr_total_ex', usr_update = '$id', dt_update = '$date' where id = '$id_ind'";
$etq = mysqli_query($link,$upd_ind);

if(mysqli_affected_rows($link) > 0){

	echo 'Dados alterados.';

}else{

	echo 'Erro no cadastro.';

}

$link->close();
?>