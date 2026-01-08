<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$idNf = $_POST['idNf'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_ped = "update tb_nf_saida set fl_status = 'X' where nr_nf_formulario = '$idNf' and fl_status = 'A'";
$res_ped = mysqli_query($link, $sql_ped);

if (mysqli_affected_rows($link)) {

	$array_entrega[] = array(
		'info' => '0',
	);

	echo (json_encode($array_entrega));

} else {

	$array_entrega[] = array(
		'info' => '1',
	);

	echo (json_encode($array_entrega));

}

?>