<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();
$link2 = $objDb->conecta_mysql();

$sql = "select nr_pedido, fl_status from tb_pedido_coleta where date(dt_create) = '2020-11-03' and usr_create = '99'";
$res = mysqli_query($link, $sql) or die(mysqli_error($link));
while ($dados_nf=mysqli_fetch_assoc($res)) {

	$nr_pedido 	= $dados_nf['nr_pedido'];

	$fl_status 	= $dados_nf['fl_status'];

	if($fl_status == 'F'){

		echo "Pedido já finalizado.<br>";

	}else{

		$query_cod = "select t1.cod_estoque, t3.nr_qtde as nr_qtde_col, round(t2.nr_qtde,0) as nr_qtde, t1.fl_status
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

				echo "nr_pedido ".$nr_pedido." cod_estoque ".$cod_estoque." nr_qtde_col ".$nr_qtde_col." nr_qtde ".$nr_qtde." qtde ".$qtde."<br>";

					$sql_saldo = "update tb_posicao_pallet set nr_qtde = '$qtde', nr_qtde_ant = '$nr_qtde', nr_pedido_ant = '$nr_pedido', user_update = '99', dt_update = '$date' where cod_estoque = '$cod_estoque'";
					$saldo = mysqli_query($link1, $sql_saldo);

					$sql_col = "update tb_coleta_pedido set fl_status = 'F' where cod_estoque = '$cod_estoque'";
					$col = mysqli_query($link, $sql_col);

					$sql_prd = "update tb_pedido_coleta_produto set usr_fim_coleta = '99', dt_fim_coleta = '$date', fl_status = 'F' where nr_pedido = '$nr_pedido'";
					$prd = mysqli_query($link1, $sql_prd);

					$sql_ped = "update tb_pedido_coleta set fl_status = 'F' where nr_pedido = '$nr_pedido'";
					$ped = mysqli_query($link1, $sql_ped);

					$ins_lg = "insert into tb_log_produto (cod_item, ds_ref, id_ref, ds_rotina, vlr_novo, vlr_ant, ds_obs, usr_create, dt_create) values ('$cod_estoque', 'PEDIDO', '$nr_pedido', 'ATUALIZAÇÃO DE SALDO', '$qtde', '$nr_qtde', 'SALDO BAIXADO', '99', '$date')";
					$res_LG = mysqli_query($link,$ins_lg);


				}else{

					echo "Não há saldo na posição - nr_pedido ".$nr_pedido." cod_estoque ".$cod_estoque." nr_qtde_col ".$nr_qtde_col." nr_qtde ".$nr_qtde." qtde ".$qtde."<br>";

					$sql_col = "update tb_coleta_pedido set fl_status = 'X' where cod_estoque = '$cod_estoque'";
					$col = mysqli_query($link, $sql_col);

					$sql_prd = "update tb_pedido_coleta_produto set usr_fim_coleta = '99', dt_fim_coleta = '$date', fl_status = 'X' where nr_pedido = '$nr_pedido'";
					$prd = mysqli_query($link1, $sql_prd);

					$sql_ped = "update tb_pedido_coleta set fl_status = 'X' where nr_pedido = '$nr_pedido'";
					$ped = mysqli_query($link1, $sql_ped);

					$ins_lg = "insert into tb_log_produto (cod_item, ds_ref, id_ref, ds_rotina, vlr_novo, vlr_ant, ds_obs, usr_create, dt_create) values ('$cod_estoque', 'PEDIDO', '$nr_pedido', 'ATUALIZAÇÃO DE SALDO', '$qtde', '$nr_qtde', 'SALDO NÃO BAIXADO', '99', '$date')";
					$res_LG = mysqli_query($link,$ins_lg);
				}

			}

		}

	/*$query_st2 = "select count(fl_status) as status
	from tb_pedido_coleta_produto
	where nr_pedido = '$nr_pedido' and fl_status <> 'F'";
	$res_st2 = mysqli_query($link, $query_st2);
	while ($status2 = mysqli_fetch_assoc($res_st2)) {
		
		if($status2['status'] == '0'){

			echo "Pedido finalizado.<br>";

		}else{

			echo "Pedido não finalizado.<br>";

		}
	}*/


}

$link->close();
$link1->close();
$link2->close();
?>