<?php

require_once 'bd_class.php';

$nm_cliente 		= $_POST['nm_cliente'];
$nr_cnpj_cpf 		= str_replace(".", "", str_replace("-", "",str_replace("/", "",$_POST['nr_cnpj_cpf'])));
$ds_ie_rg 			= $_POST['ds_ie_rg'];
$ds_endereco 		= $_POST['ds_endereco'];
$nr_numero 			= $_POST['nr_numero'];
$ds_bairro 			= $_POST['ds_bairro'];
$ds_cidade 			= $_POST['ds_cidade'];
$ds_uf 				= $_POST['ds_uf'];
$ds_cep 			= $_POST['ds_cep'];
$nr_telefone		= $_POST['nr_telefone'];
$ds_email 			= $_POST['ds_email'];
$nm_fantasia 		= $_POST['nm_fantasia'];
$nm_contato 		= $_POST['nm_contato'];
$ds_complemento 	= $_POST['ds_complemento'];

$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$search = "select nr_cnpj_cpf from tb_cliente where nr_cnpj_cpf = '$nr_cnpj_cpf' and fl_status = 'A' and ds_uf <> 'EX'";
$consulta_cnpj = mysqli_query($link1, $search);

if (mysqli_affected_rows($link1) > 0) {

	$array_parte[] = array(
		'info' => "1",
	);

	echo (json_encode($array_parte));

} else {
	$sql = "insert into tb_cliente (nm_cliente, nr_cnpj_cpf, ds_ie_rg, ds_endereco, nr_numero, ds_bairro, ds_cidade, ds_uf, ds_cep, nr_telefone, ds_email, nm_fantasia, nm_contato, ds_complemento, fl_tipo, fl_status) values ('$nm_cliente', '$nr_cnpj_cpf',  '$ds_ie_rg', '$ds_endereco', '$nr_numero', '$ds_bairro', '$ds_cidade', '$ds_uf', '$ds_cep', '$nr_telefone', '$ds_email', '$nm_fantasia', '$nm_contato', '$ds_complemento', 'D', 'A')";
	$resultado_id = mysqli_query($link, $sql);
	$novoDest = mysqli_insert_id($link);

	if (mysqli_affected_rows($link) > 0) {

		$array_parte[] = array(
			'info' => "0",
			'cod_cliente' 	=> $novoDest,
			'nm_cliente' 	=> $nm_cliente,
		);

		echo (json_encode($array_parte));

	} else {

		$array_parte[] = array(
			'info' => "2",
		);

		echo (json_encode($array_parte));
	}
}

$link->close();
$link1->close();
?>