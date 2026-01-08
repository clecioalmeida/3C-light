<?php
require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$del_serie_prd = $_POST["del_serie_prd"];

$sql = "UPDATE tb_nserie set fl_status = 'E' WHERE n_serie = '$del_serie_prd'";
$res_sql = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) > 0){
	$array_conf = array(
		'info' => "Numero de serial deletado com sucesso.",
	);

	echo(json_encode($array_conf));
}else{

	$array_conf = array(
		'info' => "Nao foi possivel excluir o serial.",
	);

	echo(json_encode($array_conf));

}

$link->close();
?>