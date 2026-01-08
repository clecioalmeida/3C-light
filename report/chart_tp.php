<?php 
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select t1.tr_tipo, count(t1.id) as total_tar_mes, time_format(SEC_TO_TIME(SUM(TIME_TO_SEC(tr_horas))),'%H:%i') as total_hr_mes
from tarefas t1
group by t1.tr_tipo
order by count(t1.id) desc";
$res = mysqli_query($link, $sql);
while ($tipo = mysqli_fetch_assoc($res)) {

	$array_tipo[] = array(
		'total_tar_mes' 	=> $tipo['total_tar_mes'],
		'total_hr_mes' 		=> $tipo['total_hr_mes'],
		'tr_tipo' 			=> $tipo['tr_tipo'],
		//'tr_tipo' 			=> array($tipo['tr_tipo'],array($tipo['total_tar_mes'],$tipo['total_hr_mes'])),
	);

}

$sql_hr = "select concat(t2.pj_descricao, ' - ', t1.tr_tipo) as tr_tipo, t1.id_projeto, count(t1.id) as total_tar_mes, time_format(SEC_TO_TIME(SUM(TIME_TO_SEC(tr_horas))),'%H:%i') as total_hr_mes
from tarefas t1
left join projeto t2 on t1.id_projeto = t2.id
group by t1.id_projeto
order by count(t1.id) desc";
$res_hr = mysqli_query($link, $sql_hr);
while ($horas = mysqli_fetch_assoc($res_hr)) {

	$array_horas[] = array(
		'total_tar_mes' 	=> $horas['total_tar_mes'],
		'total_hr_mes' 		=> $horas['total_hr_mes'],
		'tr_tipo' 			=> $horas['tr_tipo'],
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
