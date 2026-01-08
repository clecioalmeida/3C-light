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

$ds_placa = mysqli_real_escape_string($link, $_POST["ds_placa"]);
$ds_veiculo = mysqli_real_escape_string($link, $_POST["ds_veiculo"]);
$ds_empresa = mysqli_real_escape_string($link, $_POST["ds_empresa"]);
$ds_nome = mysqli_real_escape_string($link, $_POST["ds_nome"]);
$ds_dpto = mysqli_real_escape_string($link, $_POST["ds_dpto"]);
$ds_contato = mysqli_real_escape_string($link, $_POST["ds_contato"]);
$ds_motivo = mysqli_real_escape_string($link, $_POST["ds_motivo"]);
$dt_saida = mysqli_real_escape_string($link, $_POST["dt_saida"]);
$hr_saida = mysqli_real_escape_string($link, $_POST["hr_saida"]);
$ds_galpao = mysqli_real_escape_string($link, $_POST["ds_galpao"]);
$ds_doca = mysqli_real_escape_string($link, $_POST["ds_doca"]);
$ds_obs = mysqli_real_escape_string($link, $_POST["ds_obs"]);

$cons_placa="select ds_placa from tb_portaria where ds_placa = '$ds_placa' and (fl_status = 'A' or fl_status = 'L')";
$res_placa = mysqli_query($link,$cons_placa);
$tr_placa = mysqli_num_rows($res_placa);

if($tr_placa > 0){

    $retorno[] = array(
        'info' => "2",
    );

    echo (json_encode($retorno));

}else{

    $ins_pedido="insert into tb_portaria (dt_chegada, ds_placa, ds_veiculo, ds_empresa, ds_nome, ds_dpto, ds_contato, ds_motivo, dt_saida, fl_status, ds_galpao, ds_doca, ds_obs, usr_create, dt_create) values ('$date', '$ds_placa', '$ds_veiculo', '$ds_empresa', '$ds_nome', '$ds_dpto', '$ds_contato', '$ds_motivo', '$dt_saida', 'A', '$ds_galpao', '$ds_doca', '$ds_obs', '$id', '$date')";
    $res_ins_pedido = mysqli_query($link,$ins_pedido);

    if ($res_ins_pedido) {

        $retorno[] = array(
            'info' => "0",
        );

        echo (json_encode($retorno));

    } else {

        $retorno[] = array(
            'info' => "1",
            'data' => $date,
        );

        echo (json_encode($retorno));

    }

}

$link->close();
?>