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

$sql="select count(cod_estoque)
from tb_posicao_pallet
where fl_empresa = '$cod_cli' and fl_status <> 'E'
group by ds_prateleira, ds_coluna, ds_altura";
$res = mysqli_query($link, $sql);

$total_pp = mysqli_num_rows($res);

$sql_end="select t2.id as total_pp
from tb_armazem t1 
left join tb_endereco t2 on t1.id = t2.galpao
where t1.id_oper = '$cod_cli'";
$res_end = mysqli_query($link, $sql_end);
//$dados = mysqli_fetch_assoc($res_end);
//$total_end = $dados['total_pp'];
$total_end = mysqli_num_rows($res_end);

$total = ($total_pp/$total_end)*100;

$array_parte[] = array(
	'info'				=> '0',
		'mes' 			=> "Dezembro",
	'total' 		=> round($total, 2),
	'total_pp' 		=> $total_pp,
	'total_end' 		=> $total_end,
);
echo (json_encode($array_parte));
$link->close();
?>
