<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql="select id, date_format(ds_data,'%m/%Y') as ds_data, sum(coalesce(nr_log_rev,0)) as nr_log_rev, sum(coalesce(log_rev_at,0)) as log_rev_at, format(((sum(COALESCE(log_rev_at,0))/sum(COALESCE(nr_log_rev,0))*-100)+100),2) as log_rev_perc from tb_fc_avaria where fl_status = 'A' and fl_tipo = 'R' group by month(ds_data)";
$res = mysqli_query($link, $sql);
while ($reversa = mysqli_fetch_assoc($res)) {

	$array_reversa[] = array(
		'id' 			=> $reversa['id'],
		'ds_data' 		=> $reversa['ds_data'],
		'nr_log_rev' 	=> $reversa['nr_log_rev'],
		'log_rev_at' 	=> $reversa['log_rev_at'],
		'log_rev_perc' 	=> $reversa['log_rev_perc'],
	);
}

$link->close();
?>
