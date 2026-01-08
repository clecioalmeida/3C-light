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

if($fl_status == 'F'){

    $retorno = array(
        'info' => "Pedido já finalizado anteriormente!",
    );

    echo(json_encode($retorno));

}else{

    $query_init="select sum(nr_qtde_conf) as total_qtde, coalesce(sum(nr_qtde_exp),0) as total_exp
    from tb_pedido_coleta_produto
    where nr_pedido = '$pedido' and nr_qtde > 0";
    $res_init=mysqli_query($link, $query_init);

    while ($init=mysqli_fetch_assoc($res_init)) {
        $total=$init['total_exp'];
        $qtde=$init['total_qtde'];
    }

    if($total == $qtde){

       $query_cod = "select t1.cod_conferencia,  COALESCE(MIN(t2.cod_estoque),0) as cod_estoque, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.produto, t1.nr_qtde, t2.ds_galpao, coalesce(t2.nr_qtde,0) as nr_qtde_pp, coalesce(t2.produto,0) as produto_pp
       from tb_pedido_conferencia t1
       left join tb_posicao_pallet t2 on t1.ds_prateleira = t2.ds_prateleira and t1.ds_coluna = t2.ds_coluna and t1.ds_altura = t2.ds_altura and t1.produto = t2.produto
       where t1.nr_pedido = '$pedido' and t1.nr_qtde > 0 and t1.nr_qtde <= t2.nr_qtde and t2.fl_status <> 'E'
       group by t1.cod_conferencia";
       $res_col = mysqli_query($link, $query_cod);
       while ($parte = mysqli_fetch_assoc($res_col)) {
            $ds_prateleira      = $parte['ds_prateleira'];
            $ds_coluna          = $parte['ds_coluna'];
            $ds_altura          = $parte['ds_altura'];
            $produto            = $parte['produto'];
            $nr_qtde            = $parte['nr_qtde'];
            $ds_galpao          = $parte['ds_galpao'];
            $nr_qtde_pp         = $parte['nr_qtde_pp'];
            $cod_estoque        = $parte['cod_estoque'];
            $produto_pp         = $parte['produto_pp'];
            $cod_conferencia    = $parte['cod_conferencia'];
            $nova_qtde          = $nr_qtde_pp-$nr_qtde;

            if($cod_estoque == "0"){

                $ds_obs = "Produto não existe na alocação. Atualizar o saldo.";

                $sql_prd = "update tb_pedido_conferencia set ds_obs = '$ds_obs' where cod_conferencia = '$cod_conferencia'";
                $prd = mysqli_query($link1, $sql_prd);

            }else if($nr_qtde > $nr_qtde_pp){

                $ds_obs = "Saldo insuficiente para baixar a quantidade solicitada. Atualizar o saldo.";

                $sql_prd = "update tb_pedido_conferencia set ds_obs = '$ds_obs' where cod_conferencia = '$cod_conferencia'";
                $prd = mysqli_query($link1, $sql_prd);

            }else{

                $sql_saldo = "update tb_posicao_pallet set nr_qtde = '$nova_qtde', nr_qtde_ant = '$nr_qtde_pp', nr_pedido_ant = '$pedido', user_update = '$id', dt_update = '$date' where cod_estoque = '$cod_estoque'";
                $saldo = mysqli_query($link, $sql_saldo);

                $sql_col = "update tb_coleta_pedido set fl_status = 'F' where cod_estoque = '$cod_estoque' and nr_pedido = '$pedido'";
                $col = mysqli_query($link, $sql_col);

                $sql_prd = "update tb_pedido_coleta_produto set usr_lib_exp = '$id', dt_lib_exp = '$date', fl_status = 'F' where nr_pedido = '$pedido' and produto = '$produto'";
                $prd = mysqli_query($link1, $sql_prd);

            }   

        }

        $sql_conf = "select fl_status from tb_pedido_coleta_produto where nr_pedido = '$pedido' and fl_status <> 'F'";
        $res_conf = mysqli_query($link, $sql_conf);

        if(mysqli_affected_rows($link2) > 0){

            $retorno = array(
                'info' => "<h3 style='background-color: #A52A2A;color:white;text-align:center'><span>Pedido não pode ser finalizado.</span></h3>",
            );

            echo(json_encode($retorno));


        }else{

            $sql_ped = "update tb_pedido_coleta set fl_status = 'F' where nr_pedido = '$pedido'";
            $ped = mysqli_query($link1, $sql_ped);

            $retorno = array(
                'info' => "<h3 style='background-color: #98FB98;text-align:center'><span>Pedido finalizado com sucesso!</span></h3>",
            );

            echo(json_encode($retorno));

        }

    }else{

        $retorno = array(
         'info' => "<h3 style='background-color: #A52A2A;color:white;text-align:center'><span>Ainda existem produtos a conferir.</span></h3>",
     );

        echo(json_encode($retorno));

    }
}
$link->close();
$link1->close();
$link2->close();
?>