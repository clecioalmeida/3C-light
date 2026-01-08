<?php 
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select concat('Mês: ',month(tr_prev)) as mes, count(id) as total_tar
from tarefas
group by month(tr_prev)";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	$array_parte[] = array(
		'total_tar' => $parte['total_tar'],
		'mes' 		=> $parte['mes'],
	);

}

$sql_hr = "select concat('Mês: ',month(tr_prev)) as mes_hr, time_format(SEC_TO_TIME(SUM(TIME_TO_SEC(tr_horas))),'%H:%i') as total_hr
from tarefas
group by month(tr_prev)";
$res_hr = mysqli_query($link, $sql_hr);
while ($horas = mysqli_fetch_assoc($res_hr)) {

	$array_horas[] = array(
		'total_hr' 	=> $horas['total_hr'],
		'mes_hr' 	=> $horas['mes_hr'],
	);
	
}

$sql_nv = "select concat('Mês: ',month(tr_prev)) as mes_ct, count(id) as total_ct
from tarefas
where tr_tipo = 'CUSTOMIZAÇÃO'
group by month(tr_prev)";
$res_nv = mysqli_query($link, $sql_nv);
while ($novo = mysqli_fetch_assoc($res_nv)) {

	$array_novo[] = array(
		'total_ct' 	=> $novo['total_ct'],
		'mes_ct' 	=> $novo['mes_ct'],
	);
	
}

$link->close();
?>
