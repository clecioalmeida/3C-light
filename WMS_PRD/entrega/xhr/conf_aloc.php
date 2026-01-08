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
$qtde = mysqli_real_escape_string($link,$_POST['qtde']);

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$query_init="select count(cod_conferencia) as total
    from tb_pedido_conferencia
    where nr_pedido = '$cod_estoque'";
    $res_init=mysqli_query($link, $query_init);
    while ($init=mysqli_fetch_assoc($res_init)) {
        $count=$init['total'];
    }

    if($count < $qtde){

         $retorno[] = array(
            'info' => "Ainda existem itens a conferir!",
        );

        echo(json_encode($retorno));

        exit();

    }else{
        
        $upd_conf="update tb_posicao_pallet set nr_or = 1 where cod_estoque = '$cod_estoque'";
        $res_upd=mysqli_query($link, $upd_conf);

        if($res_upd){
            $retorno[] = array(
            'info' => "Alocação finalizada com sucesso!",
        );

        echo(json_encode($retorno));

        exit();
        }


    }
?>