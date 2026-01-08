<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$cod_estoque 	= $_POST['cod_estoque'];
$nr_qtde 		= $_POST['nr_qtde'];
$nr_qtde_old 	= $_POST['nr_qtde_old'];
$ds_galpao 		= $_POST['ds_galpao'];
$ds_rua 		= $_POST['ds_rua'];
$ds_coluna 		= $_POST['ds_coluna'];
$ds_altura 		= $_POST['ds_altura'];
$cod_produto 	= $_POST['cod_produto'];
$produto 		= $_POST['cod_prod_cliente'];
$nr_or 			= $_POST['nr_or'];
$ds_ano 	    = $_POST['ds_ano'];
$n_serie 	    = $_POST['n_serie'];
$ds_fabr 	    = $_POST['ds_fabr'];
$ds_lp 	        = $_POST['ds_lp'];

$nr_qtde_new 	= $nr_qtde_old - $nr_qtde;

$query_ped = "select t1.cod_estoque
from tb_coleta_pedido t1
where t1.cod_estoque = '$cod_estoque' and t1.fl_status <> 'F' and t1.fl_status <> 'E'";
$res_ped = mysqli_query($link, $query_ped) or die(mysqli_error($link));

if (mysqli_num_rows($res_ped) > 0) {

	$array_info[] = array(

		'info' => "4",
	);
	echo (json_encode($array_info));

} else {

	if ($nr_qtde <= $nr_qtde_old) {

		$sql = "insert into tb_posicao_pallet (produto, cod_produto, ds_galpao, ds_prateleira, ds_altura, ds_coluna, nr_qtde, nr_or, fl_status, fl_tipo, fl_bloq, fl_empresa, user_update, dt_update, ds_ano, n_serie, ds_fabr, ds_lp, ds_enr) values ('$produto', '$cod_produto', '$ds_galpao', '$ds_rua', '$ds_altura', '$ds_coluna', '$nr_qtde', '$nr_or', 'A', 'T', 'N', '$cod_cli', '$id', '$date', '$ds_ano', '$n_serie', '$ds_fabr', '$ds_lp', '$ds_enr')";
		$result_id = mysqli_query($link1, $sql) or die(mysqli_error($link1));
		$new_pp = mysqli_insert_id($link1);

		$upd_ppa = "update tb_posicao_pallet set nr_posicao_temp = '$cod_estoque' where cod_estoque = '$new_pp'";
		$res_ppa = mysqli_query($link, $upd_ppa) or die(mysqli_error($link));

		$upd_pp = "update tb_posicao_pallet set nr_qtde = '$nr_qtde_new' where cod_estoque = '$cod_estoque'";
		$res_pp = mysqli_query($link, $upd_pp) or die(mysqli_error($link));

		$sql_log = "insert into tb_log_produto (cod_item, ds_ref, id_ref, ds_rotina, vlr_novo, ds_obs, usr_create, dt_create) values ('$produto', 'COD ESTOQUE', '$cod_estoque', 'TRANSFERÊNCIA', '$new_pp', 'TRANSFERÊNCIA REALIZADA', '$id', '$date')";
		$res_log = mysqli_query($link1, $sql_log) or die(mysqli_error($link1));

		if (mysqli_affected_rows($link) > 0) {

			$array_info[] = array(

				'info' 		=> "0",
				'n_qtde' 	=> $nr_qtde_new,
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