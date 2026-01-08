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

$nr_ped = $_POST['nr_ped'];

$sql_conf = "select id_produto, count(n_serie) as total_prd, ds_prateleira, ds_coluna, ds_altura from tb_nserie where cod_pedido = '$nr_ped' group by id_produto, ds_prateleira, ds_coluna, ds_altura";
$res_conf = mysqli_query($link, $sql_conf);

if(mysqli_num_rows($res_conf) > 0){

    while ($dados = mysqli_fetch_assoc($res_conf)) {

        $sql_prd = "select produto from tb_pedido_conferencia where nr_pedido = '$nr_ped' and produto = '".$dados['id_produto']."' and ds_prateleira = '".$dados['ds_prateleira']."' and ds_coluna = '".$dados['ds_coluna']."' and ds_altura = '".$dados['ds_altura']."'";
        $res_prd = mysqli_query($link, $sql_prd);

        if(mysqli_num_rows($res_prd) > 0){

            $upd_col = "update tb_pedido_conferencia set nr_qtde = '".$dados['total_prd']."' where nr_pedido = '".$nr_ped."' and produto = '".$dados['id_produto']."' and ds_prateleira = '".$dados['ds_prateleira']."' and ds_coluna = '".$dados['ds_coluna']."' and ds_altura = '".$dados['ds_altura']."'";
            $res_col = mysqli_query($link, $upd_col);

            if(mysqli_affected_rows($link) > 0){

                $retorno[] = array(
                    'info'  => "<p style='background-color: #32CD32'>Produto ".$dados['id_produto']." cadastrado.</p>",
                    'text'  => "",
                ); 

            }else{

                $retorno[] = array(
                    'info'  => "<p style='background-color: #F08080'>Produto ".$dados['id_produto']." não cadastrado.</p>",
                    'text'  => "",
                ); 

            }

        }else{

            $upd_col = "insert into tb_pedido_conferencia (nr_pedido, produto, ds_prateleira, ds_coluna, ds_altura, nr_qtde, fl_conferido, usr_create, dt_create) values ('$nr_ped', '".$dados['id_produto']."', '".$dados['ds_prateleira']."', '".$dados['ds_coluna']."', '".$dados['ds_altura']."', '".$dados['total_prd']."', 'C', '$id', '$date')";
            $res_col = mysqli_query($link, $upd_col);

            if(mysqli_affected_rows($link) > 0){

                $retorno[] = array(
                    'info'  => "<p style='background-color: #32CD32'>Produto ".$dados['id_produto']." cadastrado.</p>",
                    'text'  => "",
                ); 

            }else{

                $retorno[] = array(
                    'info'  => "<p style='background-color: #F08080'>Produto ".$dados['id_produto']." não cadastrado.</p>",
                    'text'  => "",
                ); 

            }

        }



    }

}else{

    $retorno[] = array(
        'text'  => "<p style='background-color: #F08080'>Não existem produtos cadastrados no pedido ".$nr_ped.". </p>",
        'info'  => "",
    ); 

}

$sql_count = "select id_produto, count(n_serie) as total_prd from tb_nserie where cod_pedido = '$nr_ped' group by id_produto";
$res_count = mysqli_query($link, $sql_count);

if(mysqli_num_rows($res_count) > 0){

    while ($dados = mysqli_fetch_assoc($res_count)) {

        $sql_prd = "select produto from tb_pedido_coleta_produto where nr_pedido = '$nr_ped' and produto = '".$dados['id_produto']."'";
        $res_prd = mysqli_query($link, $sql_prd);

        if(mysqli_num_rows($res_prd) > 0){

            $sql_prod = "update tb_pedido_coleta_produto set nr_qtde = '".$dados['total_prd']."', fl_conferido = 'C', usr_create = '$id', dt_create = '$date' where nr_pedido = '".$nr_ped."' and produto = '".$dados['id_produto']."'";
            $res_prod = mysqli_query($link, $sql_prod);

            if(mysqli_affected_rows($link) > 0){

                $retorno[] = array(
                    'info'  => "<p style='background-color: #32CD32'>Produto ".$dados['id_produto']." cadastrado.</p>",
                    'text'  => "",
                ); 

            }else{

                $retorno[] = array(
                    'info'  => "<p style='background-color: #F08080'>Produto ".$dados['id_produto']." não cadastrado.</p>",
                    'text'  => "",
                ); 

            }

        }else{

            $sql_prod = "insert into tb_pedido_coleta_produto (produto, nr_pedido, nr_qtde, fl_conferido, fl_status, fl_empresa, usr_create, dt_create) values ('".$dados['id_produto']."', '".$nr_ped."', '".$dados['total_prd']."', 'C', 'C', '$cod_cli', '$id', '$date')";
            $res_prod = mysqli_query($link, $sql_prod);

            if(mysqli_affected_rows($link) > 0){

                $retorno[] = array(
                    'info'  => "<p style='background-color: #32CD32'>Produto ".$dados['id_produto']." cadastrado.</p>",
                    'text'  => "",
                ); 

            }else{

                $retorno[] = array(
                    'info'  => "<p style='background-color: #F08080'>Produto ".$dados['id_produto']." não cadastrado.</p>",
                    'text'  => "",
                ); 

            }

        }



    }

}else{

    $retorno[] = array(
        'text'  => "<p style='background-color: #F08080'>Não existem produtos cadastrados no pedido ".$nr_ped.". </p>",
        'info'  => "",
    ); 

}

echo(json_encode($retorno));

$link->close();
?>