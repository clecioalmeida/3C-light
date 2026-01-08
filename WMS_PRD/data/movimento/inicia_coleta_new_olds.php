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

$nr_pedido = $_POST['start_col'];

$sql_status = "select fl_status from tb_pedido_coleta where nr_pedido = '$nr_pedido'";
$resultado_status = mysqli_query($link, $sql_status);
while ($dados_upd = mysqli_fetch_assoc($resultado_status)) {
	$fl_status = $dados_upd['fl_status'];
}

if ($fl_status == "A") {

	$sql_prd = "select distinct c.produto, c.nr_qtde
	from tb_pedido_coleta_produto c
	where nr_pedido = '$nr_pedido'
	order by c.produto";
	$res_prd = mysqli_query($link, $sql_prd);
	while ($dados_prd = mysqli_fetch_array($res_prd)) {

		$produto = $dados_prd['produto'];
		$nr_qtde = $dados_prd['nr_qtde'];

		$sql_pp = "SELECT distinct p.cod_estoque, p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura, p.nr_qtde, g.nome
		FROM tb_posicao_pallet p
		left join tb_armazem g on p.ds_galpao = g.id
		left join tb_produto a on a.cod_prod_cliente = p.produto
		WHERE p.produto = '$produto' and p.nr_qtde > 0   and (p.fl_bloq = 'N' or p.fl_bloq is null) and p.fl_empresa = '$cod_cli' and p.fl_status = 'A'
		order by date(p.dt_create), p.ds_galpao, p.ds_prateleira, p.ds_coluna, p.ds_altura";
		$res_pp = mysqli_query($link, $sql_pp);

		if(mysqli_num_rows($res_pp) > 0){

			while ($dados_qtd = mysqli_fetch_array($res_pp)) {
				$cod_estoque 	= $dados_qtd['cod_estoque'];
				$nr_qtde_pp 	= $dados_qtd['nr_qtde'];
				$ds_galpao 		= $dados_qtd['ds_galpao'];
				$ds_prateleira 	= $dados_qtd['ds_prateleira'];
				$ds_coluna 		= $dados_qtd['ds_coluna'];
				$ds_altura 		= $dados_qtd['ds_altura'];

				$sql_res = "select coalesce(sum(nr_qtde_col),0) as nr_qtde from tb_coleta_pedido where fl_status <> 'F' and cod_estoque = '$cod_estoque'";
				$res_res = mysqli_query($link, $sql_res);
				$reservado=mysqli_fetch_assoc($res_res);
				$qtde_res = $reservado['nr_qtde'];
				$qtde_dsp = $nr_qtde_pp - $qtde_res;


				if ($nr_qtde >= $qtde_dsp) {

					$qtde_parcial = $qtde_dsp;

				} else {

					$qtde_parcial = $nr_qtde;

				}

				if ($qtde_parcial > 0) {

					$ins_prd = "insert into tb_coleta_pedido (nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,usr_create,dt_create,fl_status, cod_estoque) values('$nr_pedido', '$produto', '$ds_galpao', '$ds_prateleira', '$ds_coluna', '$ds_altura', '$qtde_parcial', '$id', '$date', 'M', '$cod_estoque')";
					$res_ins = mysqli_query($link, $ins_prd);

					$nr_qtde = $nr_qtde - $qtde_parcial;

					$upd_col = "update tb_pedido_coleta_produto set fl_status = 'C' where nr_pedido = '$nr_pedido'";
					$result_upd = mysqli_query($link1, $upd_col);

					$upd_prd = "update tb_pedido_coleta set fl_status = 'C', usr_lib_col = '$id', dt_lib_col = '$date' where nr_pedido = '$nr_pedido'";
					$result_prd = mysqli_query($link1, $upd_prd) or die(mysqli_error($link));

					if ($result_prd) {

						$retorno = array(
							'info' => "0",
						);

						echo (json_encode($retorno));
					}


				}

			}

		}else{

		$ins_prd = "insert into tb_coleta_pedido (nr_pedido,produto,ds_galpao,ds_prateleira,ds_coluna,ds_altura,nr_qtde_col,usr_create,dt_create,fl_status, cod_estoque) values('$nr_pedido', '$produto', '', '', '', '', '$nr_qtde', '$id', '$date', 'D', '')";
		$res_ins = mysqli_query($link, $ins_prd);

	}

}
}else{

	$retorno = array(
		'info' => "3",
	);

	echo (json_encode($retorno));

	echo "Erro";

}

$link->close();
?>