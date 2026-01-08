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

$sql="select id, date_format(ds_data,'%m/%Y') as ds_data, month(ds_data) as mes, sum(nr_ped) as nr_ped, sum(nr_at) as nr_at from tb_fc_cron where fl_empresa = '$cod_cli' and nr_ped is not null group by month(ds_data)";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {
	if($parte['nr_ped'] > 0 && $parte['nr_at'] > 0){

		$percent = number_format(($parte['nr_at']/$parte['nr_ped'])*100, 2, '.', '');

	}else{

		$percent = 0;

	}
	$array_parte[] = array(
		'id_ind' 			=> $parte['id'],
		'ds_data' 		=> $parte['ds_data'],
		'mes' 			=> $parte['mes'],
		'nr_ped' 		=> $parte['nr_ped'],
		'nr_at' 		=> $parte['nr_at'],
		'percent' 		=> $percent,
	);
}
$link->close();
?>
