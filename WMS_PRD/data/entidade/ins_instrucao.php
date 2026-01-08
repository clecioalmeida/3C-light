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

    require_once('bd_class_dsv.php');
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $cliente = $_POST['cliente'];
    $destinatario = $_POST['destinatario'];
    $instrucao = $_POST['instrucao'];
    if(isset($_POST['pedido'])){
        $pedido = $_POST['pedido'];

        $sql = " insert into tb_inst_entrega (id_cliente, id_destinatario, nr_pedido, ds_instrucao, usr_create, dt_create) values ('$cliente', '$destinatario', '$pedido', '$instrucao', '$id', now())";
        $resultado_id = mysqli_query($link, $sql);

    }else{

        $sql = " insert into tb_inst_entrega (id_cliente, id_destinatario, ds_instrucao, usr_create, dt_create) values ('$cliente', '$destinatario', '$instrucao', '$id', now())";
        $resultado_id = mysqli_query($link, $sql);

    }
    
    if($resultado_id){

     
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