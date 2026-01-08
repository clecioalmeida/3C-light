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

$sql="select id, date_format(ds_data,'%m/%Y') as ds_data, ds_data as ds_mes, coalesce(nr_nf_rec,0) as nr_nf_rec, coalesce(nr_forn_rec,0) as nr_forn_rec, coalesce(nr_sku_rec,0) as nr_sku_rec from tb_fc_sku_rec where fl_empresa = '$cod_cli' group by ds_data";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {
	if($parte['nr_sku_rec'] > 0 && $parte['nr_sku_rec'] > 0){

		$media = number_format(($parte['nr_sku_rec']/$parte['nr_forn_rec']), 2, '.', '');

	}else{

		$media = 0;

	}
	$array_parte[] = array(
		'ds_mes' 		=> $parte['ds_mes'],
		'ds_data' 		=> $parte['ds_data'],
		'nr_nf_rec' 	=> $parte['nr_nf_rec'],
		'nr_sku_rec' 	=> $parte['nr_sku_rec'],
		'nr_forn_rec' 	=> $parte['nr_forn_rec'],
		'media' 		=> $media,
	);
}
$link->close();
?>
