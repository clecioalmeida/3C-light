<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql="select id, date_format(ds_data,'%m/%Y') as ds_data, sum(coalesce(sku_int,0)) as sku_int, sum(coalesce(vlr_int,0)) as vlr_int, sum(coalesce(sku_for,0)) as sku_for, sum(coalesce(vlr_for,0)) as vlr_for, sum(coalesce(sku_cli,0)) as sku_cli, sum(coalesce(vlr_cli,0)) as vlr_cli, sum(coalesce(sku_total,0)) as sku_total, sum(coalesce(vlr_total,0)) as vlr_total from tb_fc_avaria where fl_status = 'A' and fl_tipo = 'A' group by month(ds_data)";
$res = mysqli_query($link, $sql);
while ($avaria = mysqli_fetch_assoc($res)) {

	$array_avaria[] = array(
		'id' 		=> $avaria['id'],
		'ds_data' 	=> $avaria['ds_data'],
		'sku_int' 	=> $avaria['sku_int'],
		'vlr_int' 	=> $avaria['vlr_int'],
		'sku_for' 	=> $avaria['sku_for'],
		'vlr_for' 	=> $avaria['vlr_for'],
		'sku_cli' 	=> $avaria['sku_cli'],
		'vlr_cli' 	=> $avaria['vlr_cli'],
		'sku_total' => $avaria['sku_total'],
		'vlr_total' => $avaria['vlr_total'],
	);
}

$link->close();
?>
