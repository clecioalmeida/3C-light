<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec = $_POST['id_rec'];

/*$sql_prd = "select count(t1.cod_nf_entrada_item) as total_prd 
from tb_nf_entrada_item t1
left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
where t2.cod_ag = '$cod_rec'";
$res_prd = mysqli_query($link, $sql_prd);
$dados_pr = mysqli_fetch_assoc($res_prd);
$total_prd = $dados_pr['total_prd'];

if($total_prd == 0){

	$retorno[] = array(
		'info' => "2",
	);

	echo (json_encode($retorno));

}else{*/

	$lib_rec = "update tb_recebimento_ag set fl_status = 'AG' where cod_recebimento = '$cod_rec'";
	$res_lib = mysqli_query($link, $lib_rec);

	if(mysqli_affected_rows($link) > 0){

		$upd_jan = "update tb_janela set fl_status = 'C' where cod_rec = '$cod_rec'";
		$res_jan = mysqli_query($link, $upd_jan);

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
//}

$link->close();
?>