<?php 
require_once('bd_class.php');

$cod_ocorrencia=$_POST['cod_ocorrencia'];
$ds_resp_sol=$_POST['ds_resp_sol'];
$dt_sol=$_POST['dt_sol'];
$ds_solucao=$_POST['ds_solucao'];

$objDb = new db();
$link = $objDb->conecta_mysql();


$fin_ocorrencia = "update tb_ocorrencias set ds_resp_sol = '$ds_resp_sol', dt_sol = '$dt_sol', ds_solucao = '$ds_solucao', fl_status = 'F' where cod_ocorrencia = '$cod_ocorrencia'"; 
$res_fin = mysqli_query($link,$fin_ocorrencia); 
$tr_fin = mysqli_num_rows($res_fin);

if(mysqli_affected_rows($link) > 0){

	include 'fin_ok.php';

 }else{

	include 'fin_err.php';
}

$link->close();
?>