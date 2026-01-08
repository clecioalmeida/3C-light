<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:index.php");
    exit;

}else{

    $id_usr     = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$pedido     = $_POST['pedido'];

// PESQUISA QUANTIDADE DO PEDIDO E QUANTIDADE SEPARADA //

$query_init="select sum(t1.nr_qtde) as total_ped, sum(t2.nr_qtde) as total_conf
from tb_pedido_coleta_produto t1
left join tb_pedido_conferencia t2 on t1.nr_pedido = t2.nr_pedido and t1.produto = t2.produto
where t1.nr_pedido = '$pedido' and t2.nr_pedido = '$pedido'";
$res_init=mysqli_query($link, $query_init);
$init = mysqli_fetch_assoc($res_init);
$qtde_ped = $init['total_ped'];
$qtde_cnf = $init['total_conf'];

// COMPARA QUANTIDADES ENCONTRADAS //

if($qtde_ped > $qtde_cnf){

    // PEDIDO PARCIAL //

    $retorno[] = array(
        'info' => "Quantidade não confere.",
    );

}else if($qtde_ped == $qtde_cnf){

    // QUANTIDADES CONFEREM  - CRIA ARRAY COM TOTAL SEPARADO POR PRODUTO //

    $select_dest = "SELECT produto, sum(nr_qtde) as qtde_conf FROM tb_pedido_conferencia WHERE nr_pedido = '$pedido' group by produto";
    $res_dest = mysqli_query($link,$select_dest);

    while ($dest=mysqli_fetch_assoc($res_dest)) {

        $qtde_conf  = $dest['qtde_conf'];
        $produto    = $dest['produto'];

        // GRAVA SEPARAÇÃO NA TABELA COM PRODUTOS DO PEDIDO //

        $sql_prd = "update tb_pedido_coleta_produto set fl_status = 'X', nr_qtde_conf = '$qtde_conf', usr_fim_coleta = '$id_usr', dt_fim_coleta = '$date' where produto = '$produto' and nr_pedido = '$pedido'";
        $res_prd = mysqli_query($link, $sql_prd);

    }

    // VALIDA SE A SEPARAÇÃO DE TODOS OS PRODUTOS FOI GRAVADA //

    // SOMA AS QUANTIDADES GRAVADAS NO CAMPO QUANTIDADE DA SEPARAÇÃO //

    $query_conf = "select sum(t1.nr_qtde_conf) as total_sep
    from tb_pedido_coleta_produto t1
    where t1.nr_pedido = '$pedido'";
    $res_conf = mysqli_query($link, $query_conf);
    $conf = mysqli_fetch_assoc($res_conf);
    $total_sep = $conf['total_sep'];

    // COMPARA QUANTIDADE SEPARADA COM QUANTIDADE SOLICITADA NO PEDIDO //

    if($qtde_sep == $qtde_ped){

        //SE SIM, ATUALIZA AS TABELAS DE PEDIDO E DE COLETA //

        $upd_col="update tb_coleta_pedido set fl_status = 'X', usr_col = '$id_usr', dt_col = '$date' where nr_pedido = '$pedido'";
        $res_upd_col=mysqli_query($link, $upd_col);

        $upd_ped="update tb_pedido_coleta set fl_status = 'X' where nr_pedido = '$pedido'";
        $res_upd_ped=mysqli_query($link, $upd_ped);

        // VALIDA SE A TABELA FOI ALTERADA //

        if(mysqli_affected_rows($link) > 0){

            $retorno[] = array(
                'info' => 1,
            );

        }else{

            $retorno[] = array(
                'info' => 2,
            );

        }

        // BAIXA SALDO DO ESTOQUE SE A EMPRESA FOR CD VILA VELHA //

        /*if($cod_cli == "4"){

            // CRIA ARRAY COM QUANTIDADE DA POSIÇÃO APONTADA NA SEPARAÇÃO POR APONTAMENTO DA SEPARAÇÃO //

            $query_cod = "select t1.cod_conferencia, COALESCE(MIN(t2.cod_estoque),0) as cod_estoque, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.produto, t1.nr_qtde, t2.ds_galpao, coalesce(t2.nr_qtde,0) as nr_qtde_pp, coalesce(t2.produto,0) as produto_pp
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
                $nova_qtde          = $nr_qtde_pp - $nr_qtde;

                if($cod_estoque == "0"){

                    // VALIDA SE O PRODUTO EXISTE NA POSIÇÃO //

                    $ds_obs = "Produto não existe na alocação. Atualizar o saldo.";

                    $sql_prd = "update tb_pedido_conferencia set ds_obs = '$ds_obs' where cod_conferencia = '$cod_conferencia'";
                    $prd = mysqli_query($link1, $sql_prd);

                    $sql_ins = "insert into tb_posicao_pallet (produto, ds_prateleira, ds_coluna, ds_altura, nr_qtde, nr_qtde_ant, nr_pedido_ant, fl_status, fl_bloq, fl_tipo, fl_empresa, usr_create, dt_create) values ('".$conf['produto']."','".$conf['ds_prateleira']."','".$conf['ds_coluna']."','".$conf['ds_altura']."','0','".$conf['nr_qtde']."','".$pedido."','A','N','D', '".$cod_cli."', '".$id."','".$date."')";
                    $res_ins = mysqli_query($link, $sql_ins);

                    $sql = "insert into tb_ocorrencias (nm_ocorrencia, tipo, ds_responsavel, nm_depto, criticidade, dt_abertura, fl_status, cod_origem, ds_obs, fl_empresa, user_create, dt_create) values ('200 - Pedido liberado parcialmente', '', 'id', 'Separação', 'A', '$date', 'A', '$pedido - $produto', '', '$cod_cli', '$id', '$date')";
                    $resultado_id = mysqli_query($link, $sql);


                }else if($nr_qtde > $nr_qtde_pp){

                        // VALIDA SE A QUANTIDADE APONTADA NA SEPARAÇÃO É MAIOR QUE A QUANTIDADE DISPONÍVEL NA POSIÇÃO //

                    $ds_obs = "Saldo insuficiente para baixar a quantidade solicitada. Atualizar o saldo.";

                    $sql_prd = "update tb_pedido_conferencia set ds_obs = '$ds_obs' where cod_conferencia = '$cod_conferencia'";
                    $prd = mysqli_query($link1, $sql_prd);

                    $sql_saldo = "update tb_posicao_pallet set nr_qtde = '0', nr_qtde_ant = '$nr_qtde_pp', nr_pedido_ant = '$pedido', user_update = '$id', dt_update = '$date' where cod_estoque = '$cod_estoque'";
                    $saldo = mysqli_query($link, $sql_saldo);

                    $sql = "insert into tb_ocorrencias (nm_ocorrencia, tipo, ds_responsavel, nm_depto, criticidade, dt_abertura, fl_status, cod_origem, ds_obs, fl_empresa, user_create, dt_create) values ('200 - Pedido liberado parcialmente', '', 'id', 'Separação', 'A', '$date', 'A', '$pedido - $produto', '', '$cod_cli', '$id', '$date')";
                    $resultado_id = mysqli_query($link, $sql);

                    /*$retorno = array(
                        'info' => "Saldo insuficiente para baixar a quantidade solicitada. Atualizar o saldo.",
                    );

                    echo(json_encode($retorno));
                    
                    exit();*/

                //}else{

                    // BAIXA O SALDO DO ESTOQUE SE A QUANTIDADE APONTADA NA SEPARAÇÃO É MENOR OU IGUAL A QUANTIDADE DISPONÍVEL NA POSIÇÃO //

                    /*$sql_saldo = "update tb_posicao_pallet set nr_qtde = '$nova_qtde', nr_qtde_ant = '$nr_qtde_pp', nr_pedido_ant = '$pedido', user_update = '$id', dt_update = '$date' where cod_estoque = '$cod_estoque'";
                    $saldo = mysqli_query($link, $sql_saldo);

                    $sql_col = "update tb_coleta_pedido set fl_status = 'F' where cod_estoque = '$cod_estoque' and nr_pedido = '$pedido'";
                    $col = mysqli_query($link, $sql_col);

                    $sql_prd = "update tb_pedido_coleta_produto set usr_lib_exp = '$id', dt_lib_exp = '$date', fl_status = 'F' where nr_pedido = '$pedido' and produto = '$produto'";
                    $prd = mysqli_query($link1, $sql_prd);*/

               //}   

            //}

        //}

                }else{

                    $retorno[] = array(
                        'info' => 2,
                    );

                }

            }

            echo(json_encode($retorno));

            $link->close();
            ?>