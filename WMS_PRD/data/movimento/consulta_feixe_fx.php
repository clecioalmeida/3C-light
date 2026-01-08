<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rua = $_REQUEST['id_rua'];
$id_modulo = $_REQUEST['id_modulo'];

$sql_end = "select distinct t1.ds_embalagem, t3.id_torre, t4.ds_torre, t4.ds_tensao, t4.ds_circuito, t4.ds_tipo, t3.id_parte, t5.parte 
from tb_posicao_pallet t1 
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_item_torre t3 on t2.cod_produto = t3.id_item or t2.id_torre = t3.id_item
left join tb_tipo_torre t4 on t3.id_torre = t4.id
left join tb_tp_torre t5 on t3.id_parte = t5.id
where t1.ds_prateleira = '$id_rua' and t1.ds_coluna = '$id_modulo' and t1.nr_qtde > 0
order by  t3.id_torre,  t3.id_parte, t1.ds_embalagem asc";
$res_end = mysqli_query($link, $sql_end);

while ($end = mysqli_fetch_assoc($res_end)) {
	$array_end[] = array(
		'ds_embalagem' 	=> $end['ds_embalagem'],
		'id_torre' 		=> $end['id_torre'],
		'ds_torre' 		=> $end['ds_torre'],
		'ds_tensao' 	=> $end['ds_tensao'],
		'ds_circuito' 	=> $end['ds_circuito'],
		'ds_tipo' 		=> $end['ds_tipo'],
		'id_parte' 		=> $end['id_parte'],
		'parte' 		=> $end['parte'],
	);
}

echo (json_encode($array_end));
$link->close();
?>