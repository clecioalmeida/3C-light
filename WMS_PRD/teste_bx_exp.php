<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

$sql_exp = "select t1.nr_pedido, t1.produto, t1.ds_lp, t1.nr_qtde
from tb_pedido_coleta_produto t1
where t1.cod_ped >= '1075'";
$res_exp = mysqli_query($link, $sql_exp);

while ($nr_ped = mysqli_fetch_assoc($res_exp)) {

	echo "Pedido: " . $nr_ped['nr_pedido'] . " Produto: " . $nr_ped['produto'] . " Qtde: " . $nr_ped['nr_qtde'] . "<br>";

	$query_cod = "select t1.cod_estoque, t1.ds_lp, t1.nr_qtde, t1.n_serie
	from tb_posicao_pallet t1
	where (t1.ds_lp = '" . $nr_ped['ds_lp'] . "' or t1.n_serie = '" . $nr_ped['ds_lp'] . "') and t1.nr_qtde > 0";
	$res_col = mysqli_query($link, $query_cod);
	while ($parte = mysqli_fetch_assoc($res_col)) {

		$cod_estoque        = $parte['cod_estoque'];
		$nr_qtde        	= $parte['nr_qtde'];

		$sql_saldo = "update tb_posicao_pallet set 
		nr_qtde = '" . $nr_ped['nr_qtde'] . "', nr_qtde_ant = '$nr_qtde_pp', nr_pedido_ant = '" . $nr_ped['nr_pedido'] . "', user_update = '1', dt_update = '$date' 
		where cod_estoque = '$cod_estoque'";
		$saldo = mysqli_query($link, $sql_saldo);

		$sql_prd = "update tb_pedido_coleta_produto set 
		usr_lib_exp = '1', dt_lib_exp = '$date', fl_status = 'F' 
		where nr_pedido = '" . $nr_ped['nr_pedido'] . "' and produto = '" . $nr_ped['produto'] . "'";
		$prd = mysqli_query($link1, $sql_prd);

		$sql_ped = "update tb_pedido_coleta set 
		fl_status = 'F' 
		where nr_pedido = '" . $nr_ped['nr_pedido'] . "'";
		$ped = mysqli_query($link1, $sql_ped);

		$ds_obs = "Saldo Ok!";
	}

	$sql_conf = "select fl_status 
	from tb_pedido_coleta_produto 
	where nr_pedido = '" . $nr_ped['ds_lp'] . "' and fl_status <> 'F'";
	$res_conf = mysqli_query($link, $sql_conf);

	if (mysqli_num_rows($res_conf) > 0) {


		echo "Pedido não pode ser finalizado. '" . $nr_ped['nr_pedido'] . "'";
	} else {

		$sql_ped = "update tb_pedido_coleta set fl_status = 'F', nr_minuta = '9999' where nr_pedido = '" . $nr_ped['nr_pedido'] . "'";
		$ped = mysqli_query($link1, $sql_ped);


		echo "Pedido finalizado! '" . $nr_ped['nr_pedido'] . "'";
	}
}

$link->close();
$link1->close();
$link2->close();
