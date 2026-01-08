<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select t1.nr_pedido, t1.produto, coalesce(t1.vl_unit,0) as vl_unit, date(t1.dt_create) as data_ped
from tb_pedido_coleta_produto t1
where t1.fl_status = 'F'";
$res = mysqli_query($link, $sql) or die(mysqli_error($link));

while ($dados_nf=mysqli_fetch_assoc($res)) {

	$produto = $dados_nf['produto'];
	$vl_unit = $dados_nf['vl_unit'];
	$nr_pedido = $dados_nf['nr_pedido'];
	$data_ped = $dados_nf['data_ped'];

	$sql2 = "select id, dt_create, vlr_med, date(dt_create) as data_vlr
	from tb_vlr_est
	where cod_prd = '".$produto."' and (date(dt_create) <= '".$data_ped."' or date(dt_create) = '2020-11-29')
	order by id desc limit 1";
	$res2 = mysqli_query($link, $sql2) or die(mysqli_error($link));
	$dados_prd = mysqli_fetch_assoc($res2);

	echo "nr_pedido: ".$nr_pedido." - produto: ".$produto." - vl_unit: ".$vl_unit." - vlr_med: ".$dados_prd['vlr_med']." - data_ped: ".$data_ped." - data_vlr: ".$dados_prd['data_vlr']."<br>";

	$ins_nf = "update tb_pedido_coleta_produto set vl_unit = ".$dados_prd['vlr_med']." where nr_pedido = '".$nr_pedido."' and produto = '".$produto."'";
	$res_nf = mysqli_query($link, $ins_nf);

	if(mysqli_affected_rows($link) > 0){

		echo"nr_pedido: ".$nr_pedido." alterado.<br>";
		
	}else{

		echo "Erro no cadastro.<br>";

	}
	

}

$link->close();
?>