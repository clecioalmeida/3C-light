<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_REQUEST['id_inv'];
$id_rua = $_REQUEST['id_rua'];
$id_col = $_REQUEST['id_col'];

$sql_parte = "select distinct id_altura from tb_inv_tarefa where id_inv = '$id_inv' and id_rua = '$id_rua' and id_coluna = '$id_col' order by id_rua";
$res_parte = mysqli_query($link, $sql_parte);

while ($parte=mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		'id_altura' => $parte['id_altura'],
	);
}	

echo(json_encode($array_parte));
$link->close();
?>