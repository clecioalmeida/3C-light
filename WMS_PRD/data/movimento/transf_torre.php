<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$cod_estoque = $_POST['cod_estoque'];
$nr_qtde = $_POST['nr_qtde'];
$nr_qtde_old = $_POST['nr_qtde_old'];
$ds_galpao = $_POST['ds_galpao'];
$ds_rua = $_POST['ds_rua'];
$ds_coluna = $_POST['ds_coluna'];
$ds_altura = $_POST['ds_altura'];
$id_aval = $_POST['id_aval'];
$ds_projeto = $_POST['ds_projeto'];
$ds_embalagem = $_POST['ds_embalagem'];
$ds_projeto_new = $_POST['ds_projeto_new'];
$ds_embalagem_new = $_POST['ds_embalagem_new'];
$cod_produto = $_POST['cod_produto'];
$nr_nf_entrada = $_POST['nr_nf_entrada'];
$id_tar = $_POST['id_tar'];

$nr_qtde_new = $nr_qtde_old - $nr_qtde;

$query_ped = "select distinct t1.produto, t2.nr_pedido
	from tb_posicao_pallet t1
	left join tb_coleta_pedido t2 on t1.produto = t2.produto and t1.ds_galpao = t2.ds_galpao and t1.ds_prateleira = t2.ds_prateleira
	and t1.ds_coluna = t2.ds_coluna and t1.ds_altura = t2.ds_altura
	where t1.cod_estoque = '$cod_estoque' and t2.fl_status <> 'E' and t2.fl_status <> 'F' and t2.fl_status <> 'X'";
$res_ped = mysqli_query($link, $query_ped) or die(mysqli_error($link));

if (mysqli_num_rows($res_ped) > 0) {

	$array_info[] = array(

		'info' => "4",
	);
	echo (json_encode($array_info));

} else {

	if ($nr_qtde <= $nr_qtde_old) {

		$sql = "insert into tb_posicao_pallet (produto, ds_galpao, ds_prateleira, ds_altura, ds_coluna, nr_qtde, ds_projeto, ds_embalagem, nr_nf_entrada, ds_avaliacao, id_tar, user_update, dt_update) values ('$cod_produto', '$ds_galpao', '$ds_rua', '$ds_altura', '$ds_coluna', '$nr_qtde', '$ds_projeto_new', '$ds_embalagem_new', '$nr_nf_entrada', '$id_aval', '$id_tar', '$id', now())";
		$result_id = mysqli_query($link1, $sql) or die(mysqli_error($link1));
		$new_pp = mysqli_insert_id($link1);

		$upd_ppa = "update tb_posicao_pallet set nr_or = 0, nr_posicao_temp = '$cod_estoque' where cod_estoque = '$new_pp'";
		$res_ppa = mysqli_query($link, $upd_ppa) or die(mysqli_error($link));

		$upd_pp = "update tb_posicao_pallet set nr_qtde = '$nr_qtde_new' where cod_estoque = '$cod_estoque'";
		$res_pp = mysqli_query($link, $upd_pp) or die(mysqli_error($link));
		if (mysqli_affected_rows($link) > 0) {

			$array_info[] = array(

				'info' => "0",
			);
			echo (json_encode($array_info));

		} else {

			$array_info[] = array(

				'info' => "1",
			);
			echo (json_encode($array_info));

		}

	} else {

		$array_info[] = array(

			'info' => "3",
		);
		echo (json_encode($array_info));

	}
}

$link->close();
?>