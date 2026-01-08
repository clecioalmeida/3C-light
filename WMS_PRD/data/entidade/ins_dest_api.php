<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$nm_emitente 		= $_POST['r_social'];
$nr_cnpj_cpf 		= $_POST['nr_cnpj_cpf'];
$ds_ie_rg 			= $_POST['ds_ie_rg'];
$ds_endereco 		= $_POST['ds_endereco'];
$nr_numero 			= $_POST['ds_numero'];
$ds_bairro 			= $_POST['ds_bairro'];
$ds_uf 				= $_POST['ds_uf'];
$ds_cep 			= $_POST['ds_cep'];
if(isset($_POST['ds_complemento'])){

	$ds_complemento 	= $_POST['ds_complemento'];

}else{

	$ds_complemento = "";
	
}
if(isset($_POST['cod_mun'])){

	$cod_mun 		= $_POST['cod_mun'];

}else{

	$sql_mun = "select cod_municipio from tb_municipio where nm_municipio = '$ds_cidade' and nm_uf = '$ds_uf'";
	$res_mun = mysqli_query($link1, $sql_mun);

	if(mysqli_num_rows($res_mun) > 0){

		$municipio=mysqli_fetch_assoc($res_mun);
		$cod_mun = $municipio['cod_municipio'];

	}else{

		$array_parte[] = array(
			'info' 			=> "3",
		);

		echo (json_encode($array_parte));

		exit;

	}

}
if(isset($_POST['ds_cidade'])){
	
	$ds_cidade 	= $_POST['ds_cidade'];

}else{

	$sql_cid = "select nm_municipio from tb_municipio where cod_municipio = '$cod_mun' and nm_uf = '$ds_uf'";
	$res_cid = mysqli_query($link1, $sql_cid);

	if(mysqli_num_rows($res_cid) > 0){

		$cidade=mysqli_fetch_assoc($res_cid);
		$ds_cidade = $cidade['nm_municipio'];

	}else{

		$array_parte[] = array(
			'info' 			=> "3",
		);

		echo (json_encode($array_parte));

		exit;

	}

}


$search = "select cod_cliente, nr_cnpj_cpf, nm_cliente from tb_cliente where nr_cnpj_cpf = '$nr_cnpj_cpf' and fl_status = 'A'";
$consulta_cnpj = mysqli_query($link1, $search);
$cliente=mysqli_fetch_assoc($consulta_cnpj);
$cod_cliente = $cliente['cod_cliente'];
$nm_cliente = $cliente['nm_cliente'];

if (mysqli_affected_rows($link1) > 0) {

	$array_parte[] = array(
		'info' 			=> "1",
		'nm_cliente' 	=> $nm_cliente,
		'cod_cliente' 	=> $cod_cliente,
	);

	echo (json_encode($array_parte));

} else {

	$sql = "insert into tb_cliente (nm_cliente, nr_cnpj_cpf, ds_ie_rg, ds_endereco, nr_numero, ds_bairro, ds_cidade, ds_uf, ds_cep, cod_mun, ds_complemento, fl_status) values ('$nm_emitente', '$nr_cnpj_cpf', '$ds_ie_rg', '$ds_endereco', '$nr_numero', '$ds_bairro', '$ds_cidade', '$ds_uf', '$ds_cep', '$cod_mun', '$ds_complemento', 'A')";
	$resultado_id = mysqli_query($link, $sql);
	$n_cli = mysqli_insert_id($link);

	if (mysqli_affected_rows($link) > 0) {

		$array_parte[] = array(
			'info' 			=> "0",
			'cod_cliente'	=>$n_cli,
			'nm_cliente'	=>$nm_emitente,
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