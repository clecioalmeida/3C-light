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

    $id_cliente_emb = mysqli_real_escape_string($link, $_POST["id_cliente_emb"]);
    $id_contrato_emb = mysqli_real_escape_string($link, $_POST["id_contrato_emb"]);
    $ds_descricao = mysqli_real_escape_string($link, $_POST["ds_descricao"]);
    $nr_cubado = mysqli_real_escape_string($link, $_POST["nr_cubado"]);
    $nr_peso = mysqli_real_escape_string($link, $_POST["nr_peso"]);
    $nr_comprimento = mysqli_real_escape_string($link, $_POST["nr_comprimento"]);
    $nr_largura = mysqli_real_escape_string($link, $_POST["nr_largura"]);
    $nr_altura = mysqli_real_escape_string($link, $_POST["nr_altura"]);

    $ins_contrato="insert into tb_embalagem (ds_tipo, nr_cubado, nr_peso, nr_comprimento, nr_largura, nr_altura, id_cliente, id_contrato, fl_status, user_create, dt_create) values ('$ds_descricao', '$nr_cubado', '$nr_peso', '$nr_comprimento', '$nr_largura', '$nr_altura', '$id_cliente_emb', '$id_contrato_emb', 'A', '$id', now())";
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