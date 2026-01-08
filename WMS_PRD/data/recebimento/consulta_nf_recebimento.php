<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec = $_POST['cod_rec'];

$query_nf_rec = "select * from tb_nf_entrada where cod_rec = '$cod_rec'";
$res_rec = mysqli_query($link, $query_nf_rec);
$tr = mysqli_num_rows($res_rec);

if ($tr == 0) {
	while ($dados=mysqli_fetch_assoc($res_rec)) {
		
		$retorno[] = array(
			'info' => "0",
			'cod_nf_entrada' => $dados['cod_nf_entrada'],
			'nr_fisc_ent' => $dados['nr_fisc_ent'],
			'dt_emis_ent' => $dados['dt_emis_ent'],
			'nr_cfop_ent' => $dados['nr_cfop_ent'],
			'cod_nf_entrada' => $dados['cod_nf_entrada'],
			'cod_nf_entrada' => $dados['cod_nf_entrada'],
			'cod_nf_entrada' => $dados['cod_nf_entrada'],
			'cod_nf_entrada' => $dados['cod_nf_entrada'],
			'cod_nf_entrada' => $dados['cod_nf_entrada'],
		);
	}

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