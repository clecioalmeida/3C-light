<?php
/* Pedidos por mês */

$tarefas_dia = "select t1.id, t1.dt_create, DAY(t1.dt_create) as dia, COALESCE(sum(t2.cont_2),0) as total_cont, count(t2.id_tar) as total_tar
		from tb_inv_tarefa t1 left join tb_inv_conf t2 on t1.id = t2.id_tar
		group by DAY(t1.dt_create), MONTH(t1.dt_create)
		order by dt_create desc
		limit 30";
$res_tarefas_dia = mysqli_query($link, $tarefas_dia);

$media_tar = "select avg(total_cont) as media_total_cont from (select t1.id, t1.dt_create, DAY(t1.dt_create) as dia, sum(t2.cont_2) as total_cont, count(t2.id_tar) as total_tar
		from tb_inv_tarefa t1 left join tb_inv_conf t2 on t1.id = t2.id_tar
		group by DAY(t1.dt_create), MONTH(t1.dt_create)
		order by dt_create desc
		limit 30) virtual";
$res_media_tar = mysqli_query($link, $media_tar);
while ($dados = mysqli_fetch_array($res_media_tar)) {
	$media = $dados['media_total_cont'];
}

$chart_inv_dia = '';

while ($dados = mysqli_fetch_array($res_tarefas_dia)) {
	$chart_inv_dia .= "{ dia:" . $dados["dia"] . ", qtde:" . $dados["total_cont"] . ", media:" . $media . "}, ";
}

$chart_pedido = substr($chart_inv_dia, 0, -2);

$link->close();
?>