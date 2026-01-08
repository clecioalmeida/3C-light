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

?><?php

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_galpao = $_REQUEST['id_galpao'];

$sql_parte = "SELECT distinct ds_prateleira FROM tb_posicao_pallet where ds_galpao = '$id_galpao' and fl_status <> 'E' and fl_empresa = '$cod_cli' order by ds_prateleira asc";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte = mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		//'id'	=> $parte['id'],
		'rua' => $parte['ds_prateleira'],
		//'ds_descricao' => $parte['ds_descricao'],
	);
}

echo (json_encode($array_parte));
$link->close();
?>