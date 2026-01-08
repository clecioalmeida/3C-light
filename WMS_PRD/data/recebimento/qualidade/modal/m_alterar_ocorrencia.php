<?php 
require_once('bd_class.php');

$cod_ocorrencia=$_POST['id_ocor'];

$objDb = new db();
$link = $objDb->conecta_mysql();


$sql_ocorrencia = "select * from tb_ocorrencias where cod_ocorrencia = '$cod_ocorrencia'"; 
$res_ocorrencia = mysqli_query($link,$sql_ocorrencia); 
$tr_ocorrencia = mysqli_num_rows($res_ocorrencia);

if($tr_ocorrencia > 0){

	include 'mdl_alterar_ocorrencia.php';

 }else{

	echo "Não há dados para mostrar";
}

$link->close();
?>