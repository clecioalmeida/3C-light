<?php 
require_once('bd_class.php');

$cod_ocorrencia=$_POST['cod_ocorrencia'];
$ds_responsavel=$_POST['ds_responsavel'];
$nm_depto=$_POST['nm_depto'];
$dt_final=$_POST['dt_final'];
$ds_obs=$_POST['ds_obs'];

$objDb = new db();
$link = $objDb->conecta_mysql();


$updt_ocorrencia = "update tb_ocorrencias set ds_responsavel = '$ds_responsavel', nm_depto = '$nm_depto', dt_final = '$dt_final', ds_obs = '$ds_obs' where cod_ocorrencia = '$cod_ocorrencia'"; 
$res_updt = mysqli_query($link,$updt_ocorrencia); 
$tr_updt = mysqli_num_rows($res_updt);

if(mysqli_affected_rows($link) > 0){

	include 'updt_ok.php';

 }else{

	include 'updt_err.php';
}

$link->close();
?>