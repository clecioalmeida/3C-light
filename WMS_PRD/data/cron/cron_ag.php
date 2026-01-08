<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date("Y-m-d H:i:s");
$date = date("Y-m-d");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$partes = explode("-", $date);
$dia = $partes[2];
$mes = $partes[1];
$ano = $partes[0];

if($mes == "01"){

	$year = $ano-1;
	$mes = "12";

}else{

	$year = $ano;
	$mes = $mes;

}

//echo "Funciona!".$mes."-".$year;


$sql_dt = "select count(DISTINCT cod_recebimento) as total_sts, CASE fl_status WHEN 'AG' THEN 'AGENDADO' WHEN 'R' THEN 'RECUSADO' WHEN 'S' THEN 'SOLICITADO' WHEN 'X' THEN 'FINALIZADO' END as fl_status, cod_cli 
from tb_recebimento_ag 
where day(dt_create) = day(curdate())-1 and fl_status <> 'E' 
group by fl_status, cod_cli" or die(mysqli_error($sql_dt));
$res_dt = mysqli_query($link, $sql_dt);

if(mysqli_num_rows($res_dt) > 0){


	while ($dados=mysqli_fetch_assoc($res_dt)) {

		$total_sts 		= $dados['total_sts'];
		$fl_status 		= $dados['fl_status'];
		$fl_empresa 	= $dados['cod_cli'];

		$ds_data 		= $year."-".$mes;

		$sql_ins = "insert into tb_fc_ag (ds_data, nr_total_sts, ds_status, fl_empresa, fl_status, dt_create) values ('$ds_data', '$total_sts', '$fl_status', '$fl_empresa', 'A', '$data')" or die(mysqli_error($sql_dt));
		$res_ins = mysqli_query($link, $sql_ins);

	}

	echo "Funciona!".$mes."-".$year;

}else{

	echo "Não há dados para mostrar.";

}

$link->close();
?>