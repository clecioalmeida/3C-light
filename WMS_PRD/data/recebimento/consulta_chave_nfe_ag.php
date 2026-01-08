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
date_default_timezone_set('America/Sao_Paulo');
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$chave_nfe 	= $_POST['chave_nfe'];

$sql_emp = "select t1.nm_empresa, t1.cte_prod, t1.fl_token_hmg, t1.fl_token_prd, t1.nr_cnpj
from tb_empresa t1
where t1.cod_empresa = '$cod_cli'";
$res_emp = mysqli_query($link, $sql_emp);
while ($dados = mysqli_fetch_assoc($res_emp)) {

	$token 		= $dados['fl_token_prd'];
	$tpAmb 		= "1";
	$nr_cnpj 	= $dados['nr_cnpj'];

}

if (mysqli_num_rows($res_emp) > 0) {

	$array_mdfe = array(
		'X-AUTH-TOKEN'		=> $token,
		'CNPJInteressado' 	=> $nr_cnpj,
		'tpAmb' 			=> $tpAmb,
		'chave'				=> $chave_nfe,
		//'ultNSU'			=> 1,
	);

}else{

	$array_mdfe = array(
		'info' => "1",
	);

}

echo json_encode($array_mdfe);

$link->close();
?>