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

$sql="select id, ds_data, CONCAT(month(ds_data),'-',YEAR(ds_data)) as ds_mes, nr_veic_total, nr_veic_fx, nr_dia_total from tb_fc_veic where fl_empresa = '$cod_cli' order by ds_data asc";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {
	if($parte['nr_veic_total'] > 0 && $parte['nr_veic_fx'] > 0){

		$media = number_format(($parte['nr_veic_fx']/$parte['nr_dia_total']), 2, '.', '');

	}else{

		$media = 0;

	}
	$array_parte[] = array(
		'id' 			=> $parte['id'],
		'ds_data' 		=> $parte['ds_data'],
		'ds_mes' 		=> $parte['ds_mes'],
		'nr_veic_total' => $parte['nr_veic_total'],
		'nr_veic_fx' 	=> $parte['nr_veic_fx'],
		'media' 		=> $media,
	);
}
$link->close();
?>