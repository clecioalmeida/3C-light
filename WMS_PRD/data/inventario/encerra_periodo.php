<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_POST['inv'];

$sql_parte = "select date_format(fim_periodo, '%Y-%m-%d') as ultimo, date_format(ADDDATE(fim_periodo, INTERVAL 1 DAY),'%Y-%m-%d') as inicio,
date_format(now(), '%Y-%m-%d') as hoje
FROM tb_inv_ap
where id_inv = 61
order by date_format(dt_create, '%Y-%m-%d') desc limit 1";
$res_parte = mysqli_query($link, $sql_parte);

while ($dados = mysqli_fetch_array($res_parte)) {
	$last = $dados['ultimo'];
	$start = $dados['inicio'];
	$today = $dados['hoje'];
}

$sql = "select count(t1.id) as total, sum(t2.cont_2) as soma
from tb_inv_tarefa t1
left join tb_inv_conf t2 on t1.id = t2.id_tar
where t1.dt_create between '$start' and '$today'";
$res = mysqli_query($link, $sql);
while ($dados_tar = mysqli_fetch_array($res)) {
	$total = $dados_tar['total'];
	$soma = $dados_tar['soma'];
}

$ins = "insert into tb_inv_ap (id_inv, ini_periodo, fim_periodo, qtd_tar, qtd_item, usr_create, dt_create) values ('$id_inv', '$start', '$today', '$total', '$soma', 2, now())";
$res_ins = mysqli_query($link, $ins);

if (mysqli_affected_rows($link) > 0) {

	$array_end[] = array(
		'info' => 0,
	);

	echo (json_encode($array_end));

} else {

	$array_end[] = array(
		'info' => 1,
	);

	echo (json_encode($array_end));
}

$link->close();
?>