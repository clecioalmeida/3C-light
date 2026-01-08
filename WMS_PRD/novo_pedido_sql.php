<?php
require_once('data/movimento/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = mysqli_real_escape_string($link, $_POST["nr_pedido"]);

if($nr_pedido != ''){

    $sel_prod="select t1.cod_prod_cliente, t1.cod_produto, t1.nm_produto, sum(t2.nr_qtde) as saldo
            from tb_produto t1
            left join tb_pedido_coleta_produto t2 on t1.cod_produto = t2.produto
            where t2.nr_pedido = '$nr_pedido'
            group by t1.cod_produto";
    $res = mysqli_query($link,$sel_prod); 

    include "data/movimento/tb_pedido_sql.php";

} else { 

    include "data/movimento/tb_pedido_sql_vazio.php";

}
$link->close();
?>


