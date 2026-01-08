<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_prod_cliente 		= $_POST['cod_prod_cliente'];

$sql_prod = "select cod_produto from tb_produto where cod_prod_cliente = '$cod_prod_cliente' and fl_status = 'A'";
$res_prod = mysqli_query($link, $sql_prod) or die(mysqli_error($link));
while ($produto=mysqli_fetch_assoc($res_prod)) {
	$cod_produto=$produto['cod_produto'];

	if($cod_produto != ''){

		$retorno[] = array(
			'cod_produto'		=> $cod_produto,
			'cod_prod_cliente'	=> $cod_prod_cliente,
		);

	}else{

		$retorno[] = array(
			'cod_produto'	=> "Produto não encontrado.",
		);

	}
	
}

echo(json_encode($retorno));
$link->close();
?>