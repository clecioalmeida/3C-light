<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$nr_pedido = $_POST['fin_col'];

$query_st = "SELECT fl_status
from tb_pedido_coleta
where nr_pedido = '$nr_pedido'";
$res_st = mysqli_query($link, $query_st);

while ($status = mysqli_fetch_assoc($res_st)) {
	$fl_status 		= $status['fl_status'];

	if($fl_status == 'F'){

		$retorno[] = array(
			'info' => "2",
		);

		echo (json_encode($retorno));

		exit();

	}else{

		$query_cod = "SELECT t1.cod_estoque, t3.nr_qtde as nr_qtde_col, round(t2.nr_qtde,0) as nr_qtde, t1.fl_status
		from tb_coleta_pedido t1
		left join tb_posicao_pallet t2 on t1.cod_estoque = t2.cod_estoque
		left join tb_pedido_conferencia t3 on t1.cod_col = t3.cod_col
		where t1.nr_pedido = '$nr_pedido'";
		$res_col = mysqli_query($link, $query_cod);

		while ($parte = mysqli_fetch_assoc($res_col)) {
			$cod_estoque 	= $parte['cod_estoque'];
			$nr_qtde_col 	= $parte['nr_qtde_col'];
			$nr_qtde 		= $parte['nr_qtde'];
			$qtde 			= $nr_qtde - $nr_qtde_col;

			if($qtde >= 0){

				$sql_saldo = "UPDATE tb_posicao_pallet set nr_qtde = '$qtde', nr_qtde_ant = '$nr_qtde', nr_pedido_ant = '$nr_pedido', user_update = '$id', dt_update = '$date' where cod_estoque = '$cod_estoque'";
				$saldo = mysqli_query($link1, $sql_saldo);

				$sql_col = "update tb_coleta_pedido set fl_status = 'F' where cod_estoque = '$cod_estoque'";
				$col = mysqli_query($link, $sql_col);

				$sql_prd = "update tb_pedido_coleta_produto set usr_fim_coleta = '$id', dt_fim_coleta = '$date', fl_status = 'F' where nr_pedido = '$nr_pedido'";
				$prd = mysqli_query($link1, $sql_prd);

				$sql_ped = "update tb_pedido_coleta set fl_status = 'F' where nr_pedido = '$nr_pedido'";
				$ped = mysqli_query($link1, $sql_ped);

				$ins_lg = "insert into tb_log_produto (cod_item, ds_ref, id_ref, ds_rotina, vlr_novo, vlr_ant, ds_obs, usr_create, dt_create) values ('$cod_estoque', 'PEDIDO', '$nr_pedido', 'EXPEDIÇÃO', '$qtde', '$nr_qtde', 'SALDO BAIXADO', '$id', '$date')";
				$res_LG = mysqli_query($link,$ins_lg);


			}else{

				/*$sql_saldo = "update tb_posicao_pallet set nr_qtde = '0', nr_qtde_ant = '$nr_qtde', nr_pedido_ant = '$nr_pedido', user_update = '$id', dt_update = '$date' where cod_estoque = '$cod_estoque'";
				$saldo = mysqli_query($link1, $sql_saldo);

				$sql_col = "update tb_coleta_pedido set fl_status = 'F' where cod_estoque = '$cod_estoque'";
				$col = mysqli_query($link, $sql_col);

				$sql_prd = "update tb_pedido_coleta_produto set usr_fim_coleta = '$id', dt_fim_coleta = '$date', fl_status = 'F' where nr_pedido = '$nr_pedido'";
				$prd = mysqli_query($link1, $sql_prd);

				$sql_ped = "update tb_pedido_coleta set fl_status = 'F' where nr_pedido = '$nr_pedido'";
				$ped = mysqli_query($link1, $sql_ped);*/

				$ins_lg = "insert into tb_log_produto (cod_item, ds_ref, id_ref, ds_rotina, vlr_novo, vlr_ant, ds_obs, usr_create, dt_create) values ('$cod_estoque', 'PEDIDO', '$nr_pedido', 'EXPEDIÇÃO', '$qtde', '$nr_qtde', 'SALDO DIVERGENTE', '$id', '$date')";
				$res_LG = mysqli_query($link,$ins_lg);

			}

		}

	}

}

$query_st2 = "select count(fl_status) as status
from tb_pedido_coleta_produto
where nr_pedido = '$nr_pedido' and fl_status <> 'F'";
$res_st2 = mysqli_query($link, $query_st2);
$status2 = mysqli_fetch_assoc($res_st2);
	
	if($status2['status'] == '0'){

		$retorno[] = array(
			'info' => "0",
		);

		echo (json_encode($retorno));

	}else{

		$retorno[] = array(
			'info' => "1",
		);

		echo (json_encode($retorno));

	}

$link->close();
?>