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

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_minuta = $_POST['cod_min'];

$min = "update tb_minuta set fl_expedido = 'S', fl_status = 'F', dt_expedido = '$date', nm_expedido_por = '$id' where cod_minuta = '$cod_minuta'";
$res_min = mysqli_query($link, $min);

if (mysqli_affected_rows($link) > 0) {

		$retorno = array(
			'info' => "0",
		);

		echo (json_encode($retorno));

} else {

	$retorno = array(
		'info' => "1",
	);

	echo (json_encode($retorno));

}
$link->close();
?>