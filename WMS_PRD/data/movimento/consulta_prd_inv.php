<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id=$_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto = $_REQUEST['cod_produto'];
//$nr_pedido = $_REQUEST['nr_pedido'];

$sql_col = "select distinct produto from tb_posicao_pallet where cod_produto = '$cod_produto' and fl_bloq = 'S' and fl_empresa = '$cod_cli'";
$res_col = mysqli_query($link, $sql_col);

if (mysqli_num_rows($res_col) > 0) {

	$retorno[] = array(
		'info' => "0",
	);
	echo (json_encode($retorno));

}else{
	$retorno[] = array(
		'info' => "1",
	);
	echo (json_encode($retorno));
}

$link->close();
?>