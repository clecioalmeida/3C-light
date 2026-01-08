<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
$data_atual = date('c');
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$nm_gal 	= $_POST['nm_gal'];
$cid_gal 	= $_POST['cid_gal'];
$apel_gal 	= $_POST['apel_gal'];

$sql = "insert into tb_galpao (g_cidade, galpao, ds_apelido, fl_status, fl_empresa, usr_create, dt_create) values ('$cid_gal', '$nm_gal', '$apel_gal', 'A', '$cod_cli', '$id', '$data_atual')";
$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {

	echo "Galpão criado com sucesso.";

} else {

	echo "Erro no cadastro.";

}

/*foreach ($workdays as $key=>$value) {

	$dt_agenda = date('Y-m-d', strtotime($value));

	foreach ($janela as $key1 => $value1) {

		foreach ($fl_empresa as $key2 => $value2) {

			$sql = "insert into tb_janela (dt_janela, ds_janela, fl_status, fl_tipo, fl_empresa, usr_create, dt_create) values ('$value', '$value1', 'A', 'N', '$value2', '1', '$data')";
			$resultado_id = mysqli_query($link, $sql);
			$nRec = mysqli_insert_id($link);

			echo $nRec." - ".$dt_agenda." - ".$value1." - ".$value2."<br>";
		}
	}
}*/
$link->close();
?>