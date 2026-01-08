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

$sql="select t1.ds_data, month(t1.ds_data) as ds_mes, sum(t1.nr_total_sts) as total_st, t2.nr_total_sts as finalizado  
from tb_fc_ag t1
left join tb_fc_ag t2 on t1.ds_data = t2.ds_data and t2.ds_status = 'FINALIZADO' 
where t1.fl_empresa = '$cod_cli' and t2.fl_empresa = '$cod_cli'
group by t1.ds_data";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {
	if($parte['total_st'] > 0 && $parte['finalizado'] > 0){

		$percent = number_format(($parte['finalizado']/$parte['total_st'])*100, 2, '.', '');

	}else{

		$media = 0;

	}
	$array_parte[] = array(
		'ds_mes' 		=> $parte['ds_mes'],
		'ds_data' 		=> $parte['ds_data'],
		'total_st' 		=> $parte['total_st'],
		'finalizado' 	=> $parte['finalizado'],
		'percent' 		=> $percent,
	);
}
$link->close();
?>
