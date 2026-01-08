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
    $link1 = $objDb->conecta_mysql();

    $nr_pedido = $_POST['nr_pedido'];

    $query_status="select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
    $res_status = mysqli_query($link,$query_status);
    while ($status=mysqli_fetch_assoc($res_status)) {
        $fl_status=$status['fl_status'];

        if($fl_status == 'X'){

            $query_nf="select nr_nf from tb_nf_saida where nr_pedido = '$nr_pedido'";
            $res_nf = mysqli_query($link,$query_nf);
            $row=mysqli_num_rows($res_nf);

            if($row > 0){


               $upd_ped = "update tb_pedido_coleta_produto set usr_exp = '$id', dt_exp = now(), fl_status = 'L' where nr_pedido = '$nr_pedido'";
               $res_ped = mysqli_query($link,$upd_ped);

               $upd_prd = "update tb_pedido_coleta set fl_status = 'L' where nr_pedido = '$nr_pedido'";
               $res_prd = mysqli_query($link1,$upd_prd);

                echo "<script> alert('Pedido expedido com sucesso!');</script>";

            }else{

                echo "<script> alert('Não existem notas fiscais cadastradas para esse pedido.');</script>";
            }


        }else{

            echo "<script> alert('Pedido não está em fase de expedição.');</script>";

        }
    
    }
$link->close();
?>