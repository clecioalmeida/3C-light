<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$barcode = $_POST['barcode'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql_parte = "select distinct nm_produto from tb_produto where cod_prod_cliente = '$barcode'";
$res_parte = mysqli_query($link, $sql_parte);

if(mysqli_num_rows($res_parte) > 0){
	
	$parte=mysqli_fetch_assoc($res_parte);

	$retorno = array(
		'info'	=> "<h3 style='background-color:#90EE90'>PRODUTO: ".$parte['nm_produto']." - ".$barcode."</h3>",
	);

}else{

	$retorno = array(
		'info'	=> "<h3 style='background-color:#F08080'>PRODUTO: ".$barcode." não encontrado.</h3>",
	);

}

echo(json_encode($retorno));


$link->close();
?>