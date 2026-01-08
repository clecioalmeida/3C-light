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

// PESQUISA STATUS DO PEDIDO //

$sql_st="select fl_status
from tb_pedido_coleta
where nr_pedido = '$pedido'";
$res_st=mysqli_query($link, $sql_st);
$status=mysqli_fetch_assoc($res_st);
$fl_status=$status['fl_status'];

// VALIDA SE O PEDIDO NÃO ESTÁ FINALIZADO //

if($fl_status == 'F' ){

    // SE O PEDIDO JÁ ESTIVER FINALIZADO //

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

    // SOMA QUANTIDADE SOLICITADA E QUANTIDADE CONFERIDA //

    $query_init = "select sum(nr_qtde_conf) as total_qtde, coalesce(sum(nr_qtde_exp),0) as total_exp
    from tb_pedido_coleta_produto
    where nr_pedido = '$pedido' and nr_qtde > 0";
    $res_init=mysqli_query($link, $query_init);

    while ($init = mysqli_fetch_assoc($res_init)) {

        $total      = $init['total_exp'];
        $qtde       = $init['total_qtde'];

    }

    // VALIDA SE A QUANTIDADE SOLICITADA É IGUAL A QUANTIDADE CONFERIDA //

    if($total == $qtde){

        // CRIA ARRAY COM QUANTIDADE DA POSIÇÃO APONTADA NA SEPARAÇÃO POR APONTAMENTO DA SEPARAÇÃO //

        $sql_conf = "select cod_conferencia, cod_col, produto, ds_prateleira, ds_coluna, ds_altura, nr_qtde
        from tb_pedido_conferencia
        where nr_pedido = '$pedido'";
        $res_conf = mysqli_query($link, $sql_conf);
        while ($conf = mysqli_fetch_assoc($res_conf)) {

            // CRIA ARRAY COM QUANTIDADE E CÓDIGO DE ESTOQUE DA POSIÇÃO PALLET //

            $query_cod = "select COALESCE(MIN(cod_estoque),0) as cod_estoque, ds_galpao, coalesce(nr_qtde,0) as nr_qtde_pp, coalesce(produto,0) as produto_pp
            from tb_posicao_pallet
            where ds_prateleira = '".$conf['ds_prateleira']."' and ds_coluna = '".$conf['ds_coluna']."' and ds_altura = '".$conf['ds_altura']."' and produto = '".$conf['produto']."'";
            $res_col = mysqli_query($link, $query_cod);
            while ($parte = mysqli_fetch_assoc($res_col)) {

                $ds_prateleira      = $conf['ds_prateleira'];
                $ds_coluna          = $conf['ds_coluna'];
                $ds_altura          = $conf['ds_altura'];
                $produto            = $conf['produto'];
                $nr_qtde            = $conf['nr_qtde'];
                $ds_galpao          = $parte['ds_galpao'];
                $nr_qtde_pp         = $parte['nr_qtde_pp'];
                $cod_estoque        = $parte['cod_estoque'];
                $produto_pp         = $parte['produto_pp'];
                $cod_conferencia    = $conf['cod_conferencia'];
                $nova_qtde          = $nr_qtde_pp-$nr_qtde;

                if($cod_cli == "3"){

                    // BAIXA SALDO DO ESTOQUE SE A EMPRESA FOR CD SÃO JOSÉ DOS CAMPOS //

                    if($cod_estoque == 0){

                        $ds_obs = "Produto não existe na alocação. Atualizar o saldo.";

                        $sql_prd = "update tb_pedido_conferencia set ds_obs = '$ds_obs' where cod_conferencia = '$cod_conferencia'";
                        $prd = mysqli_query($link1, $sql_prd);

                        $sql_ins = "insert into tb_posicao_pallet (produto, ds_prateleira, ds_coluna, ds_altura, nr_qtde, nr_qtde_ant, nr_pedido_ant, fl_status, fl_bloq, fl_tipo, fl_empresa, usr_create, dt_create) values ('".$conf['produto']."','".$conf['ds_prateleira']."','".$conf['ds_coluna']."','".$conf['ds_altura']."','0','".$conf['nr_qtde']."','".$pedido."','A','N','D', '".$cod_cli."', '".$id."','".$date."')";
                        $res_ins = mysqli_query($link2, $sql_ins);

                        $sql_col = "update tb_coleta_pedido set fl_status = 'F' where cod_col = '".$conf['cod_col']."' and nr_pedido = '".$pedido."' and produto = '".$conf['produto']."'";
                        $col = mysqli_query($link, $sql_col);

                        $sql_prd = "update tb_pedido_coleta_produto set usr_lib_exp = '$id', dt_lib_exp = '$date', fl_status = 'F', fl_conferido = 'S' where nr_pedido = '".$pedido."' and produto = '".$conf['produto']."'";
                        $prd = mysqli_query($link1, $sql_prd);

                    }else if($nr_qtde > $nr_qtde_pp){

                         // VALIDA SE A QUANTIDADE APONTADA NA SEPARAÇÃO É MAIOR QUE A QUANTIDADE DISPONÍVEL NA POSIÇÃO //

                        $ds_obs = "Saldo insuficiente para baixar a quantidade solicitada. Atualizar o saldo.";

                        $sql_prd = "update tb_pedido_conferencia set ds_obs = '$ds_obs' where cod_conferencia = '$cod_conferencia'";
                        $prd = mysqli_query($link1, $sql_prd);

                        $sql_saldo = "update tb_posicao_pallet set nr_qtde = '0', nr_qtde_ant = '$nr_qtde_pp', nr_pedido_ant = '$pedido', user_update = '$id', dt_update = '$date' where cod_estoque = '$cod_estoque'";
                        $saldo = mysqli_query($link, $sql_saldo);

                    }else{

                        $sql_saldo = "update tb_posicao_pallet set nr_qtde = '".$nova_qtde."', nr_qtde_ant = '".$nr_qtde_pp."', nr_pedido_ant = '".$pedido."', user_update = '".$id."', dt_update = '".$date."' where cod_estoque = '".$parte['cod_estoque']."'";
                        $saldo = mysqli_query($link, $sql_saldo);

                        $sql_col = "update tb_coleta_pedido set fl_status = 'F' where nr_pedido = '".$pedido."' and produto = '".$conf['produto']."'";
                        $col = mysqli_query($link, $sql_col);

                        $sql_prd = "update tb_pedido_coleta_produto set usr_lib_exp = '".$id."', dt_lib_exp = '".$date."', fl_status = 'F', fl_conferido = 'S' where nr_pedido = '".$pedido."' and produto = '".$conf['produto']."'";
                        $prd = mysqli_query($link1, $sql_prd);

                    } 

                }else{

                    $sql_col = "update tb_coleta_pedido set fl_status = 'F' where nr_pedido = '".$pedido."' and produto = '".$conf['produto']."'";
                    $col = mysqli_query($link, $sql_col);

                    $sql_prd = "update tb_pedido_coleta_produto set usr_lib_exp = '".$id."', dt_lib_exp = '".$date."', fl_status = 'F', fl_conferido = 'S' where nr_pedido = '".$pedido."' and produto = '".$conf['produto']."'";
                    $prd = mysqli_query($link1, $sql_prd);

                }  

            }
        }

        // VALIDA SE TODOS OS PRODUTOS DO PEDIDO FORAM FINALIZADOS //

        $sql_conf = "select fl_status from tb_pedido_coleta_produto where nr_pedido = '$pedido' and fl_status <> 'F'";
        $res_conf = mysqli_query($link, $sql_conf);

        // MANTÉM O PEDIDO ABERTO ENQUANTO TODOS OS ITENS SÃO FINALIZADOS //

        if(mysqli_affected_rows($link2) > 0){

            $retorno = array(
                'info' => "<h3 style='background-color: #A52A2A;color:white;text-align:center'><span>Pedido não pode ser finalizado.</span></h3>",
            );

            echo(json_encode($retorno));


        }else{

            // VALIDA SE O ENDEREÇO COLETADO É IGUAL AO ENDEREÇO ENCONTRADO //

            /*$sql_bx = "select t1.cod_col, t1.produto, t1.cod_estoque, COALESCE(GROUP_CONCAT(t1.ds_prateleira, t1.ds_coluna, t1.ds_altura),0) as end_col, sum(t1.nr_qtde_col) as qtd_col, COALESCE(GROUP_CONCAT(t2.ds_prateleira, t2.ds_coluna, t2.ds_altura),0) as end_conf, COALESCE(sum(t2.nr_qtde),0) as qtd_conf, round(COALESCE(t3.nr_qtde,0),0) as qtd_pos 
            from tb_coleta_pedido  t1
            left join tb_pedido_conferencia t2 on t1.cod_col = t2.cod_col
            left join tb_posicao_pallet t3 on t1.cod_estoque = t3.cod_estoque
            where t1.nr_pedido = '15503'
            group by t1.cod_col";
            $res_bx = mysqli_query($link, $sql_bx);
            while ($baixa = mysqli_fetch_assoc($res_bx)) {

                // ATUALIZA SALDO DA POSIÇÃO ENCONTRADA QUANDO A QUANTIDADE BAIXADA É DE UM ENDEREÇO DIFERENTE //

                if($baixa['end_col'] != $baixa['end_conf'] && $baixa['cod_estoque'] > 0){

                    // SUBTRAI QUANTIDADE ENCONTRADA DA QUANTIDADE DA POSIÇÃO //

                    $nova_qtde_col = $baixa['qtd_pos'] - $baixa['qtd_col'];

                    // ATUALIZA SALDO DA POSIÇÃO ENCONTRADA //

                    $sql_saldo_col = "update tb_posicao_pallet set nr_qtde = '".$nova_qtde_col."', nr_qtde_ant = '".$baixa['qtd_pos']."', nr_pedido_ant = '".$pedido."', user_update = '".$id."', dt_update = '".$date."' where cod_estoque = '".$baixa['cod_estoque']."'";
                    $saldo_col = mysqli_query($link, $sql_saldo_col);

                }

            }*/

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