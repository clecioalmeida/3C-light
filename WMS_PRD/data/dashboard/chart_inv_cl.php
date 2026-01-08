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

$sql = "select id, ds_data, CASE WHEN nr_ac_sku >= '100' THEN '100.00' ELSE nr_ac_sku end as nr_ac_sku, CASE WHEN vlr_div >= '100' THEN '100.00' ELSE vlr_div end as vlr_div
from tb_fc_inv_dep 
where fl_empresa = '$cod_cli' and fl_status = 'A' and fl_tipo = 'C'";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	$array_parte[] = array(
		'id' 			=> $parte['id'],
		'ds_data' 		=> $parte['ds_data'],
		'nr_ac_sku' 	=> $parte['nr_ac_sku'],
		'vlr_div' 		=> $parte['vlr_div'],
	);

}

$link->close();
?>