<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once('bd_class.php');

$criticidade=$_POST['criticidade'];
$tipo=$_POST['tipo'];
$cod_origem=$_POST['cod_origem'];
$nm_ocorrencia=$_POST['nm_ocorrencia'];
$ds_responsavel=$_POST['ds_responsavel'];
$nm_depto=$_POST['nm_depto'];
$dt_final=$_POST['dt_final'];
$ds_obs=$_POST['ds_obs'];
$dt_abertura=date('Y-m-d h:i:s');

$objDb = new db();
$link = $objDb->conecta_mysql();


$ins_ocorrencia = "insert into tb_ocorrencias (criticidade, tipo, cod_origem, nm_ocorrencia, ds_responsavel, nm_depto, dt_final, ds_obs, fl_status, dt_abertura) values ('$criticidade', '$tipo', '$cod_origem', '$nm_ocorrencia', '$ds_responsavel', '$nm_depto', '$dt_final', '$ds_obs', 'A', '$dt_abertura')"; 
$res_ins_ocor = mysqli_query($link,$ins_ocorrencia); 
//$tr_ins_ocor = mysqli_num_rows($res_ins_ocor);

if(mysqli_num_rows($res_ins_ocor) > 0){

	include 'ins_ok.php';

 }else{

	include 'ins_err.php';
}

$link->close();
?>