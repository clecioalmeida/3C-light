<?php  
$date = date('m');

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select date_format(t2.dt_conhecimento,'%d-%m-%Y') as data_man, count(DISTINCT t2.id_veiculo) as total_veic
from tb_conhecimento t2
where t2.nr_fatura > 0 and month(t2.dt_conhecimento) = '$date'
group by day(t2.dt_conhecimento)";
$res = mysqli_query($link, $sql);
while ($tipo = mysqli_fetch_assoc($res)) {

	$array_tipo[] = array(
		'data_man' 			=> $tipo['data_man'],
		'total_veic' 		=> $tipo['total_veic'],
	);

}

$sql_hr = "select month(t1.dt_create) as mes_veic, year(t1.dt_create) as ano_veic, count(DISTINCT t1.id_man) as total_mes
from tb_manifesto t1
left join tb_conhecimento t2 on t1.id_man = t2.nr_manifesto
where t2.nr_fatura > 0
group by month(dt_create)";
$res_hr = mysqli_query($link, $sql_hr);
while ($horas = mysqli_fetch_assoc($res_hr)) {

	$array_horas[] = array(
		'data_veic' 	=> $horas['mes_veic']."-".$horas['ano_veic'],
		'total_mes' 	=> $horas['total_mes'],
	);
	
}

$link->close();
?>
