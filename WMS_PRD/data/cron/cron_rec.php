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

$sql_dt = "SELECT count(t1.cod_nf_entrada) as total_nf, count(DISTINCT t2.produto) as total_sku, t3.fl_empresa 
FROM tb_nf_entrada t1 
left join tb_nf_entrada_item t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
left join tb_recebimento t3 on t1.cod_rec = t3.cod_recebimento
WHERE day(t1.dt_create) = day(curdate())-1 and t1.fl_status <> 'E' and t3.fl_status <> 'E' and t2.produto > 0 group by t3.fl_empresa" or die(mysqli_error($sql_dt));
$res_dt = mysqli_query($link, $sql_dt);

if(mysqli_num_rows($res_dt) > 0){


	while ($dados=mysqli_fetch_assoc($res_dt)) {

		$total_nf 		= $dados['total_nf'];
		$total_sku 		= $dados['total_sku'];
		$fl_empresa 		= $dados['fl_empresa'];

		$ds_data 		= $year."-".$mes;

		$ins_rec = "insert into tb_fc_rec (ds_data, nr_total_sku, nr_total_nf, fl_empresa, dt_create) values ('$ds_data', '$total_sku', '$total_nf', '$fl_empresa', '$data')" or die(mysqli_error($sql_dt));
		$res_ins = mysqli_query($link, $ins_rec);

	}

	echo "Funciona!";

}else{

	echo "Não há dados para mostrar.";

}

$link->close();
?>