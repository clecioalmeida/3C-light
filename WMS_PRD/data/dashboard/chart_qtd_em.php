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

$sql="select * from tb_fc_qtd_at where fl_empresa = '$cod_cli' order by ds_data asc";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {
	if($parte['nr_total_ped'] > 0 && $parte['nr_total_em'] > 0){

		$percent = number_format(($parte['nr_total_em']/$parte['nr_total_ped'])*100, 2, '.', '');

	}else{

		$percent = 0;

	}
	$array_parte[] = array(
		'ds_data' 		=> $parte['ds_data'],
		'nr_total_em' 	=> $parte['nr_total_em'],
		'nr_total_ped' 	=> $parte['nr_total_ped'],
		'percent' 		=> $percent,
	);
}

$link->close();
?>
