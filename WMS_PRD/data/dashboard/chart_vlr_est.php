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

$sql="select date_format(ds_data,'%m/%Y') as ds_data, format(sum(COALESCE(vlr_total,0)),2,'de_DE') as vlr_total, format(sum(COALESCE(vlr_medio,0)),2,'de_DE') as vlr_medio from tb_fc_est where fl_empresa = '$cod_cli' and fl_tipo = 'V' group by month(ds_data)";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	$array_parte[] = array(
		'ds_data' 		=> $parte['ds_data'],
		'vlr_total' 	=> $parte['vlr_total'],
		'vlr_medio' 	=> $parte['vlr_medio'],
	);

}

$link->close();
?>
