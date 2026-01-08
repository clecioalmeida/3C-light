<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$mes = month($date);

$sql_dt = "SELECT t1.produto, t2.cod_prod_cliente, avg(t1.vl_unit/t1.nr_qtde) as media 
FROM tb_nf_entrada_item t1 
RIGHT join tb_produto t2 on t1.produto = t2.cod_prod_cliente 
WHERE day(t1.dt_rec) = day(curdate())-1 and t1.produto > 0 and t1.fl_status <> 'E' and t1.vl_unit > 0 group by t1.produto" or die(mysqli_error($sql_dt));
$res_dt = mysqli_query($link, $sql_dt);
while ($dados=mysqli_fetch_assoc($res_dt)) {
	$cod_produto 	= $dados['produto'];
	$media 			= $dados['media'];
}

$sql_dt = "SELECT t1.produto, t2.cod_prod_cliente, avg(t1.vl_unit/t1.nr_qtde) as media 
FROM tb_nf_entrada_item t1 
RIGHT join tb_produto t2 on t1.produto = t2.cod_prod_cliente 
WHERE day(t1.dt_rec) = day(curdate())-1 and t1.produto > 0 and t1.fl_status <> 'E' and t1.vl_unit > 0 group by t1.produto" or die(mysqli_error($sql_dt));
$res_dt = mysqli_query($link, $sql_dt);
while ($dados=mysqli_fetch_assoc($res_dt)) {
	$cod_produto 	= $dados['produto'];
	$media 			= $dados['media'];
}

$link->close();
?>