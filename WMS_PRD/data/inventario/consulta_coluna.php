<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_REQUEST['id_inv'];
$id_rua = $_REQUEST['id_rua'];

$sql_col = "select distinct id_coluna from tb_inv_tarefa where id_inv = '$id_inv' and id_rua = '$id_rua' order by id_rua";
$res_col = mysqli_query($link, $sql_col);

while ($col=mysqli_fetch_assoc($res_col)) {
	$array_end[] = array(
		'id_coluna' => $col['id_coluna'],
	);
}



echo(json_encode($array_end));
$link->close();
?>