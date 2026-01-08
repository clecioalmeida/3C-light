<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;

} else {

  $id_user = $_SESSION["id"];
  $cod_cli = $_SESSION["cod_cli"];
}

?>
<?php 
	require_once('bd_class_dsv.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_galpao_inv 	= $_REQUEST['id_galpao_inv'];
	$id_rua 		= $_REQUEST['id_rua'];
	$id_coluna 		= $_REQUEST['id_coluna'];
	
	$sql_parte = "SELECT distinct e.altura 
	FROM tb_endereco e 
	left join tb_armazem a on e.galpao = a.id
	where a.id_oper = '$cod_cli' and e.coluna = '$id_coluna' and e.rua = '$id_rua' and e.galpao = '$id_galpao_inv'";
	$res_parte = mysqli_query($link, $sql_parte);
	
	while ($parte=mysqli_fetch_assoc($res_parte)) {
		$array_parte[] = array(
			//'id'	=> $parte['id'],
			'altura' => $parte['altura'],
			//'ds_descricao' => $parte['ds_descricao'],
		);
	}	

	echo(json_encode($array_parte));
$link->close();
?>