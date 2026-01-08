<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
$data_atual = date('c');
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
	echo $cod_cli;
}

?>
<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_galpao="select t1.id, t1.nome 
from tb_armazem t1
left join tb_galpao t2 on t1.galpao = t.cod_galpao
where t2.fl_empresa = '$cod_cli'";
$galpao = mysqli_query($link,$sql_galpao);

$sql_galpao_fim="select t1.id, t1.nome 
from tb_armazem t1
left join tb_galpao t2 on t1.galpao = t.cod_galpao
where t2.fl_empresa = '$cod_cli'";
$galpao_fim = mysqli_query($link,$sql_galpao_fim);
$link->close();
?>