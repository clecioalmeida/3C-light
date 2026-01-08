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

$cod_rec 		= $_POST['cod_rec'];
$nr_fisc_ent 	= $_POST['nr_fisc_ent'];
$dt_emis_ent 	= $_POST['dt_emis_ent'];
$nr_cfop_ent	= $_POST['nr_cfop_ent'];
$tp_vol_ent 	= $_POST['tp_vol_ent'];
$qtd_vol_ent 	= $_POST['qtd_vol_ent'];
$nr_peso_ent 	= $_POST['nr_peso_ent'];
$id_rem 		= $_POST['id_emitente'];
$id_dest 		= $_POST['id_destinatario'];
$vl_tot_nf_ent 	= str_replace(',', '', $_POST['vl_tot_nf_ent']);
$vl_icms_ent 	= str_replace(',', '', $_POST['vl_icms_ent']);
$chavenfe 		= $_POST['nfe_chave'];
$ds_obs_nf 		= $_POST['ds_obs_nf'];

$sql_nf = "insert into tb_nf_entrada (cod_ag, id_rem, id_dest,  nr_fisc_ent, dt_emis_ent, nr_cfop_ent, qtd_vol_ent, nr_peso_ent, tp_vol_ent, vl_tot_nf_ent, vl_icms_ent, chavenfe, ds_obs_nf, fl_status, usr_create, dt_create) values ('$cod_rec', '$id_rem', '$cod_cli', '$nr_fisc_ent', '$dt_emis_ent', '$nr_cfop_ent', '$qtd_vol_ent', '$nr_peso_ent', '$tp_vol_ent', '$vl_tot_nf_ent', '$vl_icms_ent', '$chavenfe', '$ds_obs_nf', 'A', '$id', '$date')";
$res_nf = mysqli_query($link, $sql_nf);

if ($res_nf) {

	echo "Nota fiscal inserida com sucesso!";

	/*$retorno[] = array(
		'info' => "0",
	);

	echo (json_encode($retorno));*/

} else {

	echo "Erro no cadastro!";

	/*$retorno[] = array(
		'info' => "1",
	);

	echo (json_encode($retorno));*/

}

$link->close();
?>