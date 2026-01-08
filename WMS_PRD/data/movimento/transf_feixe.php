<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$feixe_rua 		= $_POST['feixe_rua'];
$feixe_mod 		= $_POST['feixe_mod'];
$id_feixe 		= $_POST['id_feixe'];
$ds_galpao 		= $_POST['ds_galpao'];
$ds_rua 		= $_POST['ds_rua'];
$ds_coluna 		= $_POST['ds_coluna'];
$ds_altura 		= $_POST['ds_altura'];
$torre_feixe 	= $_POST['torre_feixe'];
$parte_feixe 	= $_POST['parte_feixe'];

$query_fx = "select t1.cod_estoque, t1.produto, t1.nr_qtde, t1.nr_nf_entrada, t1.id_tar 
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_item_torre t3 on t2.cod_produto = t3.id_item or t2.id_torre = t3.id_item
where t1.ds_prateleira = '$feixe_rua' and t1.ds_coluna = '$feixe_mod' and t1.ds_embalagem = '$id_feixe' and t3.id_torre = '$torre_feixe' and t3.id_parte = '$parte_feixe' and t1.nr_qtde > 0";
$res_fx = mysqli_query($link, $query_fx) or die(mysqli_error($link));
while ($dados=mysqli_Fetch_assoc($res_fx)) {
	$cod_estoque=$dados['cod_estoque'];
	$produto=$dados['produto'];
	$nr_nf_entrada=$dados['nr_nf_entrada'];
	$nr_qtde=$dados['nr_qtde'];
	$id_tar=$dados['id_tar'];

	$sql = "insert into tb_posicao_pallet (produto, ds_galpao, ds_prateleira, ds_altura, ds_coluna, nr_qtde, ds_embalagem, nr_nf_entrada, id_tar, user_update, dt_update) values ('$produto', '$ds_galpao', '$ds_rua', '$ds_altura', '$ds_coluna', '$nr_qtde', '$id_feixe', '$nr_nf_entrada', '$id_tar', '$id', now())";
	$result_id = mysqli_query($link1, $sql) or die(mysqli_error($link1));

	$new_pp = mysqli_insert_id($link1);

	if(mysqli_affected_rows($link1)){

		$upd_pp = "update tb_posicao_pallet set nr_qtde = 0, fl_status = 'E' where cod_estoque = '$cod_estoque'";
		$res_pp = mysqli_query($link, $upd_pp) or die(mysqli_error($link));

		$upd_ppa = "update tb_posicao_pallet set nr_or = 0, nr_posicao_temp = '$cod_estoque' where cod_estoque = '$new_pp'";
		$res_ppa = mysqli_query($link, $upd_ppa) or die(mysqli_error($link));		

	}else{

		$array_info[] = array(

			'info' => "2",
		);
		echo (json_encode($array_info));

	}
}

if (mysqli_affected_rows($link) > 0) {

	$array_info[] = array(

		'info' => "0",
	);
	echo (json_encode($array_info));

} else {

	$array_info[] = array(

		'info' => "1",
	);
	echo (json_encode($array_info));

}

$link->close();
$link1->close();
?>