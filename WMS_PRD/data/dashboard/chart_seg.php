<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:index.php");
    exit;

} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}

?>
<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

/* SEGURANÇA */

$sql="select * from tb_fc_seg where fl_empresa = '$cod_cli' and fl_status = 'A' order by ds_data asc";
$res = mysqli_query($link, $sql);
while ($seg = mysqli_fetch_assoc($res)) {

	$array_seg[] = array(
		'id' 			=> $seg['id'],
		'ds_data' 		=> $seg['ds_data'],
		'qtd_ipal_prev' => $seg['qtd_ipal_prev'],
		'qtd_ipal_exe' 	=> $seg['qtd_ipal_exe'],
		'nr_irreg_seg' 	=> $seg['nr_irreg_seg'],
		'nr_acd_fat' 	=> $seg['nr_acd_fat'],
	);
}
$link->close();
?>