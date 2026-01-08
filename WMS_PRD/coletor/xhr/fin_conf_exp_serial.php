<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:index.php");
    exit;

}else{

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
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

if($fl_status == 'F' ){

    $retorno = array(
        'info' => "<h3 style='background-color: #98FB98;color:white'><span>Pedido já finalizado anteriormente!</span></h3>",
    );

    echo(json_encode($retorno));

}else if($fl_status <> 'X' && $fl_status <> 'W'){

    $retorno = array(
        'info' => "<h3 style='background-color: #A52A2A;color:white'><span>Ainda existem produtos em separação!</span></h3>",
    );

    echo(json_encode($retorno));

}else{

    $query_init="select sum(t1.nr_qtde_conf) as total_qtde, sum(t2.nr_qtde) as qtde_conf
    from tb_pedido_coleta_produto t1
    left join tb_pedido_conferencia t2 on t1.nr_pedido = t2.nr_pedido
    where t1.nr_pedido = '$pedido' and t1.nr_qtde > 0";
    $res_init=mysqli_query($link, $query_init);

    while ($init=mysqli_fetch_assoc($res_init)) {
        $qtde_conf   = $init['qtde_conf'];
        $total  = $init['total_qtde'];
    }

    $sql_ns = "select count(n_serie) as total_ns
    from tb_nserie where cod_pedido = '$pedido' and fl_status = 'G'";
    $res_ns = mysqli_query($link, $sql_ns);
    $total_ns = mysqli_fetch_assoc($res_ns);
    $qtd_ns = $total_ns['total_ns'];

    if($qtde_conf == $qtd_ns){

        $query_cod = "select t1.cod_conferencia,  COALESCE(MIN(t2.cod_estoque),0) as cod_estoque, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.produto, t1.nr_qtde, t2.ds_galpao, coalesce(t2.nr_qtde,0) as nr_qtde_pp, coalesce(t2.produto,0) as produto_pp
        from tb_pedido_conferencia t1
        left join tb_posicao_pallet t2 on t1.ds_prateleira = t2.ds_prateleira and t1.ds_coluna = t2.ds_coluna and t1.ds_altura = t2.ds_altura and t1.produto = t2.produto
        where t1.nr_pedido = '$pedido' and t1.nr_qtde > 0 and t1.nr_qtde <= t2.nr_qtde and t2.fl_status <> 'E'
        group by t1.cod_conferencia";
        $res_col = mysqli_query($link, $query_cod);

        if(mysqli_num_rows($res_col) > 0){

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

                if($nr_qtde > $nr_qtde_pp){

                    $ds_obs = "Saldo insuficiente para baixar a quantidade solicitada. Atualizar o saldo.";

                    $sql_prd = "update tb_pedido_conferencia set ds_obs = '$ds_obs' where cod_conferencia = '$cod_conferencia'";
                    $prd = mysqli_query($link1, $sql_prd);

                }else{

                    $sql_saldo = "update tb_posicao_pallet set nr_qtde = '$nova_qtde', nr_qtde_ant = '$nr_qtde_pp', nr_pedido_ant = '$pedido', user_update = '$id', dt_update = '$date' where cod_estoque = '$cod_estoque'";
                    $saldo = mysqli_query($link, $sql_saldo);

                    $sql_col = "update tb_coleta_pedido set fl_status = 'F' where cod_estoque = '$cod_estoque' and nr_pedido = '$pedido'";
                    $col = mysqli_query($link, $sql_col);

                    $sql_prd = "update tb_pedido_coleta_produto set usr_lib_exp = '$id', dt_lib_exp = '$date', fl_status = 'F', fl_conferido = 'S' where nr_pedido = '$pedido' and produto = '$produto'";
                    $prd = mysqli_query($link1, $sql_prd);

                    $sql_ns = "update tb_nserie set  fl_status = 'F' where cod_pedido = '$pedido'";
                    $ns = mysqli_query($link1, $sql_ns);

                }
            }

            $sql_ped = "update tb_pedido_coleta set fl_status = 'F' where nr_pedido = '$pedido'";
            $ped = mysqli_query($link2, $sql_ped);

            if(mysqli_affected_rows($link2) > 0){

                $retorno = array(
                    'info' => "<h3 style='background-color: #98FB98;text-align:center'><span>Pedido finalizado com sucesso!</span></h3>",
                );

                echo(json_encode($retorno));


            }else{


                $retorno = array(
                 'info' => "<h3 style='background-color: #A52A2A;color:white;text-align:center'><span>Status não pode ser alterado.</span></h3>",
             );

                echo(json_encode($retorno));

            }

            $sql_exp = "select sum(t1.nr_qtde_conf) as total_qtde, produto
            from tb_pedido_coleta_produto t1
            where t1.nr_pedido = '$pedido' and t1.nr_qtde > 0
            group by t1.produto";
            $res_exp = mysqli_query($link, $sql_exp);
            $expede = mysqli_fetch_assoc($res_exp);
            $cod_produto    = $expede['produto'];
            $total_exp      = $expede['total_qtde'];

            if(mysqli_num_rows($res_exp) > 0){

                $sql_qt = "update tb_pedido_coleta_produto set nr_qtde_exp = '$total_exp' where nr_pedido = '$pedido' and produto = '$cod_produto'";
                $qt = mysqli_query($link1, $sql_qt);

            }else{

            }

        }else{

            $query_cod = "select t1.cod_conferencia, t1.produto, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.produto, t1.nr_qtde
            from tb_pedido_conferencia t1
            where t1.nr_pedido = '$pedido' and t1.nr_qtde > 0
            group by t1.cod_conferencia";
            $res_col = mysqli_query($link, $query_cod);

            if(mysqli_num_rows($res_col) > 0){

                while ($parte = mysqli_fetch_assoc($res_col)) {
                    $ds_prateleira      = $parte['ds_prateleira'];
                    $ds_coluna          = $parte['ds_coluna'];
                    $ds_altura          = $parte['ds_altura'];
                    $produto            = $parte['produto'];
                    $nr_qtde            = $parte['nr_qtde'];
                    $cod_conferencia    = $parte['cod_conferencia'];


                    // NÃO FOI ENCONTRADO PRODUTO NO ENDEREÇO SELECIONADO NO PEDIDO. SERÁ CRIADA UMA POSIÇÃO PALLET COM QUANTIDADE ZERADA PARA REGISTRO DA BAIXA DO PRODUTO.//


                    $sql_saldo = "insert into tb_posicao_pallet (produto, ds_prateleira, ds_coluna, ds_altura, nr_qtde, nr_qtde_ant, nr_pedido_ant, fl_status, fl_bloq, fl_tipo, fl_empresa, usr_create, dt_create) values ('$produto','$ds_prateleira','$ds_coluna','$ds_altura','0','$nr_qtde','$pedido','A','N','D', '$cod_cli', '$id','$date')";
                    $saldo = mysqli_query($link, $sql_saldo);

                    if(mysqli_affected_rows($link) > 0){

                        $sql_col = "update tb_coleta_pedido set fl_status = 'F' where  nr_pedido = '$pedido'";
                        $col = mysqli_query($link, $sql_col);

                        $sql_prd = "update tb_pedido_coleta_produto set usr_lib_exp = '$id', dt_lib_exp = '$date', fl_status = 'F', fl_conferido = 'S' where nr_pedido = '$pedido' and produto = '$produto'";
                        $prd = mysqli_query($link1, $sql_prd);

                        $sql_ns = "update tb_nserie set  fl_status = 'F' where cod_pedido = '$pedido'";
                        $ns = mysqli_query($link1, $sql_ns);


                    }else{


                        $retorno = array(
                         'info' => "<h3 style='background-color: #A52A2A;color:white;text-align:center'><span>Erro na criação da PP.</span></h3>",
                     );

                        echo(json_encode($retorno));

                    }
                }

                $sql_ped = "update tb_pedido_coleta set fl_status = 'F' where nr_pedido = '$pedido'";
                $ped = mysqli_query($link2, $sql_ped);

                if(mysqli_affected_rows($link2) > 0){

                    $retorno = array(
                        'info' => "<h3 style='background-color: #98FB98;text-align:center'><span>Pedido finalizado com sucesso! Produto não existe na alocação. Foi criada uma posição temporária.</span></h3>",
                    );

                    echo(json_encode($retorno));


                }else{


                    $retorno = array(
                     'info' => "<h3 style='background-color: #A52A2A;color:white;text-align:center'><span>Status não pode ser alterado.</span></h3>",
                 );

                    echo(json_encode($retorno));

                }

                $sql_exp = "select sum(t1.nr_qtde_conf) as total_qtde, produto
                from tb_pedido_coleta_produto t1
                where t1.nr_pedido = '$pedido' and t1.nr_qtde > 0
                group by t1.produto";
                $res_exp = mysqli_query($link, $sql_exp);
                $expede = mysqli_fetch_assoc($res_exp);
                $cod_produto    = $expede['produto'];
                $total_exp      = $expede['total_qtde'];

                if(mysqli_num_rows($res_exp) > 0){

                    $sql_qt = "update tb_pedido_coleta_produto set nr_qtde_exp = '$total_exp' where nr_pedido = '$pedido' and produto = '$cod_produto'";
                    $qt = mysqli_query($link1, $sql_qt);

                }else{

                }

            }else{


                $retorno = array(

                    'info' => "<h3 style='background-color: #A52A2A;color:white;text-align:center'><span>Erro na finalização do pedido.</span></h3>",

                );

                echo(json_encode($retorno));


            }

        }

    }else{


        $retorno = array(
            'info' => "<h3 style='background-color: #A52A2A;color:white;text-align:center'><span>Quantidades não conferem.</span></h3>",
        );

        echo(json_encode($retorno));

    }
}

$link->close();
$link1->close();
$link2->close();
?>