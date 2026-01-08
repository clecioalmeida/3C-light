<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$novo_pedido = $_POST['novo_pedido'];
$cod_prod_cliente = $_POST['cod_prod_cliente'];
$nr_qtde = $_POST['nr_qtde'];
$id_galpao = $_POST['id_galpao'];
$ds_prateleira = $_POST['ds_prateleira'];
$dt_pedido = $_POST['dt_pedido'];
$ds_coluna = $_POST['ds_coluna'];
$ds_altura = $_POST['ds_altura'];
$cod_estoque = $_POST['cod_estoque'];

$sql_prod = "select cod_produto from tb_produto where cod_prod_cliente = '$cod_prod_cliente' and fl_status = 'A'";
$res_prod = mysqli_query($link, $sql_prod) or die(mysqli_error($link));
while ($produto=mysqli_fetch_assoc($res_prod)) {
	$cod_produto=$produto['cod_produto'];

	if($cod_produto != ''){

		$ins_item = "insert into tb_pedido_coleta_produto (nr_pedido, produto, nr_qtde, nr_qtde_conf, fl_status, usr_create, dt_create) values ('$novo_pedido', '$cod_produto', '$nr_qtde', '$nr_qtde', 'A', 2, now())";
		$res_item = mysqli_query($link, $ins_item);

		if(mysqli_affected_rows($link)){

			$retorno[] = array(
				'info'			=> "0",
				'cod_produto'	=> $cod_produto,
				'cod_prod_cliente'	=> $cod_prod_cliente,
				'cod_est'	=> $cod_estoque,
				'nr_qtde'	=> $nr_qtde,
				'id_galpao'	=> $id_galpao,
				'ds_prateleira'	=> $ds_prateleira,
				'ds_coluna'	=> $ds_coluna,
				'ds_altura'	=> $ds_altura,
			);

			echo(json_encode($retorno));

		}else{

			$retorno[] = array(
				'info'		=> "1",
			);

			echo(json_encode($retorno));

		}

	}else{

		$retorno[] = array(
			'info'	=> "Produto não encontrado.",
		);

		echo(json_encode($retorno));
	}
	
}

$link->close();
?>