<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql="select id, date_format(ds_data,'%m/%Y') as ds_data, sum(coalesce(nr_total_sct,0)) as nr_total_sct, sum(coalesce(nr_sct_div,0)) as nr_sct_div, format(((sum(COALESCE(nr_sct_div,0))/sum(COALESCE(nr_total_sct,0))*-100)+100),2) as log_sct_perc from tb_fc_avaria where fl_status = 'A' and fl_tipo = 'S' group by month(ds_data)";
$res = mysqli_query($link, $sql);
while ($reversa = mysqli_fetch_assoc($res)) {

	$array_reversa[] = array(
		'id' 			=> $reversa['id'],
		'ds_data' 		=> $reversa['ds_data'],
		'nr_total_sct' 	=> $reversa['nr_total_sct'],
		'nr_sct_div' 	=> $reversa['nr_sct_div'],
		'log_sct_perc' 	=> $reversa['log_sct_perc'],
	);
}

$link->close();
?>
