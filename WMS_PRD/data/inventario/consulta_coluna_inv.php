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
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$rua = $_REQUEST['id_rua'];
	$id_galpao_inv = $_REQUEST['id_galpao_inv'];
	
	$sql_col = "select distinct(e.coluna) 
	from tb_endereco e
	left join tb_armazem a on e.galpao = a.id
	where a.id_oper = '$cod_cli' and e.rua = '$rua' and e.galpao = '$id_galpao_inv'";
	$res_col = mysqli_query($link, $sql_col);
	
	while ($col=mysqli_fetch_assoc($res_col)) {
		$array_end[] = array(
			'coluna' => $col['coluna'],
		);
	}
	
	echo(json_encode($array_end));
$link->close();
?>