<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d");
$data = date("Y-m-d H:i:s");
//$date2 = $date-1;
$date2 = date('Y-m-d', strtotime('-1 days', strtotime($date)));

if(date("m") == "01"){

	$year = date("Y");
	$mes = "12";

}else{

	$year = date("Y");
	$mes = date("m")-1;

}

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_dif = "select DATEDIFF(max(dt_create), min(dt_create)) as dif_tempo from tb_fc_saldo_dia";
$res_diff = mysqli_query($link, $sql_dif);
$dif = mysqli_fetch_assoc($res_diff);
$dif_tempo = $dif['dif_tempo'];

$sql_res = "select dt_fechamento, cod_produto as produto, qtd_ped as total_exp, media, coalesce((total/media),0) as giro, dif_tempo, coalesce(('$dif_tempo'/(total/media)),0) as tempo, fl_empresa 
from (select t1.cod_produto as produto, max(t1.dt_fechamento) as dt_fechamento, sum(t3.nr_qtde_exp) as qtd_ped, t1.nr_saldo, sum(t3.nr_qtde_exp) as total, avg(t1.nr_saldo) as media, TIMESTAMPDIFF(DAY,'2020-04-01',max(t1.dt_create)) as dif_tempo, t1.cod_produto, t1.fl_empresa
from tb_fc_saldo_dia t1
left join tb_pedido_coleta_produto t3 on t1.cod_produto = t3.produto
WHERE month(t1.dt_fechamento) = '$mes' and year(t1.dt_fechamento) = '$year' group by t1.cod_produto, t1.fl_empresa) virtual
where total > 0" or die(mysqli_error($sql_dt));
$res = mysqli_query($link, $sql_res);

while ($reservado = mysqli_fetch_assoc($res)) {

	$ds_data 		= $year."-".$mes;
	$cod_produto 	= $reservado['produto'];
	$total_exp 		= $reservado['total_exp'];
	$media 			= $reservado['media'];
	$giro 			= $reservado['giro'];
	$tempo 			= $reservado['tempo'];
	$fl_empresa 	= $reservado['fl_empresa'];

	$sql_ins = "insert into tb_giro (ds_data, produto, nr_exp, nr_media, nr_giro, dif_time, nr_time, fl_empresa, dt_create) values ('$ds_data', '$cod_produto', '$total_exp', '$media', '$giro', '$dif_tempo', '$tempo', '$fl_empresa', '$data')" or die(mysqli_error($sql_ins));
	$res_ins = mysqli_query($link, $sql_ins);

	if(mysqli_affected_rows($link) > 0){

		echo "Cadastrado com sucesso.";

		echo "mes ".$mes." year ".$year." dt_fechamento ".$ds_data." Produto ".$cod_produto." total_exp ".$total_exp." media ".$media." giro ".$giro." dif_tempo ".$dif_tempo." tempo ".$tempo." Empresa ".$fl_empresa." Data ".$date2."<br>";

	}else{

		echo "Não cadastrado.";

		echo "mes ".$mes." year ".$year." dt_fechamento ".$ds_data." Produto ".$cod_produto." total_exp ".$total_exp." media ".$media." giro ".$giro." dif_tempo ".$dif_tempo." tempo ".$tempo." Empresa ".$fl_empresa." Data ".$date2."<br>";

	}
}

$link->close();
?>