<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select id, date(dt_create) as data from tb_fc_sku_rec where ds_data = '0'";
$res = mysqli_query($link, $sql) or die(mysqli_error($link));
while ($dados_nf=mysqli_fetch_assoc($res)) {

	$id 			= $dados_nf['id'];
	$data 		= $dados_nf['data'];

	$sql_prd = "update tb_fc_sku_rec set ds_data = '$data' where id = '$id'";
	$res_prd = mysqli_query($link, $sql_prd) or die(mysqli_error($link));

	echo "id ".$id.", data ".$data."<br>";


}

$link->close();
?>