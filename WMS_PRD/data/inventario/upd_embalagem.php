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

    $id_tar = $_POST['id_tar'];
    $ds_embalagem = $_POST['ds_embalagem'];
    
    $sql = "update tb_inv_tarefa set ds_embalagem = '$ds_embalagem', user_update = '$id', dt_update = now() where id = '$id_tar'";
    $resultado_id = mysqli_query($link, $sql);

    $upd_pp = "update tb_posicao_pallet set ds_embalagem = '$ds_embalagem' where id_tar = '$id_tar'";
    $resultado_pp = mysqli_query($link, $upd_pp);
    
    if(mysqli_affected_rows($link) > 0){
     
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