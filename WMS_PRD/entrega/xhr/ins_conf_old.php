<?php
session_start();

$cod_cliente = $_SESSION['id'];

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_torre = mysqli_real_escape_string($link,$_POST['id_torre']);
$cod_produto = mysqli_real_escape_string($link,$_POST['cod_produto']);
$qtde1 = mysqli_real_escape_string($link,$_POST['qtde1']);
$qtde2 = mysqli_real_escape_string($link,$_POST['qtde2']);
$id_end = mysqli_real_escape_string($link,$_POST['id_pp']);

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

if($qtde1 == 0 || $qtde2 == 0){

	include 'err1_ins_tar.php';

    }else{

        $insert="select galpao, rua, coluna, altura, id 
            from tb_endereco
            where id = '$id_end'
            order by fl_status desc";
            $res = mysqli_query($link, $insert);

            while ($dados=mysqli_fetch_assoc($res)) {
                $id_galpao = $dados['galpao'];
                $id_rua = $dados['rua'];
                $id_coluna = $dados['coluna'];
                $id_altura = $dados['altura'];

                $sql = "insert into tb_inv_tarefa (id_inv, id_estoque, id_produto, id_galpao, id_rua, id_coluna, id_altura, nr_qtde, fl_status) values ('61', '$id_end', '$cod_produto', '$id_galpao', '$id_rua', '$id_coluna', '$id_altura', '0', 'A')";
                $res_insert = mysqli_query($link, $sql);
                $new_tar = mysqli_insert_id($link);

                $sql_conf = "insert into tb_inv_conf (id_tar, cont_1, cont_2, dt_conf_1, dt_conf_2, conf_1, conf_2, user_create) values ('$new_tar', '$qtde1', '$qtde2', now(), now(), '$cod_cliente', '$cod_cliente', '$cod_cliente')";
                $res_conf = mysqli_query($link, $sql_conf);
            }
    }

    $link->close();
?>