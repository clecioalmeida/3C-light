<?php 
require_once("bd_class.php");

$objDb = new db();
$link = $objDb->conecta_mysql();

$select_produto = "select cod_produto, cod_prod_cliente, nm_produto from tb_produto'";
$res_produto = mysqli_query($link,$select_produto);
$link->close();

?>