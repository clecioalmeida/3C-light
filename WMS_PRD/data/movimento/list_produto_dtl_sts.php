<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli  	= $_SESSION['cod_cli'];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$cod_produto = $_REQUEST['cod_produto'];
$nr_qtde_pedido = $_REQUEST['nr_qtde_pedido'];
$nr_pedido = $_REQUEST['nr_pedido'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

if ($nr_qtde_pedido == 0) {

	$retorno[] = array(
		'info' => "0",
	);
	echo (json_encode($retorno));

	exit();

}

$query_prd = "select produto from tb_pedido_coleta_produto where nr_pedido = '$nr_pedido' and produto = '$cod_produto' and nr_qtde > 0";
$res_prd = mysqli_query($link, $query_prd);

if (mysqli_num_rows($res_prd) > 0) {

	$retorno[] = array(
		'info' => "1",
	);
	echo (json_encode($retorno));

	exit();

} else {

	$query_sts = "select distinct fl_status from tb_pedido_coleta_produto where nr_pedido = '$nr_pedido'";
	$res_sts = mysqli_query($link, $query_sts);
	while ($status = mysqli_fetch_assoc($res_sts)) {
		$fl_status = $status['fl_status'];

		//echo $fl_status;
	}

	if ($fl_status == 'X' || $fl_status == 'L') {

		$retorno[] = array(
			'info' => "5",
		);
		echo (json_encode($retorno));

	} else {

		$saldo = "select sum(nr_qtde) as saldo from tb_posicao_pallet where produto = '$cod_produto' and ds_galpao > 1 and (fl_bloq = 'N' or fl_bloq is null) and fl_empresa = '$cod_cli'";
		$res_reservado = mysqli_query($link, $saldo);
		while ($saldo_reservado = mysqli_fetch_assoc($res_reservado)) {
			$saldo = $saldo_reservado['saldo'];

			if ($nr_qtde_pedido <= $saldo) {
				$ins_qtde = "insert into tb_pedido_coleta_produto (nr_pedido, produto, nr_qtde, fl_status, usr_create, dt_create) values ('$nr_pedido', '$cod_produto', '$nr_qtde_pedido', 'T', '$id', now())";
				$res_ins_qtde = mysqli_query($link, $ins_qtde);

				if ($res_ins_qtde) {

					$sql_prd = "select distinct c.produto, c.nr_qtde
                        from tb_pedido_coleta_produto c
                        left join tb_nserie n on c.nr_pedido = n.cod_pedido and c.produto = n.id_produto
                        where nr_pedido = '$nr_pedido' and produto = '$cod_produto'";
					$res_prd = mysqli_query($link, $sql_prd);

					while ($dados_prd = mysqli_fetch_array($res_prd)) {

						$produto = $dados_prd['produto'];
						$nr_qtde = $dados_prd['nr_qtde'];

						$sql_pp = "SELECT distinct p.cod_estoque, p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura, p.nr_qtde, p.nr_lote, p.nr_nf_entrada
                            FROM tb_posicao_pallet p left join tb_pedido_coleta_produto l on p.produto = l.produto
                            left join tb_armazem g on p.ds_galpao = g.id
                            left join tb_produto a on a.cod_produto = p.produto
                            WHERE p.produto = '$produto' and g.fl_situacao = 'A' and p.nr_qtde > 0 and p.fl_empresa = '$cod_cli'
                            order by p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura";
						$res_pp = mysqli_query($link, $sql_pp);

						while ($dados_qtd = mysqli_fetch_array($res_pp)) {

							$cod_estoque = $dados_qtd['cod_estoque'];
							$nr_qtde_pp = $dados_qtd['nr_qtde'];
							$ds_galpao = $dados_qtd['ds_galpao'];
							$ds_prateleira = $dados_qtd['ds_prateleira'];
							$ds_coluna = $dados_qtd['ds_coluna'];
							$ds_altura = $dados_qtd['ds_altura'];

							if ($nr_qtde >= $nr_qtde_pp) {
								$qtde_parcial = $nr_qtde_pp;

							} else {
								$qtde_parcial = $nr_qtde;

							}

							if ($qtde_parcial > 0) {

								$ins_prd = "insert into tb_coleta_pedido (nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,usr_create,dt_create,fl_status, cod_estoque) values('$nr_pedido', '$produto', '$ds_galpao', '$ds_prateleira', '$ds_coluna', '$ds_altura', '$qtde_parcial', '$id', now(), 'M', '$cod_estoque')";
								$res_ins = mysqli_query($link, $ins_prd);
								//$tr_ins=mysqli_num_rows($res_ins);

								$nr_qtde = $nr_qtde - $qtde_parcial;

								//echo $produto."-".$nr_qtde."<br />\n";

								$upd_col = "update tb_pedido_coleta_produto set usr_init_col = '$id', dt_init_col = now(), fl_status = 'M' where nr_pedido = '$nr_pedido'";
								$result_upd = mysqli_query($link1, $upd_col);

								$upd_prd = "update tb_pedido_coleta set fl_status = 'M' where nr_pedido = '$nr_pedido'";
								$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));

							}
						}
					}

					$query_pedido = "select sum(t1.nr_qtde) as alocado, t2.nr_qtde as reservado, t3.nm_produto, t3.cod_produto, t3.cod_prod_cliente, t2.nr_pedido
                                    from tb_posicao_pallet t1
                                    left join tb_pedido_coleta_produto t2 on t1.produto = t2.produto
                                    left join tb_produto t3 on t1.produto = t3.cod_produto
                                    where t2.nr_pedido = '$nr_pedido' and t2.fl_status <> 'D' and t2.produto = '$cod_produto'
                                    group by t1.produto
                                    order by cod_ped desc";
					$res_pedido = mysqli_query($link, $query_pedido);

					while ($pedido = mysqli_fetch_assoc($res_pedido)) {
						$retorno[] = array(
							'info' => "3",
							'cod_produto' => $pedido['cod_produto'],
							'cod_prod_cliente' => $pedido['cod_prod_cliente'],
							'nm_produto' => $pedido['nm_produto'],
							'alocado' => $pedido['alocado'],
							'reservado' => $pedido['reservado'],
							'nr_pedido' => $pedido['nr_pedido'],
						);
					}

					echo (json_encode($retorno));

				} else {

					$retorno[] = array(
						'info' => "4",
					);
					echo (json_encode($retorno));

					exit();

				}

			} else {

				$retorno[] = array(
					'info' => "2",
				);
				echo (json_encode($retorno));
			}
		}
	}
}
$link->close();
?>