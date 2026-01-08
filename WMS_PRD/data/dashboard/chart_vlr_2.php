<?php
session_start();
?>
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

$sql="select
case MONTH(t3.dt_rec)
when 1 then 'Janeiro'
when 2 then 'Fevereiro'
when 3 then 'Março'
when 4 then 'Abril'
when 5 then 'Maio'
when 6 then 'Junho'
when 7 then 'Julho'
when 8 then 'Agosto'
when 9 then 'Setembro'
when 10 then 'Outubro'
when 11 then 'Novembro'
when 12 then 'Dezembro'
end as mes, sum(t3.vl_unit) as vlr_total
from tb_posicao_pallet t1
left join tb_nf_entrada t2 on t1.nr_or = t2.cod_rec
left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
where t1.fl_empresa = '$cod_cli' and t1.nr_or is not null and t1.fl_status <> 'E' and MONTH(t3.dt_rec)=(MONTH(NOW())) and t1.nr_qtde > 0
order by sum(t3.vl_unit) desc";
$res = mysqli_query($link, $sql);

while ($parte = mysqli_fetch_assoc($res)) {
	$array_parte[] = array(
		'info'				=> '0',
		'mes' 				=> $parte['mes'],
		'vlr_total' 		=> $parte['vlr_total'],
	);
}
echo (json_encode($array_parte));
$link->close();
?>
