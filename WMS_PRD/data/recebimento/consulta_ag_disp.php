<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:../index.php");
  exit;

} else {

  $id       = $_SESSION["id"];
  $cod_cli  = $_SESSION['cod_cli'];
}
?>
<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$dt_disp = $_REQUEST['dt_disp'];

$sql_dt = "SELECT id, CASE fl_tipo WHEN 'N' THEN ds_janela WHEN 'E' THEN CONCAT(ds_janela, '-EXTRA') END as ds_janela FROM tb_janela
WHERE fl_empresa = '$cod_cli' and dt_janela = '$dt_disp' and fl_status = 'A' and (fl_tipo = 'N' or fl_tipo = 'E')" or die(mysqli_error($sql_dt));
$res_dt = mysqli_query($link, $sql_dt);

while ($conf=mysqli_fetch_assoc($res_dt)) {
	$array_conf[] = array(
		'id'			=> $conf['id'],
		'ds_janela' 	=> $conf['ds_janela'],
	);
}

echo(json_encode($array_conf));

$link->close();
?>