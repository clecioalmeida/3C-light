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

$cod_est = $_POST["cod_est"];

$sql_alc = "select nr_alocado from tb_aloca where cod_estoque = '$cod_est'";
$res_alc = mysqli_query($link,$sql_alc);

if(mysqli_num_rows($res_alc) > 0){

    echo "Alocação não pode ser excluída.";

}else{

    $upd_ped = "update tb_posicao_pallet set fl_status = 'E' where cod_estoque = '$cod_est'";
    $res_ped = mysqli_query($link,$upd_ped);

    $ins_min = "insert into tb_hist_act (ds_codigo, nr_codigo, ds_act, usr_act, dt_act) values ('cod_estoque', '$cod_est', 'Esclusão de alocação pendente', '$id', '$date')";
    $res_ins = mysqli_query($link, $ins_min);

    echo "Alocação excluída.";

}

$link->close();
?>