<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$idEmit = $_REQUEST['idEmit'];

$sql_parte = "select cod_cliente, nm_cliente, nm_fantasia, nr_cnpj_cpf from tb_cliente where (nr_cnpj_cpf like '%$idEmit%' or nm_cliente like '%$idEmit%') and fl_tipo <> 'U'";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte = mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		'cod_cliente' 	=> $parte['cod_cliente'],
		'nm_cliente'  	=> $parte['nm_cliente'],
		'nm_fantasia' 	=> $parte['nm_fantasia'],
		'cnpj' 			=> $parte['nr_cnpj_cpf'],
	);
}

echo (json_encode($array_parte));
$link->close();
?>