<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_cnpj = str_replace(".", "", str_replace("-", "",str_replace("/", "",$_POST['nr_cnpj'])));
$ds_uf_con = $_POST['ds_uf_con'];

$sql_emp = "SELECT t1.cod_empresa, t1.nr_cnpj, t1.fl_token_prd
from tb_empresa t1
where t1.cod_empresa = '$cod_cli'";
$res_emp = mysqli_query($link, $sql_emp);

$emp = mysqli_fetch_assoc($res_emp);

$cnpj_emp = $emp['nr_cnpj'];
$fl_token_prd = $emp['fl_token_prd'];

$array_parte = array(
	'X-AUTH-TOKEN' 	=> $fl_token_prd,
	'CNPJCont' 		=> $cnpj_emp,
	'UF' 			=> $ds_uf_con,
	'CNPJ'			=> $nr_cnpj,
);
	
echo json_encode($array_parte, JSON_PRETTY_PRINT);

$link->close();
?>