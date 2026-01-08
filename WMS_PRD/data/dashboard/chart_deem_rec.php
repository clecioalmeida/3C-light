<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

/* PESO TRANSPORTADOR POR DIA */

$sql="select id, date_format(ds_data,'%m/%Y') as ds_data, coalesce(sum(nr_trans_dep),0) as nr_trans_dep, coalesce(sum(nr_dem_proc),0) as nr_dem_proc from tb_fc_rec_sap group by month(ds_data)";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	if($parte['nr_dem_proc'] == 0){

		if($parte['nr_trans_dep'] == 0){

			$percent = '0';

		}else{

			$percent = '100';

		}

	}else{

		$percent = number_format((($parte['nr_dem_proc']/$parte['nr_trans_dep'])*-100)+100, 2, '.', '');

	}

	$array_parte[] = array(
		'id' 		=> $parte['id'],
		'ds_data' 	=> $parte['ds_data'],
		'percent' 	=> $percent,		
		'prazo' 	=> number_format(98, 2, '.', ''),
	);
}

$link->close();
?>
