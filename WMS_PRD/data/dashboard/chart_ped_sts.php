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
case MONTH(dt_create)
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
end as mes, fl_status, COUNT(nr_pedido) as total_status, (select count(nr_pedido) from tb_pedido_coleta where date(dt_create) >= '2020-01-01' and fl_status <> 'E') as total_ped
from tb_pedido_coleta where fl_status <> 'E' and fl_status <> 'F' and date(dt_create) >= '2020-01-01' and fl_empresa = '$cod_cli'";
$res = mysqli_query($link, $sql);

while ($parte = mysqli_fetch_assoc($res)) {
	$array_parte[] = array(
		'info'				=> '0',
		'mes' 				=> $parte['mes'],
		'ped_pend' 			=> number_format(($parte['total_status']/$parte['total_ped'])*100, 2, '.', ''),
		//'fl_status' 		=> $parte['fl_status'],
		//'total_status' 		=> $parte['total_status'],
	);
}
echo (json_encode($array_parte));
$link->close();
?>
