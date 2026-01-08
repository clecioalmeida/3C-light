<?php 
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select CONCAT('Mês: ',month(t1.tr_prev)) as mes, count(t1.id) as total_tar_mes, time_format(SEC_TO_TIME(SUM(TIME_TO_SEC(tr_horas))),'%H:%i') as total_hr_mes
from tarefas t1
group by month(t1.tr_prev)
order by month(t1.tr_prev) asc";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	$array_parte[] = array(
		'total_tar_mes' 	=> $parte['total_tar_mes'],
		'total_hr_mes' 		=> $parte['total_hr_mes'],
		'mes' 				=> $parte['mes'],
	);

}

$sql_hr = "SELECT CONCAT('Semana: ',WEEK(tr_inicio), '/',YEAR(tr_inicio), ', Mês: ', month(tr_inicio)) AS week_name, YEAR(tr_inicio), WEEK(tr_inicio), COUNT(*) as total_tar_wek, time_format(SEC_TO_TIME(SUM(TIME_TO_SEC(tr_horas))),'%H:%i') as total_hr_wek  FROM tarefas where tr_inicio > 0 GROUP BY week_name ORDER BY YEAR(tr_inicio) ASC, WEEK(tr_inicio) ASC";
$res_hr = mysqli_query($link, $sql_hr);
while ($horas = mysqli_fetch_assoc($res_hr)) {

	$array_horas[] = array(
		'total_tar_wek' 	=> $horas['total_tar_wek'],
		'total_hr_wek' 	=> $horas['total_hr_wek'],
		'Semana' 			=> $horas['week_name'],
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
