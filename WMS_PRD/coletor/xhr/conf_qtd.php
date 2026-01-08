<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$pedido = mysqli_real_escape_string($link,$_POST['pedido']);

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_init="select nr_qtde_conf, produto
from tb_coleta_pedido
where nr_pedido = '$pedido'
group by produto";
$res_init=mysqli_query($link, $query_init);
while ($init=mysqli_fetch_assoc($res_init)) {
    $retorno[] = array(
        'produto' => $init['produto'],
        'total' => $init['nr_qtde_conf'],
    );

    echo(json_encode($retorno));
}

$link->close();
?>