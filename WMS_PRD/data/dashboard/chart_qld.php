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

$sql="select * from tb_fc_qld where fl_empresa = '$cod_cli' and fl_status = 'A' order by ds_data asc";
$res = mysqli_query($link, $sql);
while ($qld = mysqli_fetch_assoc($res)) {

	$array_qld[] = array(
		'id' 			=> $qld['id'],
		'ds_data' 		=> $qld['ds_data'],
		'nr_sku_blq' 	=> $qld['nr_sku_blq'],
		'vlr_sku_blq' 	=> $qld['vlr_sku_blq'],
		'nr_est_qld' 	=> $qld['nr_est_qld'],
		'vlr_est_qld' 	=> $qld['vlr_est_qld'],
	);
}
$link->close();
?>