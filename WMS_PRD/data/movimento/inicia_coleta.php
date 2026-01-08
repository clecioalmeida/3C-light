<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;
} else {

	$id 		= $_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Santiago');
$date = date("Y-m-d H:i:s");
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$nr_pedido = $_POST['start_col'];

$sql_prd = "select c.cod_ped, c.produto, c.nr_qtde, c.ds_kva, c.ds_lp, c.ds_serial
from tb_pedido_coleta_produto c
where nr_pedido = '$nr_pedido' and fl_status <> 'E' and fl_status <> 'M' and fl_empresa = '$cod_cli'
order by c.produto";
$res_prd = mysqli_query($link, $sql_prd);
while ($dados_prd = mysqli_fetch_array($res_prd)) {

	if ($dados_prd['produto'] == "" && $dados_prd['ds_lp'] > 0) {

		$produto_a = "ds_lp = '" . $dados_prd['ds_lp'] . "'";
		$produto_b = "p.ds_lp = '" . $dados_prd['ds_lp'] . "'";
		$join_a = "p.ds_lp = s.ds_lp";
	} else {

		$produto_a = "produto = '" . $dados_prd['produto'] . "'";
		$produto_b = "c.produto = '" . $dados_prd['produto'] . "'";
		$join_a = "p.produto = s.produto";
	}

	$nr_qtde 	= $dados_prd['nr_qtde'];
	$ds_lp 		= $dados_prd['ds_lp'];
	$cod_ped 	= $dados_prd['cod_ped'];
	$cod_prd 	= $dados_prd['produto'];

	$sql_pp = "SELECT data, s.cod_estoque, s.id_endereco, p.id_end, s.produto, COALESCE(s.nr_qtde,0) as nr_qtde, 
	COALESCE(p.qtde_col,0) as qtde_col, 
	case when COALESCE(p.qtde_col,0) > COALESCE(s.nr_qtde,0) then 0 else (COALESCE(s.nr_qtde,0)- COALESCE(p.qtde_col,0)) end as qtde_saldo,
	 s.ds_galpao, s.ds_prateleira, s.ds_coluna, s.ds_altura, s.cod_etq, p.fl_status, p.nr_pedido, s.cod_estoque, s.ds_lp
		FROM
		(
			SELECT COALESCE(dt_validade,'0000-00-00') as data, 
			cod_estoque, 
			id_endereco,
			produto,
			nr_qtde,
			ds_galpao,
			ds_prateleira,
			ds_coluna,
			ds_altura, cod_etq,
			ds_lp
			from tb_posicao_pallet
			WHERE " . $produto_a . " and nr_qtde > 0 and coalesce(fl_bloq,'N') = 'N' and fl_empresa = '$cod_cli'
			group by ds_galpao desc, cod_estoque, nr_qtde asc
			order by month(dt_create)
		) s
		left JOIN
		(
			SELECT coalesce(sum(c.nr_qtde_col),0) as qtde_col,
			c.produto,
			c.id_end,
			t.fl_status, 
			c.nr_pedido,
            c.cod_estoque,
			p.ds_lp
			from tb_coleta_pedido c
			left join tb_pedido_coleta t on c.nr_pedido = t.nr_pedido and t.fl_status <> 'E' 
            left join tb_posicao_pallet p on c.cod_estoque = p.cod_estoque
			WHERE c.fl_status <> 'E' and t.fl_status <> 'F' and t.fl_status <> 'X' and " . $produto_b . " and t.fl_empresa = '$cod_cli'
			group by c.cod_estoque

		) p on " . $join_a . " and p.cod_estoque = s.cod_estoque
        where (COALESCE(s.nr_qtde,0)- COALESCE(p.qtde_col,0)) > 0";
	$res_pp = mysqli_query($link, $sql_pp);
	//print_r($sql_pp)."<br>";
	//echo $sql_pp."<br>";
	if (mysqli_num_rows($res_pp) > 0) {

		while ($dados_qtd = mysqli_fetch_array($res_pp)) {
			$cod_estoque 	= $dados_qtd['cod_estoque'];
			$nr_qtde_pp 	= $dados_qtd['nr_qtde'];
			$nr_qtde_pp 	= $dados_qtd['nr_qtde'];
			$qtde_res 		= $dados_qtd['qtde_col'];
			$qtde_saldo 	= $dados_qtd['qtde_saldo'];
			$ds_galpao 		= $dados_qtd['ds_galpao'];
			$ds_prateleira 	= $dados_qtd['ds_prateleira'];
			$ds_coluna 		= $dados_qtd['ds_coluna'];
			$ds_altura 		= $dados_qtd['ds_altura'];
			$cod_etq 		= $dados_qtd['cod_etq'];
			$id_end 		= $dados_qtd['id_endereco'];
			$ds_lp 			= $dados_qtd['ds_lp'];
			$produto 		= $dados_qtd['produto'];

			if ($nr_qtde > 0) {

				if ($nr_qtde >= $qtde_saldo) {

					$qtde_parcial = $qtde_saldo;

					/*echo "--------------------------<br>";
					echo "Primeiro if.<br>";
					echo "cod_ped: " . $cod_ped . "<br>";
					echo "cod_estoque: " . $cod_estoque . "<br>";
					echo "nr_qtde_ped: " . $nr_pedido . "<br>";
					echo "nr_qtde: " . $nr_qtde . "<br>";
					echo "qtde_saldo: " . $qtde_saldo . "<br>";
					echo "qtd_parcial: " . $qtde_parcial . "<br>";
					echo "qtde_col: " . $dados_qtd['qtde_col'] . "<br>";
					echo "nr_qtde_pp: " . $nr_qtde_pp . "<br>";
					echo "nr_qtde: " . $nr_qtde . "<br>";*/
					$nr_qtde = $nr_qtde - $qtde_parcial;

					$ins_prd = "insert into tb_coleta_pedido (
						cod_ped, nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,
					usr_create,dt_create,fl_status, cod_estoque, id_end
					) values(
						'$cod_ped', '$nr_pedido', '$produto', '$ds_galpao', '$ds_prateleira', '$ds_coluna', '$ds_altura', '$qtde_parcial', '$id', now(), 
						'M', '$cod_estoque', '$id_end'
						)";
					$res_ins = mysqli_query($link, $ins_prd);

					$upd_col = "update tb_pedido_coleta_produto set fl_status = 'M' where cod_ped = '$cod_ped'";
					$result_upd = mysqli_query($link1, $upd_col);

				} else {

					$qtde_parcial = $nr_qtde;

					/*echo "--------------------------<br>";
					echo "Qtde já atendida.<br>";
					echo "Primeiro else.<br>";
					echo "cod_ped: " . $cod_ped . "<br>";
					echo "cod_estoque: " . $cod_estoque . "<br>";
					echo "nr_qtde_ped: " . $nr_pedido . "<br>";
					echo "nr_qtde: " . $nr_qtde . "<br>";
					echo "qtde_saldo: " . $qtde_saldo . "<br>";
					echo "qtd_parcial: " . $qtde_parcial . "<br>";
					echo "qtde_col: " . $dados_qtd['qtde_col'] . "<br>";
					echo "nr_qtde_pp: " . $nr_qtde_pp . "<br>";
					echo "nr_qtde: " . $nr_qtde . "<br>";*/
					$nr_qtde = $nr_qtde - $qtde_parcial;

					$ins_prd = "insert into tb_coleta_pedido (
						cod_ped, nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,
						usr_create,dt_create,fl_status, cod_estoque, id_end
						) values(
							'$cod_ped', '$nr_pedido', '$produto', '$ds_galpao', '$ds_prateleira', '$ds_coluna', 
							'$ds_altura', '$qtde_parcial', '$id', now(), 'M', 
							'$cod_estoque', '$id_end'
							)";
					$res_ins = mysqli_query($link, $ins_prd);

					$upd_col = "update tb_pedido_coleta_produto set fl_status = 'M' where cod_ped = '$cod_ped'";
					$result_upd = mysqli_query($link1, $upd_col);

				}

			} else {

				echo "Qtde já atendida.<br>";
			}
		}
	} else {

		$ins_log = "insert into tb_log_produto 
			(
			cod_item, ds_ref, id_ref, ds_rotina, fl_empresa, 
			vlr_novo, vlr_ant, ds_obs, usr_create, dt_create
			) 
			values
			(
			'$nr_pedido', 'COD. PRODUTO', '$cod_ped', 
			'INICIA COLETA', '$cod_cli', '', 
			'', 'SALDO NÃO ENCONTRADO PARA O PRODUTO', 
			'$id', '$date'
		)";
		$res_log = mysqli_query($link, $ins_log);

		$ins_prd = "insert into tb_coleta_pedido (
			cod_ped, nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,
		usr_create,dt_create,fl_status, cod_estoque, id_end
		) values(
			'$cod_ped', '$nr_pedido', '$cod_prd', '', '', '', '', '0', '$id', now(), 
			'M', '', ''
			)";
		$res_ins = mysqli_query($link, $ins_prd);

		$upd_col = "update tb_pedido_coleta_produto set ds_obs = 'SALDO NÃO ENCONTRADO PARA O PRODUTO' where cod_ped = '$cod_ped'";
		$result_upd = mysqli_query($link1, $upd_col);

		echo "LP / Produto não encontrado: " . $ds_lp . "<br>";
	}
}

$sql_conf = "select count(fl_status) as status from tb_pedido_coleta_produto where nr_pedido = '$nr_pedido' and fl_status = 'A'";
$res_conf = mysqli_query($link, $sql_conf);
$count = mysqli_fetch_assoc($res_conf);

if ($count['status'] > 0) {

	$upd_prd = "update tb_pedido_coleta set fl_status = 'D', usr_lib_col = '$id', dt_lib_col  = '$date' where nr_pedido = '$nr_pedido'";
	$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));

	echo "1";

} else {

	$upd_prd = "update tb_pedido_coleta set fl_status = 'M', usr_lib_col = '$id', dt_lib_col  = '$date' where nr_pedido = '$nr_pedido'";
	$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));

	echo "0";
}

$link->close();
?>