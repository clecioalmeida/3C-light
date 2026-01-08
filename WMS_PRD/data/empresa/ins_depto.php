<?php

    require_once('bd_class.php');

    $nm_dpto = $_POST['nm_dpto'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    //$search="select nm_dpto from nm_dpto where nm_dpto = '$nm_dpto'";

    $sql = " insert into tb_dpto (nm_dpto, fl_status) values ('$nm_dpto', 1) ";

    //$consulta_dpto = mysqli_query($link, $search);

    $resultado_id = mysqli_query($link, $sql);

    if($resultado_id) {
        
        echo 'Dados cadastrados com sucesso';

     } else { 
        echo 'Dados não cadastrados';
        
     }

$link->close();
?>