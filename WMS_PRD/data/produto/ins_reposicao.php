<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:../../../index.php");
    exit;

} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];

}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_item    = $_POST['id_item'];
$nm_sol     = $_POST['nm_sol'];
$nr_cr      = $_POST['nr_cr'];
$dt_prev    = $_POST['dt_prev'];

$sql = "insert into tb_reposicao (dt_reposicao, ds_solicitante, nr_cr, dt_previsto, fl_status, usr_create, dt_create) values ('$date', '$nm_sol', '$nr_cr', '$dt_prev', 'A', '$id', '$date')";
$res_man = mysqli_query($link, $sql);

if (mysqli_affected_rows($link) > 0) {

    $nRep = mysqli_insert_id($link);

    foreach ($id_item as $a) {
        $query_vol = "update tb_reposicao_item set id_reposicao = '$nRep' WHERE id = '" . $a . "'";
        $res_vol = mysqli_query($link, $query_vol);
    }
    
    $array_info = array(
        'info' => "Reposição cadastrada.",
        'nRep' => $nRep,
    );
    echo (json_encode($array_info));

} else {

    $array_info = array(
        'info' => "Erro no cadastro",
    );
    echo (json_encode($array_info));
}

$link->close();
?>