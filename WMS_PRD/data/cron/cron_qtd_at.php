<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

if(date("m") == "01"){

	$year = date("Y");
	$mes = "12";

}else{

	$year = date("Y");
	$mes = date("m");

}

$fl_empresa = array("3", "4");

foreach ($fl_empresa as $key => $value) {

	$ds_data 	= $mes."-".$year;

	$sql_sol = "select count(DISTINCT t1.nr_pedido) as qtd_sol 
	from tb_pedido_coleta t1
	where day(t1.dt_create) = day(curdate())-1 and t1.fl_empresa = '$value'";
	$res_sol = mysqli_query($link, $sql_sol);
	$dados_sol = mysqli_fetch_assoc($res_sol);
	$total_sol 	= $dados_sol['qtd_sol'];

	$sql_at = "select count(DISTINCT t1.nr_pedido) as qtd_sol 
	from tb_pedido_coleta t1
	where day(t1.dt_create) = day(curdate())-1 and t1.fl_empresa = '$value' and t1.fl_status = 'F'";
	$res_at = mysqli_query($link, $sql_at);
	$dados_at = mysqli_fetch_assoc($res_at);
	$total_at 	= $dados_at['qtd_at'];

	/*$sql_ped = "select count(t1.cod_pedido) as qtd_ped 
	from tb_pedido_coleta t1
	where month(t1.dt_create) = '$mes' and year(t1.dt_create) = '$year' and t1.fl_empresa = '$value' and t1.fl_status = 'F'";
	$res_ped = mysqli_query($link, $sql_ped);
	$dados_ped = mysqli_fetch_assoc($res_ped);
	$total_ped 	= $dados_ped['qtd_ped'];*/

	$sql_em = "select count(t1.cod_pedido) as qtd_em 
	from tb_pedido_coleta t1
	where day(t1.dt_create) = day(curdate())-1 and t1.fl_empresa = '$value' and t1.fl_status = 'F' and t1.ds_tipo = 'EMERGENCIAL'";
	$res_em = mysqli_query($link, $sql_em);
	$dados_em = mysqli_fetch_assoc($res_em);
	$total_em 	= $dados_em['qtd_em'];


	if($res_at){

		$sql_ins = "insert into tb_fc_qtd_at (ds_data, nr_qtd_sol, nr_qtd_at, nr_total_ped, nr_total_em, fl_empresa, dt_create) values ('$ds_data', '$total_sol', '$total_at', '$total_sol', '$total_em', '$value', '$data')";
		$res_ins = mysqli_query($link, $sql_ins);

		if(mysqli_affected_rows($link) > 0){

			echo "Funciona<br>";

		}else{

			echo "Nao funciona<br>";
			
		}

		//echo $ds_data." ".$total_sol." ".$total_ped." ".$total_em." ".$value." ".$data."<br>";

	}

}

$link->close();
?>