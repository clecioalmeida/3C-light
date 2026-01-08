<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:../index.php");
    exit;

}else{

    $id = $_SESSION["id"];
    $cod_cli = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$ds_tipo            = $_POST['ds_tipo'];
$dt_inicio          = $_POST['dt_inicio'];
$dt_fim             = $_POST['dt_fim'];
$id_galpao          = $_REQUEST['id_galpao'];
$id_rua_inicio      = $_POST['id_rua_inicio'];
$id_rua_fim         = $_POST['id_rua_fim'];
$id_coluna_inicio   = $_POST['id_coluna_inicio'];
$id_coluna_fim      = $_POST['id_coluna_fim'];
$id_altura_inicio   = $_POST['id_altura_inicio'];
$id_altura_fim      = $_POST['id_altura_fim'];
$id_grupo           = $_POST['id_grupo'];
$id_sub_grupo       = $_POST['id_sub_grupo'];
$id_produto         = $_POST['id_produto'];

$sql_inv = "insert into tb_inv_prog (ds_tipo, dt_inicio, dt_fim, id_galpao, id_rua_inicio, id_rua_fim, id_coluna_inicio, id_coluna_fim, id_altura_inicio, id_altura_fim, id_grupo, id_sub_grupo, id_produto, fl_status, fl_empresa, user_create, data_create) values ('$ds_tipo', '$dt_inicio', '$dt_fim', '$id_galpao', '$id_rua_inicio', '$id_rua_fim', '$id_coluna_inicio', '$id_coluna_fim', '$id_altura_inicio', '$id_altura_fim', '$id_grupo', '$id_sub_grupo', '$id_produto', 'P', '$cod_cli', '$id', '$date')";

$resultado_id = mysqli_query($link, $sql_inv);

if(mysqli_affected_rows($link) > 0){

    $retorno[] = array(
      'info' => "0",
  );
    echo(json_encode($retorno));

}else{

    $retorno[] = array(
      'info' => "1",
  );
    echo(json_encode($retorno));           

}

$link->close();
?>