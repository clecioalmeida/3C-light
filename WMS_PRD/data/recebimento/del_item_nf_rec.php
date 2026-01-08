<?php
require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_nf = $_POST["del_nfrec"];

$sql_nf = "update tb_nf_entrada set fl_status = 'E' WHERE cod_nf_entrada = '$cod_nf'";
$res_nf = mysqli_query($link, $sql_nf);

if(mysqli_affected_rows($link) > 0){

	$sql_item="update tb_nf_entrada_item set fl_status = 'E' WHERE cod_nf_entrada = '$cod_nf'";
	$res_item = mysqli_query($link, $sql_item);

	if(mysqli_affected_rows($link) > 0){
		$array_conf = array(
			'info' => "A nota fiscal e seus itens foram deletados!",
		);

		echo(json_encode($array_conf));
	}else{

		$array_conf = array(
			'info' => "Ocorreu um erron na exclusão dos itens das notas fiscais!",
		);

		echo(json_encode($array_conf));
	}
	
}else{

	$array_conf = array(
		'info' => "Ocorreu um erron na exclusão da nota fiscal!",
	);

	echo(json_encode($array_conf));

}

$link->close();

?>