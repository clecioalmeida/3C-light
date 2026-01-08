<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;
} else {

    $id_usr     = $_SESSION["id"];
    $cod_cli     = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date         = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_serial     = $_POST['nr_serial'];

$sql = "select nr_serial from tb_recebimento_ag where nr_serial = '$nr_serial' and fl_status <> 'E'";
$res = mysqli_query($link, $sql);

if (mysqli_num_rows($res) > 0) {

    $retorno = array(
        'info'        => "1"
    );
} else {

    $retorno = array(
        'info'        => "0"
    );
}

echo (json_encode($retorno));

$link->close();
?>