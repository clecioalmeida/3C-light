<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

//$idOp = $_REQUEST['idOp'];

$sql_parte = "SELECT cod_fornecedor, nr_cnpj_cpf, CASE WHEN nr_cnpj_cpf is not null THEN concat(INSERT(INSERT(INSERT(INSERT(nr_cnpj_cpf, 13, 0, '-' ), 9, 0, '/' ), 6, 0, '.' ), 3, 0, '.' ),' - ', nm_fornecedor) ELSE concat(nm_fornecedor,'-','CNPJ não cadastrado') END as nm_fornecedor
from tb_fornecedor where fl_status = 'A'";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte = mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		'cod_fornecedor' 	=> $parte['cod_fornecedor'],
		'nm_fornecedor' 	=> $parte['nm_fornecedor'],
	);
}

echo (json_encode($array_parte));
$link->close();
?>