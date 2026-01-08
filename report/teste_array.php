<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y");

require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "SELECT centro_custo, qtd_total, GROUP_CONCAT(qtd_total) as qtd_group, GROUP_CONCAT(ano_cr) as ano_cr 
FROM
(
  select t2.cod_depto as centro_custo,  round(sum(t3.nr_qtde),0) as qtd_total, year(t1.dt_create) as ano_cr
from tb_pedido_coleta t1
left join tb_funcionario t2 on t1.cod_almox = t2.nr_matricula
left join tb_pedido_coleta_produto t3 on t1.nr_pedido = t3.nr_pedido
where t1.fl_status = 'F' and t2.cod_depto > 0
group by t2.cod_depto, year(t1.dt_create)
order by t2.cod_depto, ano_cr
) s
group by centro_custo
order by qtd_total desc, ano_cr asc
LIMIT 20";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	$qtd = explode(',', $parte['qtd_group']);
	$ano = explode(',', $parte['ano_cr']);

	$array_parte[] = array(
		'centro_custo' 	=> $parte['centro_custo'],
		'qtd_total1' 	=> $qtd[0],
		'qtd_total2' 	=> $qtd[1],
		'ano1' 			=> $ano[0],
		'ano2' 			=> $ano[1],
	);

}

echo json_encode($array_parte, JSON_PRETTY_PRINT);
$link->close();
?>