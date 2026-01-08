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
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto = $_REQUEST['cod_produto'];
$nr_qtde_pedido = $_REQUEST['nr_qtde_pedido'];
$nr_pedido = $_REQUEST['nr_pedido'];

if ($nr_qtde_pedido == 0) {

	$retorno[] = array(
		'info' => "0",
	);
	echo (json_encode($retorno));

	exit();

}else{

	$sql_saldo = "select coalesce(sum(t1.nr_volume),0) as volume,coalesce(sum(t1.nr_qtde),0) as item, t1.produto
	from tb_posicao_pallet t1 
	where t1.produto = '$cod_produto' and t1.nr_qtde > 0 and COALESCE(fl_bloq,'N') = 'N'
	group by t1.produto";
	$res_saldo = mysqli_query($link, $sql_saldo);
	while ($saldo_est = mysqli_fetch_assoc($res_saldo)) {
		$saldo 		= $saldo_est['item'];
		$produto 	= $saldo_est['produto'];

		if ($nr_qtde_pedido <= $saldo) {
			$ins_qtde = "insert into tb_pedido_coleta_produto (nr_pedido, produto, nr_qtde, fl_status, fl_empresa, usr_create, dt_create) values ('$nr_pedido', '$produto', '$nr_qtde_pedido', 'A', '$cod_cli', '$id', '$date')";
			$res_ins_qtde = mysqli_query($link, $ins_qtde);

			if (mysqli_affected_rows($link) > 0) {

				$query_pedido = "select sum(t1.nr_qtde) as alocado, t2.nr_qtde as reservado, t3.nm_produto, t3.cod_produto, t3.cod_prod_cliente, t2.nr_pedido
                        from tb_posicao_pallet t1
                        left join tb_pedido_coleta_produto t2 on t1.produto = t2.produto
                        left join tb_produto t3 on t1.produto = t3.cod_prod_cliente
                        where t2.nr_pedido = '$nr_pedido' and t2.fl_status <> 'D' and t2.produto = '$produto'
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
$link->close();
?>