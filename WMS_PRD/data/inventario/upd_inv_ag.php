<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id = $_SESSION["id"];
}

?>
<?php

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once('bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

if(isset($_POST['id_inv'])){

	$id_galpao        = $_POST['progInvGlp'];
	$dt_inicio        = $_POST['dt_inicio'];
	$dt_fim           = $_POST['dt_fim'];
	$id_rua_inicio    = $_POST['id_rua_inicio'];
	$id_coluna_inicio = $_POST['id_coluna_inicio'];
	$id_altura_inicio = $_POST['id_altura_inicio'];
	$id_rua_fim       = $_POST['id_rua_fim'];
	$id_coluna_fim    = $_POST['id_coluna_fim'];
	$id_altura_fim    = $_POST['id_altura_fim'];
	//$tipo_inv         = $_POST['tipo_inv'];
	$ds_tipo          = $_POST['ds_tipo'];
	$id_produto       = $_POST['id_produto'];
	$id_grupo         = $_POST['id_grupo'];
	$id_sub_grupo     = $_POST['id_sub_grupo'];
	//$nome             = $_POST['nome'];
	$id_inv           = $_POST['id_inv'];

	$upd_tarefa = "update tb_inv_prog set 
	id_galpao 			='$id_galpao', 
	dt_inicio 			= '$dt_inicio', 
	dt_fim 				= '$dt_fim', 
	id_rua_inicio 		= '$id_rua_inicio', 
	id_coluna_inicio 	= '$id_coluna_inicio', 
	id_altura_inicio 	= '$id_altura_inicio', 
	id_rua_fim 			= '$id_rua_fim', 
	id_coluna_fim 		= '$id_coluna_fim', 
	id_altura_fim 		= '$id_altura_fim', 
	ds_tipo 			= '$ds_tipo', 
	id_produto 			= '$id_produto', 
	id_grupo 			= '$id_grupo', 
	id_sub_grupo 		= '$id_sub_grupo', 
	usr_update 			= '$id', 
	dt_update 			= now() 
	where id = '$id_inv'";
	$res_tarefa = mysqli_query($link, $upd_tarefa);

	if(mysqli_affected_rows($link) > 0){

		echo "Inventário alterado com sucesso.";

	}else{

		echo "Erro na alteração do inventário.";

	}


}else{

	echo "Inventário não localizado.";

}

$link->close();
?>