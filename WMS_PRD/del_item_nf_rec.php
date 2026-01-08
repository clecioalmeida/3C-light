<?php
require_once("bd_class.php");

$objDb = new db();
$link = $objDb->conecta_mysql();

$item_nf = $_POST["item_nf"];


$query_init="select t1.fl_status
from tb_recebimento t1
left join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec
left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
where t3.cod_nf_entrada_item = '$item_nf'";
$res_init=mysqli_query($link, $query_init);
while ($init=mysqli_fetch_assoc($res_init)) {
	$fl_status = $init['fl_status'];
}

if($fl_status == 'A'){

	$sql = "update tb_nf_entrada_item set fl_status = 'E' WHERE cod_nf_entrada = '$id_nf'";
	$res_sql = mysqli_query($link, $sql);

	if($res_sql){
		$array_conf[] = array(
			'info' => "O item da nota foi excluído!",
		);

		echo(json_encode($array_conf));
	}

}else{
	$array_conf[] = array(
		'info' => "Erro na exclusão. OR não está mais em status 'A'",
	);
	echo(json_encode($array_conf));
}

$link->close();

?>