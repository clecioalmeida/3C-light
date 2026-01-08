<?php
require_once "bd_class.php";

$cod_nf_entrada = $_POST['id_nf'];
$nr_fisc_ent 	= $_POST['nr_fisc_ent'];
$dt_emis_ent 	= $_POST['dt_emis_ent'];
$nr_cfop_ent 	= $_POST['nr_cfop_ent'];
$qtd_vol_ent 	= $_POST['qtd_vol_ent'];
$nr_peso_ent 	= $_POST['nr_peso_ent'];
$tp_vol_ent 	= $_POST['tp_vol_ent'];
$vl_tot_nf_ent 	=str_replace(',', '.', str_replace('.', '', $_POST['vl_tot_nf_ent']));
$base_icms_ent 	= $_POST['base_icms_ent'];
$vl_icms_ent 	= str_replace(',', '.', str_replace('.', '', $_POST['vl_icms_ent']));
$chavenfe 		= $_POST['chavenfe'];
$ds_obs_nf 		= $_POST['ds_obs_nf'];

$objDb = new db();
$link = $objDb->conecta_mysql();

if ($dt_emis_ent == "" || $qtd_vol_ent == "" || $nr_peso_ent == "" || $tp_vol_ent == "" || $vl_tot_nf_ent == "") {

	$retorno[] = array(
		'info' => "2",
	);

	echo (json_encode($retorno));

} else {

	$sql = "update tb_nf_entrada set nr_fisc_ent = '$nr_fisc_ent', dt_emis_ent = '$dt_emis_ent', nr_cfop_ent = '$nr_cfop_ent', qtd_vol_ent = '$qtd_vol_ent', nr_peso_ent = '$nr_peso_ent', tp_vol_ent = '$tp_vol_ent', vl_tot_nf_ent = '$vl_tot_nf_ent', base_icms_ent = '$base_icms_ent', vl_icms_ent = '$vl_icms_ent', chavenfe = '$chavenfe', ds_obs_nf = '$ds_obs_nf' WHERE cod_nf_entrada = '$cod_nf_entrada'" or die(mysqli_error($sql));

	$resultado_id = mysqli_query($link, $sql);

	if (mysqli_affected_rows($link) > 0) {

		$retorno[] = array(
			'info' => "0",
		);

		echo (json_encode($retorno));

	} else {

		$retorno[] = array(
			'info' => "1",
		);

		echo (json_encode($retorno));
	}

}

$link->close();
?>