<?php 
    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $conGalpao = $_REQUEST['conGalpao'];
    $conRua = $_REQUEST['conRua'];
    $conColuna = $_REQUEST['conColuna'];
    $conAltura = $_REQUEST['conAltura'];

    $query="SET SQL_BIG_SELECTS=1";
    $res_query=mysqli_query($link, $query);

    $query_estoque="select t1.cod_estoque, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.produto, t1.nr_qtde, t2.nm_produto
    from tb_posicao_pallet t1
    left join tb_produto t2 on t1.produto = t2.cod_produto or t1.produto = t2.id_torre
    where ds_galpao = '$conGalpao' and ds_prateleira = '$conRua' and ds_coluna = '$conColuna' and ds_altura = '$conAltura'";
    $res_estoque=mysqli_query($link, $query_estoque);
    $tr_estoque = mysqli_num_rows($res_estoque);
    
    while ($estoque=mysqli_fetch_assoc($res_estoque)) {
        $array_estoque[] = array(
            'cod_estoque'    => $estoque['cod_estoque'],
            'ds_galpao'    => $estoque['ds_galpao'],
            'ds_prateleira' => $estoque['ds_prateleira'],
            'ds_coluna' => $estoque['ds_coluna'],
            'ds_altura' => $estoque['ds_altura'],
            'produto' => $estoque['produto'],
            'nr_qtde' => $estoque['nr_qtde'],
            'nm_produto' => $estoque['nm_produto'],
        );
    }

    echo(json_encode($array_estoque));
$link->close();
?>