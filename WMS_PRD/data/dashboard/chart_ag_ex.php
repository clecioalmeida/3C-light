<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;

} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}

?>
<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

/* PESO TRANSPORTADOR POR DIA */

$sql="select id, date_format(ds_data,'%m/%Y') as ds_data, month(ds_data) as ds_mes,  nr_total_rec, nr_total_ex from tb_fc_rec where fl_empresa = '$cod_cli' and nr_total_rec is not null";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {
	if($parte['nr_total_rec'] > 0 && $parte['nr_total_ex'] > 0){

		$percent = number_format(($parte['nr_total_ex']/$parte['nr_total_rec'])*100, 2, '.', '');

	}else{

		$percent = 0;

	}
	$array_parte[] = array(
		'ds_mes' 		=> $parte['ds_mes'],
		'ds_data' 		=> $parte['ds_data'],
		'nr_total_rec' 	=> $parte['nr_total_rec'],
		'nr_total_ex' 	=> $parte['nr_total_ex'],
		'percent' 		=> $percent,
	);
}
$link->close();
?>
