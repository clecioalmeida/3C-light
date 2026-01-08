<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$id = $_REQUEST['id'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$sql_ped = "select t1.*, t2.nm_cliente, t3.dt_limite, t2.ds_cidade, t3.hr_limite
from tb_nf_saida t1
left join tb_cliente t2 on t1.id_destinatario = t2.cod_cliente
left join tb_pedido_coleta t3 on t1.nr_pedido = t3.nr_pedido";
$res_ped = mysqli_query($link, $sql_ped);

while ($entrega = mysqli_fetch_assoc($res_ped)) {
	$array_entrega[] = array(
		'nm_cliente' => $entrega['nm_cliente'],
		'ds_cidade' => $entrega['ds_cidade'],
		'dt_limite' => $entrega['dt_limite'],
		'hr_limite' => $entrega['hr_limite'],
	);
}

echo (json_encode($array_entrega));

?>