<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"])){

    header("Location:index.php");
    exit;

}else{

    $id_usr = $_SESSION["id"];
}
?>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_prod_cliente = mysqli_real_escape_string($link, $_POST["cod_prod_cliente"]);
$nr_pedido = mysqli_real_escape_string($link, $_POST["nr_pedido"]);
$nr_qtde_pedido = mysqli_real_escape_string($link, $_POST["nr_qtde_pedido"]);

$query_prd="select produto from tb_pedido_coleta_produto where nr_pedido = '$nr_pedido' and produto = '$cod_prod_cliente'";
$res_prd=mysqli_query($link, $query_prd);

if(mysqli_num_rows($res_prd) > 0){

    echo "<script> alert('Esse produto já existe no pedido!')</script>";

}else{

    if($cod_prod_cliente == '' and $nr_pedido == ''){

        echo "<script> alert('Digite pelo menos uma das informações')</script>";

    }else{

        $ins_ped_col="insert into tb_pedido_coleta_produto (nr_pedido, produto, nr_qtde, fl_status, usr_create, dt_create) values ('$nr_pedido', '$cod_prod_cliente', '$nr_qtde_pedido', 'A', '$id_usr', '$date')";
        $res = mysqli_query($link,$ins_ped_col); 

        if(mysqli_affected_rows($link) > 0){

            $sql2 = "select id, dt_create, vlr_med, date(dt_create) as data_vlr
            from tb_vlr_est
            where cod_prd = '".$cod_prod_cliente."' and (dt_create <= '".$date."' or date(dt_create) = '2020-11-29')
            order by id desc limit 1";
            $res2 = mysqli_query($link, $sql2) or die(mysqli_error($link));
            $dados_prd = mysqli_fetch_assoc($res2);

            $ins_nf = "update tb_pedido_coleta_produto set vl_unit = ".$dados_prd['vlr_med']." where nr_pedido = '".$nr_pedido."' and produto = '".$cod_prod_cliente."'";
            $res_nf = mysqli_query($link, $ins_nf);

        }
    }

}


$link->close();
?>