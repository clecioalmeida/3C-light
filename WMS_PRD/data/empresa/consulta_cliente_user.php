<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_parte = "SELECT cod_cliente, nr_cnpj_cpf, concat(INSERT(INSERT(INSERT(INSERT(nr_cnpj_cpf, 13, 0, '-' ), 9, 0, '/' ), 6, 0, '.' ), 3, 0, '.' ),' - ', nm_cliente) as nm_cliente, ds_operacao 
from tb_cliente where fl_tipo <> 'U'";
$res_parte = mysqli_query($link, $sql_parte);
if(mysqli_num_rows($res_parte) > 0){

	while ($parte = mysqli_fetch_assoc($res_parte)) {
		$array_parte[] = array(
			'cod_cliente' => $parte['cod_cliente']."-".$parte['ds_operacao'],
			'nm_cliente' => $parte['nm_cliente'],
			'ds_operacao' => $parte['ds_operacao'],
			'nr_cnpj_cpf' => $parte['nr_cnpj_cpf'],
		);
	}

}else{

	$array_parte[] = array(
		'cod_cliente' => '',
		'nm_cliente' => "Cadastro não encontrado.",
	);

}

echo (json_encode($array_parte));
$link->close();
?>