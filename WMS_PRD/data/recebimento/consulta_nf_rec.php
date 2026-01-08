<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec = $_POST['cod_rec'];
$nr_fisc_ent = $_POST['nr_fisc_ent'];

$query_nf_rec = "select nr_fisc_ent from tb_nf_entrada where nr_fisc_ent = '$nr_fisc_ent' and cod_rec = '$cod_rec'";
$res_rec = mysqli_query($link, $query_nf_rec);
$tr = mysqli_num_rows($res_rec);

if ($tr == 0) {

	$retorno[] = array(
		'info' => "0",
	);

	echo (json_encode($retorno));

	exit();

} else {

	$retorno[] = array(
		'info' => "1",
	);

	echo (json_encode($retorno));

	exit();
}
$link->close();
?>