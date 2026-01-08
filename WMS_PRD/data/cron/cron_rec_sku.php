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
	//echo "ds_data ".$ds_data."<br>";

	$sql_nf = "select count(distinct t1.cod_nf_entrada) as total_nf from tb_nf_entrada t1
	left join tb_recebimento t2 on t1.cod_rec = t2.cod_recebimento
	where t2.fl_empresa = '$value' and day(t1.dt_create) = day(curdate())-1 and t2.fl_status <> 'E'";
	$res_nf = mysqli_query($link, $sql_nf);
	$dados_nf = mysqli_fetch_assoc($res_nf);
	$total_nf 	= $dados_nf['total_nf'];

	$sql_fc = "select count(distinct t1.cod_fornecedor) as total_fc from tb_nf_entrada t1
	left join tb_recebimento t2 on t1.cod_rec = t2.cod_recebimento
	where t2.fl_empresa = '$value' and day(t1.dt_create) = day(curdate())-1 and t2.fl_status <> 'E'";
	$res_fc = mysqli_query($link, $sql_fc);
	$dados_fc = mysqli_fetch_assoc($res_fc);
	$total_fc 	= $dados_fc['total_fc'];

	$sql_pr = "select count(distinct t1.produto) as total_pr from tb_nf_entrada_item t1
	left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
	left join tb_recebimento t3 on t2.cod_rec = t3.cod_recebimento
	where t3.fl_empresa = '$value' and day(t1.dt_rec) = day(curdate())-1 and t3.fl_status <> 'E'";
	$res_pr= mysqli_query($link, $sql_pr);
	$dados_pr = mysqli_fetch_assoc($res_pr);
	$total_pr 	= $dados_pr['total_pr'];	

	if($res_pr){

		$sql_dt = "insert into tb_fc_sku_rec (ds_data, nr_nf_rec, nr_forn_rec, nr_sku_rec, fl_empresa, dt_create) values ('$ds_data', '$total_nf', '$total_fc', '$total_pr', '$value', '$data')" or die(mysqli_error($sql_dt));
		$res_dt = mysqli_query($link, $sql_dt);

	}

}

$link->close();
?>