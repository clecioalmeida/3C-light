<?php
require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$cod_produto 		= $_POST['cod_produto'];
$novo_pedido 		= $_POST['novo_pedido'];
$nr_qtde 			= $_POST['nr_qtd'];
$cod_estoque 		= $_POST['cod_est'];


$sql_atualiza = "select nr_qtde from tb_posicao_pallet where cod_estoque = '$cod_estoque' and produto = '$cod_produto'";
$res_atualiza = mysqli_query($link, $sql_atualiza) or die(mysqli_error($link));
while ($atualiza=mysqli_fetch_assoc($res_atualiza)) {
	$qtde_ant=$atualiza['nr_qtde'];
	$saldo=$qtde_ant-$nr_qtde;

	$sql_saldo = "update tb_posicao_pallet set nr_qtde = '$saldo', nr_qtde_ant = '$qtde_ant', nr_pedido_ant = '$novo_pedido', user_update = 2, dt_update = now() where cod_estoque = '$cod_estoque'";
	$res_saldo = mysqli_query($link, $sql_saldo);

	if(mysqli_affected_rows($link)){

		$sql_ped = "update tb_pedido_coleta set fl_status = 'F' where nr_pedido = '$novo_pedido'";
		$ped = mysqli_query($link1, $sql_ped);

		$sql_prd = "update tb_pedido_coleta_produto set usr_fim_coleta = 2, dt_fim_coleta = now(), fl_status = 'F' where nr_pedido = '$novo_pedido'";
		$prd = mysqli_query($link1, $sql_prd);

		$sql_col = "update tb_coleta_pedido set fl_status = 'F' where cod_estoque = '$cod_estoque'";
		$col = mysqli_query($link, $sql_col);

		if(mysqli_affected_rows($link)){

			$retorno[] = array(
				'info'	=> "0",
			);

		}else{

			$retorno[] = array(
				'info'	=> "1",
			);

		}		

	}else{

		$retorno[] = array(
			'info'	=> "2",
		);

	}

	echo(json_encode($retorno));
}


$link->close();
?>