<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

if(date("m") == "01"){

	$year = date("Y");
	$mes = "12";

}else{

	$year = date("Y");
	$mes = "06";//date("m")-1;

}

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

		$ds_data 	= $year."-".$mes;

		$sql_dt = "insert into tb_fc_est (ds_data, nr_pos_ocp, nr_ocupa_sku, nr_total_sku, fl_empresa, fl_tipo, dt_create) values ('$ds_data', '$end_ocupa', '$ocupa', '$total_sku', '".$dados['id_oper']."', '".$dados['fl_tipo']."', '$data')" or die(mysqli_error($sql_dt));
		$res_dt = mysqli_query($link, $sql_dt);

		echo "Funciona! Total ocupado: ".$end_ocupa.", Perc Ocupado: ".$ocupa." Empresa: ".$id_oper;

	}else{

		echo "Não há dados para mostrar.";

	}
}

$link->close();
?>