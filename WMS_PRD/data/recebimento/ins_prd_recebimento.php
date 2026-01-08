<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli  	= $_SESSION['cod_cli'];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$cod_nf_entrada 	= $_POST['cod_nf_entrada'];
$cod_produto 		= $_POST['cod_produto'];
$nm_produto 		= $_POST['nm_produto'];
$estado_produto 	= $_POST['estado_produto'];
$ds_unid			= $_POST['ds_unid'];
$nr_qtde 			= $_POST['nr_qtde'];
$nr_peso_unit 		= $_POST['nr_peso_unit'];
$nr_ean 			= $_POST['nr_ean'];
$vl_unit 			= str_replace(',', '', $_POST['vl_unit']);
$id_dest 			= $_POST['ds_obs_nf'];
$cod_rec 			= $_POST['cod_rec'];

$sql_nf = "insert into tb_nf_entrada_item (cod_nf_entrada, cod_rec, fl_status, fl_imp, estado_produto, produto, nr_qtde, vl_unit, ds_unid, nr_ean, nr_peso_unit, user_rec, dt_rec) values ('".$cod_nf_entrada."', '".$cod_rec."', 'A', 'N', '".$estado_produto."', '".$cod_produto."', '".$nr_qtde."', '".$vl_unit."', '".$ds_unid."', '".$nr_ean."', '".$nr_peso_unit."', '".$id."', '".$date."')";
$res_nf = mysqli_query($link, $sql_nf);

if ($res_nf) {

	echo "Produto inserido com sucesso!";

} else {

	echo "Erro no cadastro!";

}

$link->close();
?>