<?php

    require_once('bd_class.php');

    $nm_cargo = $_POST['nm_cargo'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    //$search="select nm_cargo from tb_cargo where nm_cargo = '$nm_cargo'";

    $sql = " insert into tb_cargo (nm_cargo, fl_status) values ('$nm_cargo', 1) ";

    //$consulta_cargo = mysqli_query($link, $search);

    $resultado_id = mysqli_query($link, $sql);

    if($resultado_id) {
        
        echo 'Dados cadastrados com sucesso';

     } else { 
        echo 'Dados não cadastrados';
     	
     }

$link->close();
?>