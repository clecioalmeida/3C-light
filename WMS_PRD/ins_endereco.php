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

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}

?>
<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_galpao = $_POST['cod_galpao'];
$rua_ini 	= $_POST['rua_ini'];
$rua_fim 	= $_POST['rua_fim'];
$col_ini 	= $_POST['col_ini'];
$col_fin 	= $_POST['col_fin'];
$alt_ini 	= $_POST['alt_ini'];
$alt_fin 	= $_POST['alt_fin'];
$ds_pre 	= $_POST['ds_pre'];
$ds_pos 	= $_POST['ds_pos'];
//$nr_nivel 	= $_POST['nr_nivel'];
$ds_posni 	= $_POST['ds_posni'];
$ds_posnf 	= $_POST['ds_posnf'];
$ds_pren 	= $_POST['ds_pren'];
$ds_tipo 	= $_POST['ds_tipo'];

for ($i=$rua_ini; $i <= $rua_fim; $i++) {

	for ($j=$col_ini; $j <= $col_fin; $j++) {

		for ($a=$alt_ini; $a <= $alt_fin; $a++) { 

			for ($c=$ds_posni; $c <= $ds_posnf; $c++) {

				$sql = "insert into tb_endereco (galpao, rua, coluna, altura, fl_status, usr_create, dt_create) values ('$cod_galpao', '".$i."', '".$ds_pre.$j.$ds_pos."',  '".$ds_pren.$a.$c."', 'A', '1', '$data_atual')";
				$resultado_id = mysqli_query($link, $sql);

				if(mysqli_affected_rows($link) > 0){

					$nRec = mysqli_insert_id($link);

					echo 'Novo ID: '.$nRec.'- Rua: '.$i.'- Coluna: '.$ds_pre.$j.$ds_pos.' Nivel: '.$ds_pren.$a.$c.'<br>';

				}else{

					echo "Nao funcionou!";

				}
			}

		}

	}

}

$link->close();
?>