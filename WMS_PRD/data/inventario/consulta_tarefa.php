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

    $nr_inv = $_REQUEST['nr_inv'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql1="select distinct id_inv from tb_inv_tarefa where id_inv = '$nr_inv'";
    $res_inv = mysqli_query($link, $sql1);

    if(mysqli_num_rows($res_inv) > 0){

        $retorno[] = array(
            'info' => "0",
        );

         echo(json_encode($retorno));

    }else{

        $retorno[] = array(
                'info' => "1",
        );

        echo(json_encode($retorno));
    }
   
$link->close();
?>