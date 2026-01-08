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

$fl_empresa = array("3", "4");

foreach ($fl_empresa as $key => $value) {

	$ds_data 	= $mes."-".$year;

	$sql_nf = "select count(cod_minuta) as total
	from tb_minuta
	where day(dt_minuta) = day(curdate())-1 and fl_empresa = '$value'";
	$res_nf = mysqli_query($link, $sql_nf);
	$dados_nf = mysqli_fetch_assoc($res_nf);
	$total 	= $dados_nf['total'];

	$sql_dia = "select COUNT(DISTINCT day(dt_minuta)) as total_dia 
	from tb_minuta where day(dt_minuta) = day(curdate())-1 and fl_empresa = '$value'";
	$res_dia = mysqli_query($link, $sql_dia);
	$dados_dia = mysqli_fetch_assoc($res_dia);
	$total_dia 	= $dados_dia['total_dia'];

	$sql_fc = "select count(cod_minuta) as total_normal
	from tb_minuta
	where day(dt_minuta) = day(curdate())-1 and ds_tipo = 'NORMAL' and fl_empresa = '$value'";
	$res_fc = mysqli_query($link, $sql_fc);
	$dados_fc = mysqli_fetch_assoc($res_fc);
	$total_normal 	= $dados_fc['total_normal'];

	$sql_pr = "select count(cod_minuta) as total_spot
	from tb_minuta
	where day(dt_minuta) = day(curdate())-1 and ds_tipo = 'SPOT' and fl_empresa = '$value'";
	$res_pr= mysqli_query($link, $sql_pr);
	$dados_pr = mysqli_fetch_assoc($res_pr);
	$total_spot 	= $dados_pr['total_spot'];

	echo $total."<br>";
	echo $total_normal."<br>";
	echo $total_spot."<br>";
	echo $total_dia."<br>";

	if($res_nf){

		$sql_dt = "insert into tb_fc_veic (ds_data, nr_veic_total, nr_dia_total, nr_veic_fx, nr_veic_sp, fl_empresa, dt_create) values ('$ds_data', '$total', '$total_dia', '$total_normal', '$total_spot', '$value', '$data')";
		$res_dt = mysqli_query($link, $sql_dt);

		if(mysqli_affected_rows($link) > 0){

			echo "Funciona<br>";

		}else{

			echo "Nao funciona<br>";
			
		}

	}

}

$link->close();
?>