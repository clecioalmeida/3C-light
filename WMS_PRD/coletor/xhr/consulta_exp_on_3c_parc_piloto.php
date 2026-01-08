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
$link2 = $objDb->conecta_mysql();

$pedido = $_POST['pedido'];

$sql_st="select fl_status
from tb_pedido_coleta
where nr_pedido = '$pedido'";
$res_st=mysqli_query($link, $sql_st);
$status=mysqli_fetch_assoc($res_st);
$fl_status=$status['fl_status'];

if($fl_status == 'F' ){

    $retorno = array(
        'info' => "1",
    );

    echo(json_encode($retorno));

}else if($fl_status == 'X' || $fl_status == 'W'){

    $query_init="select sum(nr_qtde) as total_qtde, coalesce(sum(nr_qtde_exp),0) as total_exp
    from tb_pedido_coleta_produto
    where nr_pedido = '$pedido' and nr_qtde > 0";
    $res_init=mysqli_query($link, $query_init);

    while ($init=mysqli_fetch_assoc($res_init)) {
        $total=$init['total_exp'];
        $qtde=$init['total_qtde'];
    }

    if($total == $qtde){ 

        $retorno = array(
            'info' => "0",
        );

        echo(json_encode($retorno));

    }else if($total < $qtde){

        $retorno = array(
            'info' => "3",
        );

        echo(json_encode($retorno));

    }else{

        $retorno = array(
            'info' => "4",
        );

        echo(json_encode($retorno));

    }
}
$link->close();
$link1->close();
$link2->close();
?>