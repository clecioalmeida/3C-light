<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$nr_pedido = $_POST['start_col'];

$sql_status = "select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
$resultado_status = mysqli_query($link, $sql_status);
while ($dados_upd = mysqli_fetch_assoc($resultado_status)) {
	$fl_status = $dados_upd['fl_status'];
}

if ($fl_status == "M") {

	$sql_prd = "select distinct c.produto, c.nr_qtde
	from tb_pedido_coleta_produto c
	where nr_pedido = '$nr_pedido'
            order by c.produto";
	$res_prd = mysqli_query($link, $sql_prd);
	while ($dados_prd = mysqli_fetch_array($res_prd)) {

		$produto = $dados_prd['produto'];
		$nr_qtde = $dados_prd['nr_qtde'];

		$sql_pp = "SELECT distinct p.cod_estoque, p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura, p.nr_qtde, g.nome, c.dt_docto as dt_ca, l.dt_docto as dt_laudo, e.id as cod_etq
		FROM tb_posicao_pallet p
		left join tb_armazem g on p.ds_galpao = g.id
		left join tb_produto a on a.cod_prod_cliente = p.produto
        left join tb_ca c on p.cod_ca = c.id
        left join tb_ca l on p.cod_laudo = l.id
        left join tb_etiqueta e on p.cod_estoque = e.cod_estoque
		WHERE p.produto = '$produto' and p.nr_qtde > 0 and (p.fl_bloq = 'N' or p.fl_bloq is null) and p.fl_status <> 'E'
		order by c.dt_docto, l.dt_docto, p.nr_qtde, p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura";
		$res_pp = mysqli_query($link, $sql_pp);

		if(mysqli_num_rows($res_pp) > 0){

			while ($dados_qtd = mysqli_fetch_array($res_pp)) {
			$cod_estoque 	= $dados_qtd['cod_estoque'];
			$nr_qtde_pp 	= $dados_qtd['nr_qtde'];
			$ds_galpao 		= $dados_qtd['ds_galpao'];
			$ds_prateleira 	= $dados_qtd['ds_prateleira'];
			$ds_coluna 		= $dados_qtd['ds_coluna'];
			$ds_altura 		= $dados_qtd['ds_altura'];
			$dt_ca 			= $dados_qtd['dt_ca'];
			$dt_laudo 		= $dados_qtd['dt_laudo'];
			$cod_etq 		= $dados_qtd['cod_etq'];

			//echo "Qtde pedido - ".$nr_qtde."-".$produto."- nr_qtde_pp ".$nr_qtde_pp."<br>";

			if ($nr_qtde >= $nr_qtde_pp) {

				$qtde_parcial = $nr_qtde_pp;

			} else {

				$qtde_parcial = $nr_qtde;

			}

			echo "produto - ".$produto." - "."Qtde pedido - ".$nr_qtde."-"."Qtde parcial - ".$qtde_parcial."-"."Produto - ".$produto."-"."Qtde posicao - ".$nr_qtde_pp."<br>";

			if ($qtde_parcial > 0) {
				/*$ins_prd = "insert into tb_coleta_pedido (nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,usr_create,dt_create,fl_status, cod_estoque) values('$nr_pedido', '$produto', '$ds_galpao', '$ds_prateleira', '$ds_coluna', '$ds_altura', '$qtde_parcial', '$id', now(), 'M', '$cod_estoque')";
				$res_ins = mysqli_query($link, $ins_prd);*/
				//$tr_ins=mysqli_num_rows($res_ins);

				$nr_qtde = $nr_qtde - $qtde_parcial;

				echo "saldo - ".$nr_qtde."<br /><br />";

				/*$upd_col = "update tb_pedido_coleta_produto set usr_init_col = '$id', dt_init_col = now(), fl_status = 'M' where nr_pedido = '$nr_pedido'";
				$result_upd = mysqli_query($link1, $upd_col);

				$upd_prd = "update tb_pedido_coleta set fl_status = 'M' where nr_pedido = '$nr_pedido'";
				$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));*/

			}
		}

		}else{



		}

		

	}

	/*if ($result_prd) {

		$retorno = array(
			'info' => "0",
		);

		echo (json_encode($retorno));
		echo "Funciona";
	}*/

} else {

	/*$retorno = array(
		'info' => "3",
	);

	echo (json_encode($retorno));*/

	echo "Nao funciona";
}

$link->close();
?>