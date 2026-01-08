<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido      = $_POST['nr_pedido'];
$barcode        = $_POST['barcode_exp_3c'];
$nr_qtde_conf   = $_POST['nr_qtde_conf'];

$query_init = "select COALESCE(sum(nr_qtde),0) as nr_qtde_conf
from tb_pedido_coleta_produto
where nr_pedido = '$nr_pedido' and produto = '$barcode'";
$res_init = mysqli_query($link, $query_init);
while ($init = mysqli_fetch_assoc($res_init)) {
    $conf = $init['nr_qtde_conf'];
}

if($conf == $nr_qtde_conf){

    $array_estoque = array(

        'info' => "0",

    );

    echo (json_encode($array_estoque));
}else{

    $array_estoque = array(

        'info' => "1",
    );

    echo (json_encode($array_estoque));

}

$link->close();
?>