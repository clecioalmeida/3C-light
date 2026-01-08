<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$novo_pedido 			= $_POST['novo_pedido'];
$nr_qtde 				= $_POST['nr_qtde'];
$cod_prod_cliente 		= $_POST['cod_prod_cliente'];

$sql_prod = "select cod_produto from tb_produto where cod_prod_cliente = '$cod_prod_cliente'";
$res_prod = mysqli_query($link, $sql_prod) or die(mysqli_error($link));
while ($produto=mysqli_fetch_assoc($res_prod)) {
	$cod_produto=$produto['cod_produto'];
}

if(isset($cod_produto)){

	$ins_item = "insert into tb_pedido_coleta_produto (nr_pedido, produto, nr_qtde, fl_status, usr_create, dt_create) values ('$novo_pedido', '$cod_produto', '$nr_qtde', 'A', 2, now())";
	$res_item = mysqli_query($link, $ins_item);

	if(mysqli_affected_rows($link)){

		$retorno[] = array(
			'info'	=> "0",
		);

	}else{

		$retorno[] = array(
			'info'		=> "1",
			'produto' 	=> $cod_prod_cliente,
		);

	}

}else{

	$retorno[] = array(
		'info'	=> "2",
	);

}

echo(json_encode($retorno));
$link->close();
?>