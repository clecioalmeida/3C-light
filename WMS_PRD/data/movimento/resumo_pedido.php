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
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$count_ab = "select count(nr_pedido) as tot_aberto from tb_pedido_coleta where fl_status = 'A' and fl_empresa = '$cod_cli' and fl_status <> 'E'" or die(mysqli_error($count_ab));
$res_ab = mysqli_query($link, $count_ab);
$dados_ab=mysqli_fetch_assoc($res_ab);
$total_ab=$dados_ab['tot_aberto'];

$count_c = "select count(nr_pedido) as tot_lib from tb_pedido_coleta where fl_status = 'C' and fl_empresa = '$cod_cli' and fl_status <> 'E'" or die(mysqli_error($count_c));
$res_c = mysqli_query($link, $count_c);
$dados_c=mysqli_fetch_assoc($res_c);
$total_c=$dados_c['tot_lib'];

$count_m = "select count(nr_pedido) as tot_ini from tb_pedido_coleta where fl_status = 'M' or fl_status = 'D' and fl_empresa = '$cod_cli' and fl_status <> 'E'" or die(mysqli_error($count_m));
$res_m = mysqli_query($link, $count_m);
$dados_m = mysqli_fetch_assoc($res_m);
$total_m = $dados_m['tot_ini'];

$count_x = "select count(nr_pedido) as tot_exp from tb_pedido_coleta where fl_status = 'X' and fl_empresa = '$cod_cli' and fl_status <> 'E'" or die(mysqli_error($count_x));
$res_x = mysqli_query($link, $count_x);
$dados_x = mysqli_fetch_assoc($res_x);
$total_x = $dados_x['tot_exp'];

$count_f = "select COALESCE(count(nr_pedido),0) as tot_ent from tb_pedido_coleta where nr_minuta is null and fl_empresa = '$cod_cli' and fl_status <> 'E'" or die(mysqli_error($count_f));
$res_f = mysqli_query($link, $count_f);
$dados_f = mysqli_fetch_assoc($res_f);
$total_f = $dados_f['tot_ent'];


$array_pedido[] = array(
	'tot_aberto' 	=> $total_ab,
	'tot_lib' 		=> $total_c,
	'tot_ini' 		=> $total_m,
	'tot_exp' 		=> $total_x,
	'tot_ent' 		=> $total_f,
);

echo (json_encode($array_pedido));

$link->close();
?>