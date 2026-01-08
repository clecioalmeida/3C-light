<?php 
$date = date('m');

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select date_format(t2.dt_conhecimento,'%d-%m-%Y') as data_man, count(DISTINCT t2.id_codmunf) as qtd_dst
from tb_conhecimento t2
where t2.nr_fatura > 0
group by day(t2.dt_conhecimento)";
$res = mysqli_query($link, $sql);
while ($tipo = mysqli_fetch_assoc($res)) {

	$array_tipo[] = array(
		'data_man' 			=> $tipo['data_man'],
		'qtd_dst' 			=> $tipo['qtd_dst'],
	);

}

$sql_hr = "select month(t1.dt_create) as mes_veic, year(t1.dt_create) as ano_veic, count(DISTINCT t1.codmund) as qtd_dst_mes
from tb_manifesto t1
left join tb_conhecimento t2 on t1.id_man = t2.nr_manifesto
where t2.nr_fatura > 0
group by month(dt_create)";
$res_hr = mysqli_query($link, $sql_hr);
while ($horas = mysqli_fetch_assoc($res_hr)) {

	$array_horas[] = array(
		'data_veic' 	=> $horas['mes_veic']."-".$horas['ano_veic'],
		'qtd_dst_mes' 	=> $horas['qtd_dst_mes'],
	);
	
}

$sql_dst = "select month(t2.dt_conhecimento) as mes_veic, year(t2.dt_conhecimento) as ano_veic, count(t2.id_codmunf) as qtd_dst_mes, upper(t3.nm_municipio) as nm_municipio, t3.nm_uf
from tb_conhecimento t2
left join tb_municipio t3 on t2.id_codmunf = t3.cod_municipio
where t2.nr_fatura > 0 and month(t2.dt_conhecimento) = '$date'
group by t3.nm_municipio
order by count(t2.id_codmunf) desc";
$res_dst = mysqli_query($link, $sql_dst);
while ($locais = mysqli_fetch_assoc($res_dst)) {

	$array_local[] = array(
		'data_veic' 	=> $locais['mes_veic']."-".$locais['ano_veic'],
		'qtd_dst_mes' 	=> $locais['qtd_dst_mes'],
		'ds_dst' 		=> $locais['nm_municipio']."-".$locais['nm_uf'],
	);
	
}

$link->close();
?>
