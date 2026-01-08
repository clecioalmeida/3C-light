<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:../index.php");
    exit;

}else{

    $id=$_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_ns = $_POST['ins_qtde_ns'];
$cod_rec = $_POST['cod_rec'];

$query_prod="select n_serie from tb_nserie where n_serie = '$nr_ns'";
$res_prod=mysqli_query($link, $query_prod);
$tr_prod = mysqli_num_rows($res_prod);

if($tr_prod == 0){

    $insert_barcode = "insert into tb_nserie (n_serie, cod_rec, fl_status, usr_create, dt_create) values ('$nr_ns', '$cod_rec', 'A', '$id', '$date')";
    $res_barcode = mysqli_query($link,$insert_barcode);

    if($res_barcode){

        $query_conf="select count(id) as total from tb_nserie where cod_rec = '$cod_rec'";
        $res_conf=mysqli_query($link, $query_conf);
        $conf=mysqli_fetch_assoc($res_conf);
        $array_estoque = array(
            'info'          => "0",
            'total_conf'    => $conf['total'],
       
        );

        echo(json_encode($array_estoque));
  

    }else{

        $array_estoque[] = array(

            'total_conf'    => "Número de série não cadastrado.",

        );

        echo(json_encode($array_estoque));
        exit();

    }

}else{

    $array_estoque[] = array(
        'total_conf'    => "Número de série já existe!",
    );

    echo(json_encode($array_estoque));
    exit();
}
$link->close();
?>