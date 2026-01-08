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

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto = mysqli_real_escape_string($link,$_POST['prd']);
$rua = mysqli_real_escape_string($link,$_POST['rua']);
$col = mysqli_real_escape_string($link,$_POST['col']);
$alt = mysqli_real_escape_string($link,$_POST['alt']);
$qtd = mysqli_real_escape_string($link,$_POST['qtd']);
$galpao = mysqli_real_escape_string($link,$_POST['galpao']);
$cod_estoque = mysqli_real_escape_string($link,$_POST['cod_estoque']);
$barcode = mysqli_real_escape_string($link,$_POST['barcode']);

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_init="select count(produto) as total
    from tb_pedido_conferencia
    where nr_pedido = '$cod_estoque' and produto = '$cod_produto' and ds_galpao = '$galpao' and ds_prateleira = '$rua' and ds_coluna = '$col' and ds_altura = '$alt'";
$res_init=mysqli_query($link, $query_init);
while ($init=mysqli_fetch_assoc($res_init)) {
    $count=$init['total'];
}

if($count < $qtd){

    $insert_barcode = " insert into tb_pedido_conferencia (nr_pedido, produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, usr_create, dt_create) values ('$cod_estoque', '$barcode', '$galpao', '$rua', '$col', '$alt', '$id', now())";
    $res_barcode = mysqli_query($link,$insert_barcode);

    $query_count="select count(produto) as total
        from tb_pedido_conferencia
        where nr_pedido = '$cod_estoque'";
    $res_count=mysqli_query($link, $query_count);
    while ($count=mysqli_fetch_assoc($res_count)) {
        $count_upd=$count['total'];
    }

    //$upd_conf="update tb_posicao_pallet set nr_or = 1 where cod_estoque = '$cod_estoque'";
    //$res_upd=mysqli_query($link, $upd_conf);

    if($res_barcode){

        $query_conf="select count(produto) as total
            from tb_pedido_conferencia
            where nr_pedido = '$cod_estoque'";
        $res_conf=mysqli_query($link, $query_conf);
        $tr_conf = mysqli_num_rows($res_conf);
                
        while ($conf=mysqli_fetch_assoc($res_conf)) {
            $array_estoque[] = array(
                'info' => $conf['total'],
            );
        }

        echo(json_encode($array_estoque));
    }

}else{

    $array_estoque[] = array(
        
        'info' => "Todos os itens desse produto foram alocados!",
    );

    echo(json_encode($array_estoque));

    exit();

}

?>