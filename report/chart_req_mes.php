<?php 
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select month(t1.dt_create) as mes_req, year(t1.dt_create) as ano_req, count(t1.cod_pedido) as req_total
from tb_pedido_coleta t1
where t1.fl_status = 'F'
group by month(t1.dt_create)
order by year(t1.dt_create), month(t1.dt_create) asc";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	$array_parte[] = array(
		'data_req' 	=> $parte['mes_req']."-".$parte['ano_req'],
		'req_total' => $parte['req_total'],
	);

}

$link->close();
?>
