<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$nr_pedido 	= mysqli_real_escape_string($link, $_POST['pedido']);
$barcode 	= mysqli_real_escape_string($link, $_POST['barcode']);
$serial_exp = mysqli_real_escape_string($link, $_POST['serial_exp']);
$nr_qtde 	= mysqli_real_escape_string($link, $_POST['nr_qtde']);

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$query_prd = "select cod_ped, produto from tb_coleta_pedido where nr_pedido = '$nr_pedido' and produto = '$barcode' limit 1";
$res_prd = mysqli_query($link, $query_prd);

if(mysqli_num_rows($res_prd) > 0){


	$dados_prd = mysqli_fetch_assoc($res_prd);
	$cod_pedido = $dados_prd['cod_ped'];

	$query_init = "select coalesce(nr_qtde_exp,0) as nr_qtde_exp, nr_qtde from tb_pedido_coleta_produto where cod_ped = '$cod_pedido'";
	$res_init = mysqli_query($link, $query_init);
	while ($init = mysqli_fetch_assoc($res_init)) {
		$count = $init['nr_qtde_exp'];
		$total = $init['nr_qtde'];
	}

	if ($count < $total) {

		$qtde = $nr_qtde+$count;

		$insert_barcode = "update tb_pedido_coleta_produto set nr_qtde_exp = '$qtde', usr_conf_exp = '$id', dt_conf_exp = '$date' where cod_ped = '$cod_pedido'";
		$res_barcode = mysqli_query($link, $insert_barcode);


		if ($res_barcode) {

			$query_conf = "select coalesce(sum(nr_qtde_exp),0) as nr_qtde_exp from tb_pedido_coleta_produto where nr_pedido = '$nr_pedido'";
			$res_conf = mysqli_query($link, $query_conf);
			$tr_conf = mysqli_num_rows($res_conf);

			while ($conf = mysqli_fetch_assoc($res_conf)) {

				$array_estoque = array(

					'info' => "Quantidade conferida!",

				);

			}

			echo (json_encode($array_estoque));

		}else{

			$array_estoque = array(

				'info' => "Erro ao alterar pedido!",

			);

			echo (json_encode($array_estoque));

		}

	} else {

		$array_estoque = array(

			'info' => "Todos os itens desse produto foram conferidos!",
		);

		echo (json_encode($array_estoque));

		exit();

	}

}else{

	$array_estoque = array(

		'info' => "Produto não faz parte do pedido!",
	);

	echo (json_encode($array_estoque));

	exit();

}


$link->close();
?>