<?php

    require_once('bd_class.php');

    $nr_inv = $_POST['nr_inv'];
    $id_galpao = $_POST['id_galpao'];
    $id_produto = $_POST['id_produto'];
    $id_rua_inicio = $_POST['id_rua_inicio'];
    $id_rua_fim = $_POST['id_rua_fim'];
    $id_coluna_inicio = $_POST['id_coluna_inicio'];
    $id_coluna_fim = $_POST['id_coluna_fim'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $query="SET SQL_BIG_SELECTS=1";
    $res_query=mysqli_query($link, $query);

    if($id_rua_inicio == 0){

        $insert="select t1.*, t2.cod_estoque, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.produto, t2.nr_qtde, t2.produto, t3.nome 
            from tb_inv_prog t1 
            left join tb_posicao_pallet t2 on t1.id_galpao = t2.ds_galpao
            left join tb_armazem t3 on t1.id_galpao = t3.id
            where t1.id = '$nr_inv' and t2.ds_galpao = '$id_galpao'
            order by t1.fl_status desc";
            $res = mysqli_query($link, $insert);

            while ($dados=mysqli_fetch_assoc($res)) {
                $id_inv = $dados['id'];
                $id_estoque = $dados['cod_estoque'];
                $id_produto = $dados['produto'];
                $id_galpao = $dados['id_galpao'];
                $id_rua = $dados['ds_prateleira'];
                $id_coluna = $dados['ds_coluna'];
                $id_altura = $dados['ds_altura'];
                $nr_qtde = $dados['nr_qtde'];

                $sql = "insert into tb_inv_tarefa (id_inv, id_estoque, id_produto, id_galpao, id_rua, id_coluna, id_altura, nr_qtde, fl_status) values ('$id_inv', '$id_estoque', '$id_produto', '$id_galpao', '$id_rua', '$id_coluna', '$id_altura', '$nr_qtde', 'A')";
                $res_insert = mysqli_query($link, $sql);
            }

    }elseif($id_rua_inicio != 0){

        $insert="select t1.*, t2.cod_estoque, t2.ds_galpao, t2.ds_prateleira, t2.ds_coluna, t2.ds_altura, t2.produto, t2.nr_qtde, t2.produto, t3.nome 
            from tb_inv_prog t1 
            left join tb_posicao_pallet t2 on t1.id_galpao = t2.ds_galpao
            left join tb_armazem t3 on t1.id_galpao = t3.id
            where t1.id = '$nr_inv' and t2.ds_prateleira >= '$id_rua_inicio' and t2.ds_prateleira <= '$id_rua_fim' and t2.ds_coluna >= '$id_coluna_inicio' and t2.ds_coluna <= '$id_coluna_fim'
            order by t1.fl_status desc";
            $res = mysqli_query($link, $insert);

            while ($dados=mysqli_fetch_assoc($res)) {
                $id_inv = $dados['id'];
                $id_estoque = $dados['cod_estoque'];
                $id_produto = $dados['produto'];
                $id_galpao = $dados['id_galpao'];
                $id_rua = $dados['ds_prateleira'];
                $id_coluna = $dados['ds_coluna'];
                $id_altura = $dados['ds_altura'];
                $nr_qtde = $dados['nr_qtde'];

                $sql = "insert into tb_inv_tarefa (id_inv, id_estoque, id_produto, id_galpao, id_rua, id_coluna, id_altura, nr_qtde, fl_status) values ('$id_inv', '$id_estoque', '$id_produto', '$id_galpao', '$id_rua', '$id_coluna', '$id_altura', '$nr_qtde', 'A')";
                $res_insert = mysqli_query($link, $sql);
            }

    }
    

            if(mysqli_affected_rows($link) > 0){ 

                include 'sucess_ins_tar.php';

            }else{ 

                include 'err_ins_tar.php';

            }

    $link->close();
?>