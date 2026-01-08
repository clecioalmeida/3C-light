<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec = $_POST['id_rec'];

$query_nf_rec = "select COUNT(t1.cod_nf_entrada_item) as total 
from tb_nf_entrada_item t1
left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
where t2.cod_rec = '$cod_rec'";
$res_rec = mysqli_query($link, $query_nf_rec);
$total = mysqli_fetch_assoc($res_rec);
$total_prd = $total['total'];

if ($total_prd > 0) {

	$lib_rec = "update tb_recebimento set fl_status = 'L' where cod_recebimento = '$cod_rec'";
	$res_lib = mysqli_query($link, $lib_rec);

	if(mysqli_affected_rows($link) > 0){

		$retorno[] = array(
			'info' => "0",
		);

		echo (json_encode($retorno));

	}else{

		$retorno[] = array(
			'info' => "1",
		);

		echo (json_encode($retorno));

	}

} else {

	$retorno[] = array(
		'info' => "2",
	);

	echo (json_encode($retorno));

}
$link->close();
?>