<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_REQUEST['id_inv'];

$sql_rua_inv = "SELECT distinct(t2.rua), t1.id_galpao
FROM tb_inv_prog t1
left join tb_endereco t2 on t1.id_galpao = t2.galpao
where t1.id = '$id_inv'";
$res_rua = mysqli_query($link, $sql_rua_inv);

while ($rua=mysqli_fetch_assoc($res_rua)) {
	$array_rua[] = array(
		'rua' => $rua['rua'],
	);
}

echo(json_encode($array_rua));
$link->close();
?>