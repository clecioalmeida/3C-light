<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d");
$data = date("Y-m-d H:i:s");
$date2 = $date;
//$date2 = date('Y-m-d', strtotime('-1 days', strtotime($date)));

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_1 = "select t2.id_oper, count(t1.id) as end, t2.fl_tipo
from tb_endereco t1
left join tb_armazem t2 on t1.galpao = t2.id
where t1.fl_status = 'A' and t2.fl_tipo <> 'V'
group by t2.id_oper, t2.fl_tipo" or die(mysqli_error($sql_1));
$res_1 = mysqli_query($link, $sql_1);
while ($dados=mysqli_fetch_assoc($res_1)) {

	$sql_2 = "select DISTINCT t1.produto as total_sku
	from tb_posicao_pallet t1
	left join tb_armazem t2 on t1.ds_galpao = t2.id
	where t1.fl_status = 'A' and t1.fl_empresa = '".$dados['id_oper']."' and t2.fl_tipo <> 'V' and t2.fl_tipo = '".$dados['fl_tipo']."' and t1.produto > 0 and t1.nr_qtde > 0" or die(mysqli_error($sql_2));
	$res_2 = mysqli_query($link, $sql_2);
	$total_sku = mysqli_num_rows($res_2);

	$sql_3 = "select t1.ds_prateleira, t1.ds_coluna, t1.ds_altura
	from tb_posicao_pallet t1
	left join tb_armazem t2 on t1.ds_galpao = t2.id
	where t1.fl_status = 'A' and t1.fl_empresa = '".$dados['id_oper']."' and t2.fl_tipo <> 'V' and t2.fl_tipo <> 'V' and t2.fl_tipo = '".$dados['fl_tipo']."' and t1.nr_qtde > 0
	group by t1.ds_prateleira, t1.ds_coluna, t1.ds_altura" or die(mysqli_error($sql_3));
	$res_3 = mysqli_query($link, $sql_3);

	if($res_3){

		$end_ocupa = mysqli_num_rows($res_3);

		$ocupa	= ($end_ocupa/$dados['end'])*100;

		$sql_ins = "insert into tb_fc_saldo_dia (dt_fechamento, nr_ocp, nr_ocp_sku, nr_ocp_perc, fl_tipo, fl_empresa, usr_create, dt_create) values ('$date2', '$end_ocupa', '$total_sku', '$ocupa', '".$dados['fl_tipo']."', '".$dados['id_oper']."', '999', '$data')" or die(mysqli_error($sql_dt));
		$res_ins = mysqli_query($link, $sql_ins);

		echo "Funciona! Total ocupado: ".$end_ocupa.", Perc Ocupado: ".$ocupa." Empresa: ".$id_oper."<br>";

	}else{

		echo "Não há dados para mostrar.";

	}
}

$link->close();
?>