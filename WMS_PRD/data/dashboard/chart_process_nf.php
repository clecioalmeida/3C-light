<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

/* PESO TRANSPORTADOR POR DIA */

$sql="select sum(nf_rec_div) as nf_rec_div, sum(nf_rec) as nf_rec, date_format(ds_data,'%m/%Y') as ds_data, id from tb_fc_rec_sap group by month(ds_data)";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	if($parte['nf_rec_div'] == 0){

		if($parte['nf_rec'] == 0){

			$percent = '0';

		}else{

			$percent = '100';

		}

	}else{

		$percent = number_format((($parte['nf_rec_div']/$parte['nf_rec'])*-100)+100, 2, '.', '');

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
