<?php 
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select * from tb_log_inv";
$res = mysqli_query($link, $sql);
while ($parte = mysqli_fetch_assoc($res)) {

	$array_parte[] = array(
		'dt_inv' 	=> $parte['dt_inv'],
		'nr_ac_qtd' => $parte['nr_ac_qtd'],
		'nr_ac_end' => $parte['nr_ac_end'],
	);

}

$link->close();
?>
