<?php 
$date = date('m');

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select date_format(t2.dt_conhecimento,'%d-%m-%Y') as data_man, round(sum(t2.nr_peso_kg),2) as nr_peso, sum(t2.vl_total_frete) as total_fat
from tb_conhecimento t2
where t2.nr_fatura > 0
group by day(t2.dt_conhecimento)";
$res = mysqli_query($link, $sql);
while ($tipo = mysqli_fetch_assoc($res)) {

	$array_tipo[] = array(
		'data_man' 			=> $tipo['data_man'],
		'nr_peso' 			=> $tipo['nr_peso'],
		'total_fat' 		=> $tipo['total_fat'],
	);

}

$sql_hr = "select month(t2.dt_conhecimento) as mes_veic, year(t2.dt_conhecimento) as ano_veic, round(sum(t2.nr_peso_kg),2) as nr_peso, sum(t2.vl_total_frete) as total_fat
from tb_conhecimento t2
where t2.nr_fatura > 0
group by month(t2.dt_conhecimento)";
$res_hr = mysqli_query($link, $sql_hr);
while ($horas = mysqli_fetch_assoc($res_hr)) {

	$array_horas[] = array(
		'data_veic' 	=> $horas['mes_veic']."-".$horas['ano_veic'],
		'nr_peso' 		=> $horas['nr_peso'],
		'total_fat' 	=> $horas['total_fat'],
	);
	
}

$link->close();
?>
