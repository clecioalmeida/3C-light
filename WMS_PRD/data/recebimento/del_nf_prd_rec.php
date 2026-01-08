<?php
require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$del_prd = $_POST["del_prd"];

$sql = "update tb_nf_entrada_item set fl_status = 'E' WHERE cod_nf_entrada_item = '$del_prd'";
$res_sql = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){
	$array_conf = array(
		'info' => "Produto deletado da Nota fiscal.",
	);

	echo(json_encode($array_conf));
}else{

	$array_conf = array(
		'info' => "Não foi possível excluir o produto.",
	);

	echo(json_encode($array_conf));

}

$link->close();
?>