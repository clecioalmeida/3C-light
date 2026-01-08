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


$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

if(isset($_POST['id_tar'])){


    $id_tar = mysqli_real_escape_string($link,$_POST['id_tar']);

    $upd_nf = "update tb_inv_conf set status_conf = 'P' where id_tar = '$id_tar'";
    $res_upd_nf = mysqli_query($link,$upd_nf);

    if($res_upd_nf){

        $array_estoque[] = array(
            'fin_conf'    => "Conferência finalizada com sucesso!",
        );

        echo(json_encode($array_estoque));

    }else{

        $array_estoque[] = array(
            'fin_conf'    => "Erro!",
        );

        echo(json_encode($array_estoque));

    }


}else{

    $array_estoque[] = array(
        'fin_conf'    => "Erro!",
    );

    echo(json_encode($array_estoque));

}
$link->close();
?>