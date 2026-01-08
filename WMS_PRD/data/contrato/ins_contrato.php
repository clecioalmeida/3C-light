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

    $id_cliente = mysqli_real_escape_string($link, $_POST["id_cliente"]);
    $ds_descricao = mysqli_real_escape_string($link, $_POST["ds_descricao"]);
    $dt_aprova = mysqli_real_escape_string($link, $_POST["dt_aprova"]);
    $ds_manuseio = mysqli_real_escape_string($link, $_POST["ds_manuseio"]);
    $vlr_mov = mysqli_real_escape_string($link, $_POST["vlr_mov"]);
    $nr_franquia_mov = mysqli_real_escape_string($link, $_POST["nr_franquia_mov"]);
    $dt_vencto = mysqli_real_escape_string($link, $_POST["dt_vencto"]);

    $ins_contrato="insert into tb_contrato (id_cliente, ds_descricao, dt_aprova, ds_manuseio, vlr_mov, nr_franquia_mov, dt_vencto, fl_status, usr_create, dt_create) values ('$id_cliente', '$ds_descricao', '$dt_aprova', '$ds_manuseio', '$vlr_mov', '$nr_franquia_mov', '$dt_vencto', 'A', '$id', now())";
    $res_ins_contrato = mysqli_query($link,$ins_contrato);

    if(isset($res_ins_contrato)){
     
       $retorno[] = array(
            'info' => "0",
        );

        echo(json_encode($retorno));

    } else {

        $retorno[] = array(
            'info' => "1",
        );

        echo(json_encode($retorno));
    }

$link->close();
    ?>