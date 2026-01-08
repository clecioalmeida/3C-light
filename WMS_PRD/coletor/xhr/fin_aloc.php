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

$cod_estoque = mysqli_real_escape_string($link,$_POST['cod_estoque']);
$qtd = mysqli_real_escape_string($link,$_POST['qtd']);

$query_init="select count(produto) as total
    from tb_pedido_conferencia
    where nr_pedido = '$cod_estoque'";
$res_init=mysqli_query($link, $query_init);

while ($init=mysqli_fetch_assoc($res_init)) {
    $total=$init['total_conf'];
}

if($total == $qtd){
    $upd_col="update tb_posicao_pallet set nr_or = 1 where cod_estoque = '$cod_estoque'";
    $res_upd_col=mysqli_query($link, $upd_col);

    $retorno[] = array(
        'info' => 1,
    );

    echo(json_encode($retorno));

}else{

    $retorno[] = array(
        'info' => "Ainda existem produtos a coletar.",
    );

    echo(json_encode($retorno));

}
$link->close();
?>