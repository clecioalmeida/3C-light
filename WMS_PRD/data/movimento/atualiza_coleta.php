<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 		= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$nr_pedido = $_POST['nr_pedido'];
$cod_prd = $_POST['cod_prd'];
$cod_col = $_POST['cod_col'];

$sql_prd = "select distinct produto, nr_qtde
from tb_pedido_coleta_produto 
where nr_pedido = '$nr_pedido' and produto = '$cod_prd'";
$res_prd = mysqli_query($link, $sql_prd);
while ($dados_prd = mysqli_fetch_array($res_prd)) {

	$produto = $dados_prd['produto'];
	$nr_qtde = $dados_prd['nr_qtde'];

	$sql_pp = "SELECT distinct p.cod_estoque, p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura, p.nr_qtde, g.nome
	FROM tb_posicao_pallet p
	left join tb_armazem g on p.ds_galpao = g.id
	left join tb_produto a on a.cod_prod_cliente = p.produto
	WHERE p.produto = '$produto' and p.nr_qtde > 0   and (p.fl_bloq = 'N' or p.fl_bloq is null) and p.fl_empresa = '$cod_cli' and p.fl_status <> 'E' and p.ds_galpao <> '10' and p.ds_galpao <> '2'
	order by p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura";
	$res_pp = mysqli_query($link, $sql_pp);

	if(mysqli_num_rows($res_pp) > 0){

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

			//echo "produto - ".$produto." - "."Qtde pedido - ".$nr_qtde."-"."Qtde parcial - ".$qtde_parcial."-"."Produto - ".$produto."-"."Qtde posicao - ".$nr_qtde_pp."<br>";

			if ($qtde_parcial > 0) {
				$ins_prd = "insert into tb_coleta_pedido (nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,usr_create,dt_create,fl_status, cod_estoque) values('$nr_pedido', '$produto', '$ds_galpao', '$ds_prateleira', '$ds_coluna', '$ds_altura', '$qtde_parcial', '$id', '$date', 'M', '$cod_estoque')";
				$res_ins = mysqli_query($link, $ins_prd);

				$nr_qtde = $nr_qtde - $qtde_parcial;

				$upd_col = "update tb_coleta_pedido set fl_status = 'E' where cod_col = '$cod_col'";
				$result_upd = mysqli_query($link1, $upd_col);

				if ($res_ins) {

					$retorno[] = array(
						'info' => "0",
					);

					echo (json_encode($retorno));
				}


			}

		}		

	}else{

		$retorno[] = array(
			'info' => "1",
		);

		echo (json_encode($retorno));

		/*$upd_col = "update tb_coleta_pedido set fl_status = 'E' where cod_col = '$cod_col'";
		$result_upd = mysqli_query($link1, $upd_col);

		$ins_prd = "insert into tb_coleta_pedido (nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,usr_create,dt_create,fl_status, cod_estoque) values('$nr_pedido', '$produto', '', '', '', '', '$nr_qtde', '$id', '$date', 'D', '')";
		$res_ins = mysqli_query($link, $ins_prd);*/

	}

}

$link->close();
?>