<?php
date_default_timezone_set('America/Campo_Grande');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_2 = "select coalesce(max(date(t1.dt_log)),0) as dt_log, cod_prd, COALESCE(t1.vlr_ut,0) as vlr_ut, COALESCE(t1.vlr_med,0) as vlr_med
from tb_vlr_est t1
group by t1.cod_prd" or die(mysqli_error($sql_2));
$res_2 = mysqli_query($link, $sql_2);
while ($dados = mysqli_fetch_assoc($res_2)) {

	$sql_3 = "SELECT coalesce(max(t1.cod_rec),0) as cod_rec, t1.vl_unit
	from tb_nf_entrada_item t1
	left join tb_recebimento t2 on t1.cod_rec = t2.cod_recebimento
	where date(t2.dt_create) > '".$dados['dt_log']."' and t1.produto = '".$dados['cod_prd']."' and t1.fl_status <> 'E' and t2.fl_status = 'F'" or die(mysqli_error($sql_3));
	$res_3 = mysqli_query($link, $sql_3);

	$dados3 = mysqli_fetch_assoc($res_3);

	if($dados3['cod_rec'] > 0){


		if($dados['vlr_ut'] == 0){

			$vl_medio = $dados3['vl_unit'];

		}else{

			$vl_medio = $dados['vlr_ut']/$dados3['vl_unit'];

		}

		$sql_4 = "insert into tb_vlr_est (dt_log, cod_prd, nr_or_ut, vlr_ut, vlr_med, usr_create, dt_create) values ('".$date."', '".$dados['cod_prd']."', '".$dados3['cod_rec']."', '".$dados3['vl_unit']."','".$vl_medio."', '99','".$date."')" or die(mysqli_error($sql_4));
		$res_4 = mysqli_query($link, $sql_4);

	}

}

$link->close();
?>