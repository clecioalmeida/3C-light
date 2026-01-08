<?php 
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select t1.id_projeto, t2.pj_descricao,  count(t1.id) as total_tar, time_format(SEC_TO_TIME(SUM(TIME_TO_SEC(tr_horas))),'%H:%i') as total_hr
from tarefas t1
left join projeto t2 on t1.id_projeto = t2.id
group by id_projeto
order by count(t1.id) desc";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	$array_parte[] = array(
		'total_tar' 	=> $parte['total_tar'],
		'total_hr' 		=> $parte['total_hr'],
		'id_projeto' 	=> $parte['pj_descricao'],
	);

}

$sql_hr = "select t1.id_projeto, t2.pj_descricao, t1.tr_responsavel,  time_format(SEC_TO_TIME(SUM(TIME_TO_SEC(tr_horas))),'%H:%i') as total_hr
from tarefas t1
left join projeto t2 on t1.id_projeto = t2.id
group by id_projeto
order by time_format(SEC_TO_TIME(SUM(TIME_TO_SEC(tr_horas))),'%H')+0 desc";
$res_hr = mysqli_query($link, $sql_hr);
while ($horas = mysqli_fetch_assoc($res_hr)) {

	$array_horas[] = array(
		'total_hr' 			=> $horas['total_hr'],
		'tr_responsavel' 	=> $horas['tr_responsavel'],
		'id_projeto' 		=> $horas['pj_descricao'],
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
