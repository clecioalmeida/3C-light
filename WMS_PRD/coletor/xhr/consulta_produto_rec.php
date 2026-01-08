<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_prod = $_REQUEST['cod_prd'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql_parte = "select nm_produto from tb_produto where cod_prod_cliente = '$cod_prod' group by cod_prod_cliente";
$res_parte = mysqli_query($link, $sql_parte);

if(mysqli_num_rows($res_parte) > 0){
	
	$parte=mysqli_fetch_assoc($res_parte);

	$retorno = array(
		'info'	=> "<h3 style='background-color:#00FA9A;'>PRODUTO: <strong>".$parte['nm_produto']."</strong></h3>",
	);

}else{

	$retorno = array(
		'info'	=> "<h3 style='background-color:#FF6347;'>PRODUTO: <strong>".$cod_prod." não encontrado.</strong></h3>",
	);

}

echo(json_encode($retorno));


$link->close();
?>