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

$sql="select * from tb_fc_est where fl_tipo = 'P' and fl_empresa = '$cod_cli'";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	$array_parte[] = array(
		'ds_data' 		=> $parte['ds_data'],
		'nr_ocupa_sku' 	=> $parte['nr_ocupa_sku'],
		'nr_total_sku' 	=> $parte['nr_total_sku'],
	);

}

$sql_dia = "select date_format(dt_fechamento,'%d-%m-%Y') as dt_fechamento, nr_ocp, nr_ocp_sku, nr_ocp_perc from tb_fc_saldo_dia where fl_tipo = 'P' and fl_empresa = '$cod_cli' and date(dt_create) BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -30 DAY) AND CURRENT_DATE() order by date(dt_create) asc";
$res_dia = mysqli_query($link, $sql_dia);
while ($ocupa = mysqli_fetch_assoc($res_dia)) {

	$array_dia[] = array(
		'dt_fechamento' => $ocupa['dt_fechamento'],
		'nr_ocp' 		=> $ocupa['nr_ocp'],
		'nr_ocp_sku' 	=> $ocupa['nr_ocp_sku'],
		'nr_ocp_perc' 	=> $ocupa['nr_ocp_perc'],
	);

}

$link->close();
?>
