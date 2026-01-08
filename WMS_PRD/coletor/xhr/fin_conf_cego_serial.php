<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:index.php");
    exit;

}else{

    $id=$_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$pedido = $_POST['pedido'];

$select_dest = "SELECT produto, sum(nr_qtde) as qtde_conf FROM tb_pedido_conferencia WHERE nr_pedido = '$pedido' group by produto";
$res_dest = mysqli_query($link,$select_dest);

while ($dest=mysqli_fetch_assoc($res_dest)) {
    $qtde_conf = $dest['qtde_conf'];
    $produto = $dest['produto'];

    $sql_prd = "update tb_pedido_coleta_produto set fl_status = 'X', nr_qtde_conf = '$qtde_conf', fl_conferido = 'C', usr_fim_coleta = '$id', dt_fim_coleta = '$date' where produto = '$produto' and nr_pedido = '$pedido'";
    $res_prd = mysqli_query($link, $sql_prd);

}

$upd_col="update tb_coleta_pedido set fl_status = 'X', usr_col = '$id', dt_col = '$date' where nr_pedido = '$pedido'";
$res_upd_col=mysqli_query($link, $upd_col);

$upd_ped="update tb_pedido_coleta set fl_status = 'X' where nr_pedido = '$pedido'";
$res_upd_ped=mysqli_query($link1, $upd_ped);

if(mysqli_affected_rows($link1) > 0){

	$retorno = array(
		'info' => 1,
	);

	echo(json_encode($retorno));

}else{

	$retorno = array(
		'info' => 2,
	);

	echo(json_encode($retorno));

}

$link->close();
$link1->close();
?>