<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;

} else {

  $id     = $_SESSION["id"];
  $cod_cli  = $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$nr_pedido      = $_POST['nr_pedido'];
$dt_minuta      = $_POST['dt_minuta'];
$hr_entrada     = $_POST['hr_entrada'];
$hr_saida       = $_POST['hr_saida'];
$nr_placa       = $_POST['nr_placa'];
$ds_transporte  = $_POST['ds_transporte'];
$km_ini         = $_POST['km_ini'];
$km_fim         = $_POST['km_fim'];
$ds_tipo        = $_POST['ds_tipo'];
$ds_obs         = $_POST['ds_obs'];

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

$ins_min = "insert into tb_minuta (ds_tipo, ds_transporte, nr_placa, dt_minuta, hr_entrada,  hr_saida, km_ini, km_fim, fl_empresa, fl_status, ds_obs, usr_create, dt_create) values ('$ds_tipo', '$ds_transporte', '$nr_placa', '$dt_minuta', '$hr_entrada', '$hr_saida', '$km_ini', '$km_fim', '$cod_cli', 'A', '$ds_obs', '$id', '$date')";
$res_ins = mysqli_query($link1, $ins_min);
$minuta = mysqli_insert_id($link1);

if($minuta){

  foreach($nr_pedido as $pedido){

    $upd_ped = "update tb_pedido_coleta set nr_minuta = '$minuta', fl_status = 'F' where nr_pedido = '$pedido'";
    $res_ped = mysqli_query($link,$upd_ped);  

    $upd = "update tb_pedido_coleta_produto fl_status = 'F' where nr_pedido = '$pedido'";
    $res = mysqli_query($link,$upd);  
  }

  if($res_ped){

    $retorno[] = array(
      'info' => "0",
      'minuta' => $minuta,
    );
    echo(json_encode($retorno));

  }else{

    $retorno[] = array(
      'info' => "1",
    );
    echo(json_encode($retorno));

  }

}else{

  $retorno[] = array(
    'info' => "2",
  );
  echo(json_encode($retorno));

}

$link->close();
$link1->close();
?>