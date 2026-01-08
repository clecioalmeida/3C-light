<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id = $_POST['id_end'];
$end = explode("-", $id);

if(isset($end[0]) && isset($end[1]) && isset($end[2]) && isset($end[3])){

    $id_end = $end[0];
    $rua = $end[1];
    $col = $end[2];
    $alt = $end[3];

    $retorno = array(
        'info'  => "0",
        'id'    => $id_end,
        'rua'   => $rua,
        'col'   => $col,
        'alt'   => $alt,
    );

}else{

    $retorno = array(
        'info' => "Endereço não encontrado.",
    );

}

echo(json_encode($retorno));

$link->close();
?>