<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nfe_chv = $_POST['nfe_chv'];

$sql_chv = "SELECT chavenfe from tb_nf_entrada where chavenfe = '$nfe_chv' and fl_status <> 'E'";
$res_chv = mysqli_query($link, $sql_chv);
if(mysqli_num_rows($res_chv) > 0){

	$array_parte = array(
			'info' 			=> "2",
		);

		echo (json_encode($array_parte));

}else{

	$cnpj = substr($nfe_chv, 6,14);
	$serie = substr($nfe_chv, 22,3);
	$serie = ltrim($serie, '0');
	$nr_nf = substr($nfe_chv, 25,9);
	$nr_nf = ltrim($nr_nf, '0');

	$sql = "SELECT cod_cliente, nm_cliente from tb_cliente where nr_cnpj_cpf = '$cnpj' and fl_status <> 'E'";
	$res = mysqli_query($link, $sql);

	if(mysqli_num_rows($res) > 0){

		$parte = mysqli_fetch_assoc($res);

		$array_parte = array(
			'info' 			=> "0",
			'cod_cliente' 	=> $parte['cod_cliente'],
			'nm_cliente' 	=> $parte['nm_cliente'],
			'serie' 		=> $serie,
			'nr_nf' 		=> $nr_nf,
			'nr_cnpj' 		=> $cnpj,
		);

		echo (json_encode($array_parte));

	}else{

		$array_parte = array(
			'info' 			=> "1",
			'nr_cnpj' 		=> $cnpj,
			'nr_nf' 		=> $nr_nf,
			'serie' 		=> $serie,
		);

		echo (json_encode($array_parte));

	}

}

$link->close();
?>