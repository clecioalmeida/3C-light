<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id_user = $_SESSION["id"];
}
?>
<?php  
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "INSERT INTO tb_nf_entrada_item(nr_fisc_ent, fl_status, produto, estado_produto, nr_qtde, vl_unit, nr_peso_unit, user_rec, dt_rec) VALUES('".$_POST["nr_fisc_ent"]."', 'A', '".$_POST["produto"]."', '".$_POST["estado_produto"]."', '".$_POST["nr_qtde"]."', '".$_POST["vl_unit"]."', '".$_POST["nr_peso_unit"]."', '$id_user', now())";  
if(mysqli_query($link, $sql))  
{  
	echo 'Data Inserted';  
}  
$link->close();
?> 
