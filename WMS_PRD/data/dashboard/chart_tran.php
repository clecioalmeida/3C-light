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

$sql="select id, date_format(ds_data,'%m/%Y') as ds_data, concat(nr_prazo,'%') as nr_prazo,  concat(nr_atraso,'%') as nr_atraso from tb_fc_tran where fl_empresa = '$cod_cli' and fl_status = 'A' order by ds_data asc";
$res = mysqli_query($link, $sql);
while ($qld = mysqli_fetch_assoc($res)) {

	$array_qld[] = array(
		'id' 			=> $qld['id'],
		'ds_data' 		=> $qld['ds_data'],
		'nr_prazo' 		=> $qld['nr_prazo'],
		'nr_atraso' 	=> $qld['nr_atraso'],
	);
}
$link->close();
?>