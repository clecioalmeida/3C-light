<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;

} else {

    $id = $_SESSION["id"];
    $cod_cli = $_SESSION["cod_cli"];
}

?>
<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select t1.id, t1.nome, t1.galpao as nm_galpao, t1.fl_situacao, t1.fl_curva, t1.aloc_aut, t1.fl_tipo, t2.galpao, t2.cod_galpao from tb_armazem t1 left join tb_galpao t2 on t1.galpao = t2.cod_galpao where t1.id_oper = '$cod_cli'";
$res = mysqli_query($link,$SQL); 
$tr = mysqli_num_rows($res);

$link->close();
?>