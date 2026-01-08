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

$nr_pedido = $_POST["nr_ped"];

$count_ab = "select coalesce(sum(nr_qtde),0) as tot_pedido from tb_pedido_coleta_produto where nr_pedido = '$nr_pedido' and fl_status <> 'E'" or die(mysqli_error($count_ab));
$res_ab = mysqli_query($link, $count_ab);
$dados_ab=mysqli_fetch_assoc($res_ab);
$tot_pedido=$dados_ab['tot_pedido'];

$count_c = "select coalesce(sum(nr_qtde),0) as tot_col from tb_pedido_conferencia where nr_pedido = '$nr_pedido' and coalesce(fl_status,'A') <> 'E'" or die(mysqli_error($count_c));
$res_c = mysqli_query($link, $count_c);
$dados_c=mysqli_fetch_assoc($res_c);
$tot_col=$dados_c['tot_col'];

$count_m = "select (coalesce(sum(t1.nr_qtde),0)-coalesce(sum(t2.nr_qtde),0)) as tot_pend from tb_pedido_coleta_produto t1 left join tb_pedido_conferencia t2 on t1.nr_pedido = t2.nr_pedido where t1.nr_pedido = '$nr_pedido' and t1.fl_status <> 'E'" or die(mysqli_error($count_m));
$res_m = mysqli_query($link, $count_m);
$dados_m = mysqli_fetch_assoc($res_m);
$tot_pend = $tot_pedido - $tot_col;//$dados_m['tot_pend'];

$count_x = "select coalesce(sum(nr_qtde_exp),0) as tot_conf from tb_pedido_coleta_produto where nr_pedido = '$nr_pedido' and fl_empresa = '$cod_cli' and fl_status <> 'E'" or die(mysqli_error($count_x));
$res_x = mysqli_query($link, $count_x);
$dados_x = mysqli_fetch_assoc($res_x);
$tot_conf = $dados_x['tot_conf'];


$array_pedido[] = array(
	'tot_pedido' 	=> $tot_pedido,
	'tot_col' 		=> $tot_col,
	'tot_pend' 		=> $tot_pend,
	'tot_conf' 		=> $tot_conf,
);

echo (json_encode($array_pedido));

$link->close();
?>