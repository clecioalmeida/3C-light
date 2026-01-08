<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../index.php");
	exit;

} else {

	$id_user 	= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$data_atual = date('c');

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$ds_galpao 	= $_POST['ds_galpao'];
$ds_nome 	= $_POST['ds_nome'];
$ds_apelido = $_POST['ds_apelido'];
$fl_curva 	= $_POST['fl_curva'];
$fl_tipo 	= $_POST['fl_tipo'];
$fl_aloc 	= $_POST['fl_aloc'];

if($ds_galpao == "" || $ds_nome == "" || $ds_apelido == ""){

	echo "Por favor preencha todos os campos.";

}else{

	$sql = "insert into tb_armazem (nome, ds_apelido, fl_situacao, fl_curva, fl_tipo, galpao, aloc_aut, id_oper, usr_create, dt_create) values ('$ds_nome', '$ds_apelido', 'A', '$fl_curva', '$fl_tipo', '$ds_galpao','$fl_aloc','$cod_cli','$id_user', '$data_atual')";
	$resultado_id = mysqli_query($link, $sql);

	if(mysqli_affected_rows($link) > 0){

		$nRec = mysqli_insert_id($link);

		echo 'Armazém '.$ds_nome.' criado com sucesso';

	}else{

		echo "Ocorreu um erro!";

	}

}

$link->close();
?>