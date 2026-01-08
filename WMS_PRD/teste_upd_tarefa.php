<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select t1.id, t1.ds_lp 
from tb_inv_tarefa t1
where t1.fl_status = 'A'";
$res = mysqli_query($link, $sql);
while ($dados_nf=mysqli_fetch_assoc($res)) {

	$id 		= $dados_nf['id'];
	$ds_lp 		= $dados_nf['ds_lp'];

	$sql_est = "SELECT cod_estoque FROM `tb_posicao_pallet` WHERE ds_lp = '$ds_lp'";
	$res_est = mysqli_query($link, $sql_est) or die(mysqli_error($link));
	while ($dados_lp=mysqli_fetch_assoc($res_est)) {

		$cod_estoque 		= $dados_lp['cod_estoque'];

		$sql_prd = "update tb_inv_tarefa set id_estoque = '$cod_estoque' where id = '$id'";
		$res_prd = mysqli_query($link, $sql_prd) or die(mysqli_error($link));
	
		echo "cod_estoque ".$cod_estoque.", tarefa ".$id."<br>";

	}


}

$link->close();
?>