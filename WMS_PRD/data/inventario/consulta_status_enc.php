<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_REQUEST['id_inv'];

$sql_parte = "select id_inv, date_format(dt_create, '%d/%m/%Y') as dia, count(id) as tarefas
from tb_inv_tarefa
where id_inv = '$id_inv' and fl_status = 'A'
group by date_format(dt_create, '%d/%m/%Y')";
$res_parte = mysqli_query($link, $sql_parte);

if (mysqli_num_rows($res_parte) > 0) {

	while ($parte = mysqli_fetch_assoc($res_parte)) {
		$array_parte[] = array(
			'dia' => $parte['dia'],
			'tarefas' => $parte['tarefas'],
		);
	}

	echo (json_encode($array_parte));

} else {

	while ($parte = mysqli_fetch_assoc($res_parte)) {
		$array_parte[] = array(
			'info' => 0,
			'id_inv' => $parte['id_inv'],
		);
	}

	echo (json_encode($array_parte));
}

$link->close();
?>