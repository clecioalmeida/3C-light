<?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$vl_icms_ent 	= str_replace(',', '.', str_replace('.', '', "150,00"));

echo $vl_icms_ent;
$link->close();
?>