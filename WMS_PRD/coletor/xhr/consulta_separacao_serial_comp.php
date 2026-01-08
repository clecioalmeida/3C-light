<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$pedido = $_POST['pedido'];

$sql_ns = "select count(n_serie) as total_nserie
from tb_nserie
where cod_pedido = '$pedido' and fl_tipo = 'C'";
$res_ns = mysqli_query($link, $sql_ns);
$ns = mysqli_fetch_assoc($res_ns);
$qtde_ns = $ns['total_nserie'];

$sql_cf = "select sum(nr_qtde) as total_conf
from tb_pedido_conferencia
where nr_pedido = '$pedido' and nr_qtde > 0";
$res_cf = mysqli_query($link, $sql_cf);
$cf = mysqli_fetch_assoc($res_cf);
$qtde_cf = $cf['total_conf'];

if($qtde_ns == $qtde_cf){

    $retorno = array(
        'info' => 1,
    );

    echo(json_encode($retorno));

}else{

    $retorno = array(
        'info' => "Existem números de série fora do pedido, favor clicar em finalizar na tela de conferência.",
    );

    echo(json_encode($retorno));

}

$link->close();
?>