<?php
$date = date('m');

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$query_transp = "SELECT date_format(t1.dt_conhecimento, '%d/%m/%Y') as data_vg, round(SUM(t1.nr_peso_kg)/1000,2) as nr_peso
from tb_conhecimento t1
where month(t1.dt_conhecimento) = '$date' and t1.nr_fatura > 0
group by day(t1.dt_conhecimento)";
$res_transp = mysqli_query($link, $query_transp);

$query_mes = "SELECT month(t1.dt_conhecimento) as mes_vg, year(t1.dt_conhecimento) as ano_vg, round(SUM(t1.nr_peso_kg)/1000,2) as nr_peso
from tb_conhecimento t1
where month(t1.dt_conhecimento) = '$date' and t1.nr_fatura > 0
group by month(t1.dt_conhecimento)";
$res_mes = mysqli_query($link, $query_mes);

$query_dst = "SELECT month(t1.dt_conhecimento) as mes_vg, year(t1.dt_conhecimento) as ano_vg, round(sum(t1.nr_peso_kg)/1000,2) as nr_peso, upper(t2.nm_municipio) as nm_municipio, t2.nm_uf
from tb_conhecimento t1
left join tb_municipio t2 on t1.id_codmunf = t2.cod_municipio
where month(t1.dt_conhecimento) = '$date' and t1.nr_fatura > 0
group by t2.nm_municipio, month(t1.dt_conhecimento)
order by round(sum(t1.nr_peso_kg)/1000,2) desc";
$res_dest = mysqli_query($link, $query_dst);


$link->close();
?>
