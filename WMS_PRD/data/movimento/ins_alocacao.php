<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$cod_est = $_POST['cod_estoque'];

$tr = 0;
foreach($cod_est as $cod){

	$query_pedido="insert into tb_aloca (cod_estoque, fl_status, fl_empresa, usr_create, dt_create) values ('$cod', 'A', '$cod_cli', '$id', '$date')";
	$res_pedido = mysqli_query($link,$query_pedido);
	$tr.=mysqli_affected_rows($link);

	$upd_aloc="update tb_aloca set fl_status = 'P' where cod_estoque = '$cod'";
	$res_aloc = mysqli_query($link,$upd_aloc);

	$upd_aloc="update tb_posicao_pallet set fl_status = 'P' where cod_estoque = '$cod'";
	$res_aloc = mysqli_query($link,$upd_aloc);
}

if($tr>0){
	$retorno[] = array(
		'info'	=> "0",
	);

}else{

	$retorno[] = array(
		'info'	=> "1",
	);

}

echo(json_encode($retorno));
$link->close();
?>