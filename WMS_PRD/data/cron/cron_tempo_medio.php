<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date("Y-m-d H:i:s");
$date = date("Y-m-d");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_dt = "select t1.fl_empresa, date(t1.dt_limite) as dt_pedido, date(t2.dt_expedido) as dt_exp, count(DISTINCT t1.nr_pedido) as nr_total_ped,
TIMESTAMPDIFF(DAY, date(t1.dt_limite) + INTERVAL TIMESTAMPDIFF(MONTH,  date(t1.dt_limite), date(t2.dt_expedido)) MONTH , date(t2.dt_expedido)) AS nr_total_dia
from tb_pedido_coleta t1 
left join tb_minuta t2 on t1.nr_minuta = t2.cod_minuta
where date(t2.dt_expedido) = '$date'
group by t1.fl_empresa, date(t1.dt_pedido), date(t2.dt_expedido)
order by date(t2.dt_expedido)" or die(mysqli_error($sql_dt));
$res_dt = mysqli_query($link, $sql_dt);

if(mysqli_num_rows($res_dt) > 0){


	while ($dados=mysqli_fetch_assoc($res_dt)) {

		$dt_pedido 		= $dados['dt_pedido'];
		$dt_exp 		= $dados['dt_exp'];
		$nr_total_ped 	= $dados['nr_total_ped'];
		$nr_total_dia 	= $dados['nr_total_dia'];
		$fl_empresa 	= $dados['fl_empresa'];


		$sql_ins = "insert into tb_fc_tmp_ped (dt_pedido, dt_exp, nr_total_ped, nr_total_dia, fl_empresa, dt_create) values ('$dt_pedido', '$dt_exp', '$nr_total_ped', '$nr_total_dia', '$fl_empresa', '$data')" or die(mysqli_error($sql_dt));
		$res_ins = mysqli_query($link, $sql_ins);
	}

}else{

	echo "Não há dados para mostrar.";

}

$link->close();
?>