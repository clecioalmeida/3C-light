<?php 
  require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $cod_prod_cliente = mysqli_real_escape_string($link, $_REQUEST["cod_prod_cliente"]);
    //$nm_produto = mysqli_real_escape_string($link, $_POST["nm_produto"]);
    //$nr_pedido = mysqli_real_escape_string($link, $_POST["nr_pedido"]);

    $big_select="set sql_big_selects=1";
    $res_select = mysqli_query($link,$big_select);

    $prod="select distinct t3.cod_produto, sum(t1.nr_qtde) as saldo
    from tb_posicao_pallet t1
    left join tb_produto t3 on t1.produto = t3.cod_produto
    where t3.cod_prod_cliente = '$cod_prod_cliente' and (t1.ds_projeto is null or t1.ds_projeto = '')";
    $res_prod = mysqli_query($link,$prod); 
    while ($dados_prod=mysqli_fetch_assoc($res_prod)) {
        $produto=$dados_prod['cod_produto'];
        $saldo=$dados_prod['saldo'];
    }

    $sel_prod="select distinct t1.produto, (select sum(nr_qtde) from tb_pedido_coleta_produto where produto = '$produto' and fl_status <> 'E' and fl_status <> 'F'and fl_status <> 'X'and fl_status <> 'L') as reservado, t3.cod_produto, t3.nm_produto, t3.cod_prod_cliente
        from tb_posicao_pallet t1
        left join tb_pedido_coleta_produto t2 on t1.produto = t2.produto
        left join tb_produto t3 on t1.produto = t3.cod_produto
        where t3.cod_prod_cliente = '$cod_prod_cliente' and (t1.ds_projeto is null or t1.ds_projeto = '')
        group by t1.produto";
    $res = mysqli_query($link,$sel_prod);

    while ($produto=mysqli_fetch_assoc($res)) {
        $array_produto[] = array(
            'cod_prod_cliente'  => $produto['cod_prod_cliente'],
            'cod_produto' => $produto['cod_produto'],
            'nm_produto' => $produto['nm_produto'],
            'reservado' => $produto['reservado'],
            'saldo' => $saldo,
        );
    }

    echo(json_encode($array_produto));

$link->close();
?>