<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id=$_SESSION["id"];
}

?>
<?php

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once('bd_class_dsv.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$id_tar = $_POST['id_tar'];
//$inv_rua = $_POST['inv_rua'];
//$inv_mod = $_POST['inv_mod'];
//$inv_alt = $_POST['inv_alt'];
//$conf1 = $_POST['conf1'];
//$conf2 = $_POST['conf2'];
$qtde1 = $_POST['qtde1'];
$qtde2 = $_POST['qtde2'];
$qtde3 = $_POST['qtde3'];
//$ds_detalhe = $_POST['ds_detalhe'];
//$nm_produto_upd = $_POST['nm_produto_upd'];
$nr_volume = $_POST['nr_volume'];
$id_produto = $_POST['id_produto'];

$upd_tarefa="update tb_inv_tarefa set nr_volume='$nr_volume', id_produto = '$id_produto', user_update = '$id', dt_update = now() where id = '$id_tar'";
$res_tarefa=mysqli_query($link, $upd_tarefa);

$upd_conf="update tb_inv_conf set cont_1 = '$qtde1', cont_2 = '$qtde2', cont_3 = '$qtde3', user_update = '$id', dt_update = '$date' where id_tar = '$id_tar'";
$res_conf=mysqli_query($link, $upd_conf);

$link->close();
?>