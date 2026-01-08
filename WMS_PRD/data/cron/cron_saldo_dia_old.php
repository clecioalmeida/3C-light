<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d");
$data = date("Y-m-d H:i:s");
//$date2 = $date-1;
$date2 = date('Y-m-d', strtotime('-1 days', strtotime($date)));

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_dt = "select t1.produto, t1.fl_empresa, sum(t1.nr_qtde) as saldo 
from tb_posicao_pallet t1
left join tb_pedido_coleta_produto t2 on t2.nr_pedido = t1.nr_pedido_ant and t1.produto = t2.produto
left join tb_pedido_coleta t3 on t2.nr_pedido = t3.nr_pedido
where t1.fl_status = 'A' and t1.produto > 0 and date(t2.dt_lib_exp) = '$date'
group by t1.produto, t1.fl_empresa" or die(mysqli_error($sql_dt));
$res_dt = mysqli_query($link, $sql_dt);

if(mysqli_num_rows($res_dt) > 0){


	while ($dados=mysqli_fetch_assoc($res_dt)) {

		$produto 		= $dados['produto'];
		$saldo 			= $dados['saldo'];
		$fl_empresa 	= $dados['fl_empresa'];

		$sql_ins = "insert into tb_fc_saldo_dia (dt_fechamento, cod_produto, nr_saldo, fl_empresa, usr_create, dt_create) values ('$date2', '$produto', '$saldo', '$fl_empresa', '999', '$data')" or die(mysqli_error($sql_dt));
		$res_ins = mysqli_query($link, $sql_ins);

		echo "Produto ".$produto." Saldo ".$saldo." Empresa ".$fl_empresa." Data ".$date2."<br>";

	}

}else{

	echo "Não há dados para mostrar.";

}

$link->close();
?>