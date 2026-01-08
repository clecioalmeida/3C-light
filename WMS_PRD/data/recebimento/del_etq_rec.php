<?php
require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_etq = $_POST["id_etq"];
$cod_nf = $_POST["cod_nf"];
$cod_item = $_POST["cod_item"];

$sql = "update tb_etiqueta set fl_status = 'E' WHERE cod_etq = '$id_etq'";
$res_sql = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){

	$upd_nf="update tb_nf_entrada set fl_status = 'A' where cod_nf_entrada = '$cod_nf'";
	$res_upd = mysqli_query($link,$upd_nf);

	$upd_it="update tb_nf_entrada_item set fl_status = 'A' where cod_nf_entrada_item = '$cod_item'";
	$res_it = mysqli_query($link,$upd_it);

	$array_conf = array(
		'info' => "0",
	);

	echo(json_encode($array_conf));
}else{

	$array_conf = array(
		'info' => "1",
	);

	echo(json_encode($array_conf));

}

$link->close();
?>