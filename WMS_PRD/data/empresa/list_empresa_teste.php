<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
//$id_empresa = mysqli_real_escape_string($link, $_POST["dtl_empresa"]);

$sql = "select * from tb_empresa where fl_status = 1"; 
$res = mysqli_query($link,$sql); 
	
while ($empresa=mysqli_fetch_assoc($res)) {
	$array_empresa[] = array(
		'cod_empresa'	=> $empresa['cod_empresa'],
		'nm_empresa' => $empresa['nm_empresa'],
		'nr_cnpj' => $empresa['nr_cnpj'],
		//'ds_descricao' => $parte['ds_descricao'],
	);
}

echo(json_encode($array_empresa));

$link->close();
?>