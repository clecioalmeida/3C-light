<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$novo_pedido 		= $_POST['novo_pedido'];
$cod_prod_cliente 	= $_POST['cod_prod_cliente'];
$nr_qtde 			= $_POST['nr_qtd'];
$ds_prateleira 		= $_POST['ds_prat'];
$dt_pedido 			= $_POST['dt_pedido'];
$ds_coluna 			= $_POST['ds_col'];
$ds_altura 			= $_POST['ds_alt'];
$id_galpao 			= $_POST['id_galp'];
$cod_estoque 		= $_POST['cod_est'];

$sql_prod = "select cod_produto from tb_produto where cod_prod_cliente = '$cod_prod_cliente' and fl_status = 'A'";
$res_prod = mysqli_query($link, $sql_prod) or die(mysqli_error($link));
while ($produto=mysqli_fetch_assoc($res_prod)) {
	$cod_produto=$produto['cod_produto'];

	if($cod_produto != ''){

		$ins_conf = "insert into tb_coleta_pedido (nr_pedido, produto, ds_galpao, ds_prateleira, ds_coluna, ds_altura, nr_qtde_col, nr_qtde_conf, usr_create, dt_create, fl_status, cod_estoque) values('$novo_pedido', '$cod_produto', '$id_galpao', '$ds_prateleira', '$ds_coluna', '$ds_altura', '$nr_qtde', '$nr_qtde', 2, now(), 'F', '$cod_estoque')";
		$res_conf = mysqli_query($link, $ins_conf) or die(mysqli_error($link));

		if(mysqli_affected_rows($link)){

			$retorno[] = array(
				'info'			=> "0",
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