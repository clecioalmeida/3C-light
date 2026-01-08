<?php

    require_once('bd_class.php');

    $nm_grupo = $_POST['nm_grupo'];
   
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sql = " insert into tb_grupo (nm_grupo) values ('$nm_grupo') ";

     
        $resultado_id = mysqli_query($link, $sql);

            if($resultado_id){

                echo 'Dados cadastrados com sucesso';

            } else {
                echo 'Dados não cadastrados';

                echo $nm_grupo;
            }

    
$link->close();
?>