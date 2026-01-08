<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d");
$data = date("Y-m-d H:i:s");
$date2 = $date;
//$date2 = date('Y-m-d', strtotime('-1 days', strtotime($date)));

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_dt = "select t1.produto, t2.fl_empresa, sum(t1.nr_qtde) as reservado 
from tb_pedido_coleta_produto t1
left join tb_pedido_coleta t2 on t1.nr_pedido = t2.nr_pedido
where date(t1.dt_lib_exp) = '$date2'
group by t1.produto, t1.fl_empresa" or die(mysqli_error($sql_dt));
$res_dt = mysqli_query($link, $sql_dt);

if(mysqli_num_rows($res_dt) > 0){


	while ($dados=mysqli_fetch_assoc($res_dt)) {

		$produto 		= $dados['produto'];
		$nr_res 		= $dados['reservado'];
		//$nr_estq 		= $dados['nr_estq'];
		$fl_empresa 	= $dados['fl_empresa'];

		$sql_res = "select t1.produto, t1.fl_empresa, sum(t1.nr_qtde) as nr_estq, t1.fl_empresa 
		from tb_posicao_pallet t1
		where t1.fl_status = 'A' and t1.produto = '$produto' and t1.fl_empresa = '$fl_empresa'" or die(mysqli_error($sql_dt));
		$res = mysqli_query($link, $sql_res);
		$reservado = mysqli_fetch_assoc($res);

		$nr_estq = $reservado['nr_estq'];
		$nr_saldo = $nr_estq - $nr_res;

		if($nr_saldo < 0){

			$nr_saldo = 0;

			$sql_ins = "insert into tb_fc_saldo_dia (dt_fechamento, cod_produto, nr_estq, nr_res, nr_saldo, fl_empresa, usr_create, dt_create) values ('$date2', '$produto', '$nr_estq', '$nr_res', '$nr_saldo', '$fl_empresa', '999', '$data')" or die(mysqli_error($sql_dt));
			$res_ins = mysqli_query($link, $sql_ins);

		}else{

			$sql_ins = "insert into tb_fc_saldo_dia (dt_fechamento, cod_produto, nr_estq, nr_res, nr_saldo, fl_empresa, usr_create, dt_create) values ('$date2', '$produto', '$nr_estq', '$nr_res', '$nr_saldo', '$fl_empresa', '999', '$data')" or die(mysqli_error($sql_dt));
			$res_ins = mysqli_query($link, $sql_ins);

		}

		echo "Produto ".$produto." Saldo ".$nr_saldo." Empresa ".$fl_empresa." Data ".$date2."<br>";

	}

}else{

	echo "Não há dados para mostrar.";

}

$link->close();
?>