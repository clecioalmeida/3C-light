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

$ped_tempo_a = "SELECT date(dt_exp) as data_exp, date_format(dt_exp,'%d-%m-%Y') as dt_exp, round(avg(nr_total_dia),2) as media_dia FROM tb_fc_tmp_ped WHERE fl_empresa = '$cod_cli' and date(dt_exp) BETWEEN CURRENT_DATE() -30 AND CURRENT_DATE()
group by date(dt_exp)
order by date(dt_exp) asc";
$ped_a = mysqli_query($link, $ped_tempo_a);

while ($pedido_expede = mysqli_fetch_array($ped_a)) {
	$array_expede[] = array(
		'data_exp' 	=> $pedido_expede['data_exp'],
		'dt_exp' 	=> $pedido_expede['dt_exp'],
		'media_dia' => $pedido_expede['media_dia'],
		'prazo' => 2,
	);
}

$ped_mes = "SELECT concat(month(dt_exp),'-',year(dt_exp)) as dt_exp, round(avg(nr_total_dia),2) as media_mes FROM tb_fc_tmp_ped WHERE fl_empresa = '$cod_cli'
group by month(dt_exp)";
$ped_mes = mysqli_query($link, $ped_mes);

while ($pedido_mes = mysqli_fetch_array($ped_mes)) {
	$array_mes[] = array(
		'dt_exp' => $pedido_mes['dt_exp'],
		'media_mes' => $pedido_mes['media_mes'],
		'prazo' => 2,
	);
}
$link->close();
?>
