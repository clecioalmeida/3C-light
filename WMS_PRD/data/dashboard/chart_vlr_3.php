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

$sql="select t3.produto, AVG(t3.vl_unit) as vlr_medio
from tb_posicao_pallet t1
left join tb_nf_entrada t2 on t1.nr_or = t2.cod_rec
left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
where t1.fl_empresa = '$cod_cli' and t1.nr_or is not null and t1.fl_status <> 'E' and MONTH(t3.dt_rec)=(MONTH(NOW()))
group by t3.produto
order by AVG(t3.vl_unit) desc
limit 50";
$res = mysqli_query($link, $sql);

while ($parte = mysqli_fetch_assoc($res)) {
	$array_parte[] = array(
		'info'			=> '0',
		'produto' 		=> $parte['produto'],
		'vlr_medio' 	=> $parte['vlr_medio'],
	);
}
echo (json_encode($array_parte));
$link->close();
?>
