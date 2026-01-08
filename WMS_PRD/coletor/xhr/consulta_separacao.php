<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$pedido = $_POST['pedido'];

$query_init="select sum(nr_qtde) as total_qtde
from tb_pedido_coleta_produto
where nr_pedido = '$pedido' and nr_qtde > 0";
$res_init=mysqli_query($link, $query_init);
while ($init=mysqli_fetch_assoc($res_init)) {
    $qtde=$init['total_qtde'];
}

$query_init2="select produto, sum(nr_qtde) as total_conf
from tb_pedido_conferencia
where nr_pedido = '$pedido' and nr_qtde > 0 and COALESCE(fl_status,'A') <> 'E'";
$res_init2=mysqli_query($link, $query_init2);
while ($init2=mysqli_fetch_assoc($res_init2)) {
    $total=$init2['total_conf'];
}

if($total == $qtde){

    $retorno[] = array(
        'info' => 1,
    );

    echo(json_encode($retorno));

}else if($total < $qtde){

    $retorno[] = array(
        'info' => 2,
    );

    echo(json_encode($retorno));

}else{

    $retorno[] = array(
        'info' => "Quantidade coletada é maior que a quantidade solicitada. Não é possível finalizar o pedido.",
    );

    echo(json_encode($retorno));

}

$link->close();
?>