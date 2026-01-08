<?php

    require_once('bd_class.php');

    $cod_grupo = $_POST['cod_grupo'];
    $nm_sub_grupo = $_POST['nm_sub_grupo'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = " insert into tb_sub_grupo (cod_grupo, nm_sub_grupo) values ('$cod_grupo', '$nm_sub_grupo') ";

     
        $resultado_id = mysqli_query($link, $sql);

            if($resultado_id){

                echo 'Dados cadastrados com sucesso';

            } else {
                echo 'Dados não cadastrados';
                echo $cod_grupo;
                echo $nm_sub_grupo;
            }

    
$link->close();
?>