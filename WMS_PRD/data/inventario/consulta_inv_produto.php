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

	$id_parte = $_REQUEST['id_parte'];
	
	$sql_col = "select cod_produto, nm_produto
				from tb_produto
				where cod_prod_cliente = '$id_parte' and fl_empresa = '$cod_cli'";
	$res_col = mysqli_query($link, $sql_col);

	if(mysqli_num_rows($res_col) == 0){
			$array_end[] = array(
				'erro' => "Produto não encontrado!",
				'nm_produto' 	=> "Produto não encontrado!",
				'cod_produto' 	=> "",
			);
		echo(json_encode($array_end));

	} else {

		while ($col=mysqli_fetch_assoc($res_col)) {
			$array_end[] = array(
				'nm_produto' 	=> $col['nm_produto'],
				'cod_produto' 	=> $col['cod_produto'],
			);
		}
		echo(json_encode($array_end));

	}

$link->close();
?>