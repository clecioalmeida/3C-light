<?php 
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select year(t1.dt_create) as ano_cr, t2.cod_depto as centro_custo, count(t1.cod_pedido) as cr_total, sum(t3.vl_unit) as vlr_total
from tb_pedido_coleta t1
left join tb_funcionario t2 on t1.cod_almox = t2.nr_matricula
left join tb_pedido_coleta_produto t3 on t1.nr_pedido = t3.nr_pedido
where t1.fl_status = 'F' and t2.cod_depto > 0
group by t2.cod_depto
order by count(t1.cod_pedido) desc
limit 20";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	$array_parte[] = array(
		'centro_custo' 	=> $parte['centro_custo'],
		'cr_total' 		=> $parte['cr_total'],
		'vlr_total' 	=> $parte['vlr_total'],
	);

}

/*$sql = "select COALESCE(t2.ds_custo,0) as ds_custo, sum(t1.nr_qtde) as nr_qtde, t1.produto
from tb_pedido_coleta_produto t1
left join tb_pedido_coleta t2 on t1.nr_pedido = t2.nr_pedido
where t2.fl_status = 'F' and t2.ds_custo > 0
group by t2.ds_custo";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	$sql_vlr = "select id, t1.vlr_med
	from tb_vlr_est t1
	where t1.cod_prd = '".$parte['produto']."'
    order by id desc
	limit 1";
	$res_vlr = mysqli_query($link, $sql_vlr);
	$valor = mysqli_fetch_assoc($res_vlr);

	$vlr_prd = $valor['vlr_med'] * $parte['nr_qtd'];

	$array_parte[] = array(
		'centro_custo' 	=> $parte['ds_custo'],
		'cr_total' 		=> $vlr_prd,
	);

}*/

$link->close();
?>
