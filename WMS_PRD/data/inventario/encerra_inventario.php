<?php

require_once 'bd_class.php';

$cod_inv = $_POST['cod_inv'];

$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$sql1 = "select distinct fl_status from tb_inv_tarefa where fl_status <> 'X' and fl_status <> 'F' and fl_status <> 'E' and id_inv = '$cod_inv'";
$res_ped = mysqli_query($link, $sql1);

if (mysqli_num_rows($res_ped) > 0) {

	$retorno[] = array(
		'info' => "1",
	);

} else {

	$sql_atv = "update tb_inv_prog set fl_status = 'F' where id = '$cod_inv'";
	$ativa = mysqli_query($link1, $sql_atv);

	if (mysqli_affected_rows($link1) > 0) {

		$retorno[] = array(
			'info' => "0",
		);

	} else {

		$retorno[] = array(
			'info' => "2",
		);

	}
}

echo (json_encode($retorno));

$link->close();
?>