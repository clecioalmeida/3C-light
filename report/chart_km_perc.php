<?php 
$date = date('m');

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select date_format(t2.dt_conhecimento,'%d-%m-%Y') as data_man, round(SUM(t2.km_adic),2) as km_total
from tb_conhecimento t2
where t2.nr_fatura > 0
group by day(t2.dt_conhecimento)";
$res = mysqli_query($link, $sql);
while ($tipo = mysqli_fetch_assoc($res)) {

	$array_tipo[] = array(
		'data_man' 			=> $tipo['data_man'],
		'km_total' 			=> $tipo['km_total'],
	);

}

$sql_hr = "select month(t2.dt_conhecimento) as mes_veic, year(t2.dt_conhecimento) as ano_veic, round(SUM(t2.km_adic),2) as km_total
from tb_conhecimento t2
where t2.nr_fatura > 0
group by month(t2.dt_conhecimento)";
$res_hr = mysqli_query($link, $sql_hr);
while ($horas = mysqli_fetch_assoc($res_hr)) {

	$array_horas[] = array(
		'data_veic' 	=> $horas['mes_veic']."-".$horas['ano_veic'],
		'km_total' 		=> $horas['km_total'],
	);
	
}

$sql_dst = "select month(t2.dt_conhecimento) as mes_veic, year(t2.dt_conhecimento) as ano_veic, round(SUM(t2.km_adic),2) as km_total, upper(t3.nm_municipio) as nm_municipio, t3.nm_uf
from tb_conhecimento t2
left join tb_municipio t3 on t2.id_codmunf = t3.cod_municipio
where t2.nr_fatura > 0 and month(t2.dt_conhecimento) = '$date'
group by t3.nm_municipio
order by round(SUM(t2.km_adic),2) desc";
$res_dst = mysqli_query($link, $sql_dst);
while ($locais = mysqli_fetch_assoc($res_dst)) {

	$array_local[] = array(
		'data_veic' 	=> $locais['mes_veic']."-".$locais['ano_veic'],
		'km_total' 		=> $locais['km_total'],
		'ds_dst' 		=> $locais['nm_municipio']."-".$locais['nm_uf'],
	);
	
}

$link->close();
?>
