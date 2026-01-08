<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id_user = $_SESSION["id"];
}
?>
<?php

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$cod_nf_entrada = $_POST['cod_nf_entrada'];
$cod_produto = $_POST['cod_produto'];
$cod_prod_cliente = $_POST['cod_prod_cliente'];
$nr_qtde = $_POST['nr_qtde'];
$vl_unit = $_POST['vl_unit'];
$nr_peso_ent = $_POST['nr_peso_ent'];
$estado_produto = $_POST['estado_produto'];
//$id_user = $_POST['id_user'];

if (isset($cod_prod_cliente)) {

	$query_prod = "select cod_produto from tb_produto where cod_prod_cliente = '$cod_prod_cliente'";
	$res_prod = mysqli_query($link, $query_prod);

	if (mysqli_num_rows($res_prod) > 0) {

		while ($produto = mysqli_fetch_array($res_prod)) {
			$cod_produto_pesq = $produto['cod_produto'];
		}

		$query_nf = "select produto from tb_nf_entrada_item where cod_nf_entrada = '$cod_nf_entrada' and produto = '$cod_produto_pesq' and fl_status <> 'E'";
		$res_nf = mysqli_query($link, $query_nf);
		$tr = mysqli_num_rows($res_nf);

		if ($tr > 0) {

			$retorno[] = array(
				'info' => "0",
			);

			echo (json_encode($retorno));

		} else {

			$ins_prd = "insert into tb_nf_entrada_item (cod_nf_entrada, fl_status, produto, estado_produto, nr_qtde, vl_unit, nr_peso_unit, user_rec, dt_rec) values ('$cod_nf_entrada', 'A', '$cod_produto_pesq', '$estado_produto', '$nr_qtde', '$vl_unit', '$nr_peso_ent', '$id_user', now())";
			$res_prd = mysqli_query($link1, $ins_prd);

			$id_item = mysqli_insert_id($link1);

			$query_item = "select t1.cod_nf_entrada, t1.cod_nf_entrada_item, t2.nr_fisc_ent, t1.produto, t3.nm_produto, t3.cod_prod_cliente, t4.estado, t1.nr_qtde, t1.vl_unit, t1.nr_peso_unit
					from tb_nf_entrada_item t1
					left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
					left join tb_produto t3 on t1.produto = t3.cod_produto
					left join tb_estado_produto t4 on t1.estado_produto = t4.id
					where t1.cod_nf_entrada_item = $id_item";
			$res_item = mysqli_query($link, $query_item);

			if (mysqli_num_rows($res_item)) {
				while ($dados = mysqli_fetch_assoc($res_item)) {
					$retorno[] = array(
						'info' => "1",
						'cod_nf_entrada_item' => $dados['cod_nf_entrada_item'],
						'cod_nf_entrada' => $dados['cod_nf_entrada'],
						'nr_fisc_ent' => $dados['nr_fisc_ent'],
						'produto' => $dados['produto'],
						'nm_produto' => $dados['nm_produto'],
						'estado' => $dados['estado'],
						'nr_qtde' => $dados['nr_qtde'],
						'vl_unit' => $dados['vl_unit'],
						'nr_peso_unit' => $dados['nr_peso_unit'],
						'cod_prod_cliente' => $dados['cod_prod_cliente'],
					);
				}

				echo (json_encode($retorno));

			} else {

				$retorno[] = array(
					'info' => "Erro no cadastro! Entre em contato com o suporte.",
				);

				echo (json_encode($retorno));
			}

		}

	} else {

		$retorno[] = array(
			'info' => "2",
		);

		echo (json_encode($retorno));

	}

} else {

	$query_nf = "select produto from tb_nf_entrada_item where cod_nf_entrada = '$cod_nf_entrada' and produto = '$cod_produto'";
	$res_nf = mysqli_query($link, $query_nf);

	$id_item = mysqli_insert_id($link);
	echo $res_item;

	$query_item = "select t1.cod_nf_entrada, t1.cod_nf_entrada_item, t2.nr_fisc_ent, t1.produto, t3.nm_produto, t4.estado, t1.nr_qtde, t1.vl_unit, t1.nr_peso_unit
		from tb_nf_entrada_item t1
		left join tb_nf_entrada t2 on t1.cod_nf_entrada = t2.cod_nf_entrada
		left join tb_produto t3 on t1.produto = t3.cod_produto
		left join tb_estado_produto t4 on t1.estado_produto = t4.id
		where t1.cod_nf_entrada_item = $id_item";
	$res_item = mysqli_query($link, $query_item);

	if ($res_item) {
		while ($dados = mysqli_fetch_assoc($res_item)) {
			$retorno[] = array(
				'info' => "1",
				'cod_nf_entrada_item' => $dados['cod_nf_entrada_item'],
				'cod_nf_entrada' => $dados['cod_nf_entrada'],
				'nr_fisc_ent' => $dados['nr_fisc_ent'],
				'produto' => $dados['produto'],
				'nm_produto' => $dados['nm_produto'],
				'estado' => $dados['estado'],
				'nr_qtde' => $dados['nr_qtde'],
				'vl_unit' => $dados['vl_unit'],
				'nr_peso_unit' => $dados['nr_peso_unit'],
			);
		}

		echo (json_encode($retorno));

	} else {

		$ins_prd = "insert into tb_nf_entrada_item (cod_nf_entrada, fl_status, produto, estado_produto, nr_qtde, vl_unit, nr_peso_unit, user_rec, dt_rec) values ('$cod_nf_entrada', 'A', '$cod_produto', '$estado_produto', '$nr_qtde', '$vl_unit', '$nr_peso_ent', '$id_user', now())";
		$res_prd = mysqli_query($link, $ins_prd);

		if ($res_prd) {

			$retorno[] = array(
				'info' => "1",
			);

			echo (json_encode($retorno));

		} else {
			$retorno[] = array(
				'info' => "0 Erro no cadastro!",
			);

			echo (json_encode($retorno));
		}

	}

}
$link->close();
?>