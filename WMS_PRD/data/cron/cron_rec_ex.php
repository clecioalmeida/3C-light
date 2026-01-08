<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

if(date("m") == "01"){

	$year = date("Y")-1;
	$mes = "12";

}else{

	$year = date("Y");
	$mes = date("m");

}

$sql_dt = "select count(t1.cod_rec) as total_rec, count(t2.id) as total_extra, t1.fl_empresa  
from tb_janela t1
left join tb_janela t2 on t1.id = t2.id and t2.fl_tipo = 'E'
left join tb_recebimento t3 on t1.cod_rec = t3.cod_recebimento
where t3.fl_status <> 'E' and day(t1.dt_janela) = day(curdate())-1 group by t1.fl_empresa";
$res_dt = mysqli_query($link, $sql_dt);
while ($dados=mysqli_fetch_assoc($res_dt)) {

	$total_rec 			= $dados['total_rec'];
	$total_extra 		= $dados['total_extra'];
	$fl_empresa 		= $dados['fl_empresa'];

	$ds_data 			= $year."-".$mes;

	$ins_rec = "insert into tb_fc_rec (ds_data, nr_total_rec, nr_total_ex, fl_empresa, dt_create) values ('$ds_data', '$total_rec', '$total_extra', '$fl_empresa', '$data')";
	$res_ins = mysqli_query($link, $ins_rec);

}

$link->close();
?>