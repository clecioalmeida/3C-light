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

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

if($cod_cli == "3"){

	$ds_galpao = "10";

}else{

	$ds_galpao = "2";

}

$cod_estoque 	= $_POST['cod_estoque'];
$nr_qtde 		= $_POST['nr_qtde'];
$nr_qtde_old 	= $_POST['nr_qtde_old'];
$cod_produto 	= $_POST['cod_produto'];
$produto 		= $_POST['produto'];
$nr_or 			= $_POST['nr_or'];
$nr_volume 		= $_POST['nr_volume'];

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

		$sql = "insert into tb_posicao_pallet (produto, cod_produto, ds_galpao, nr_volume, nr_qtde, nr_or, fl_status, fl_tipo, fl_bloq, fl_empresa, user_update, dt_update) values ('$produto', '$cod_produto', '$ds_galpao', '$nr_volume', '$nr_qtde', '$nr_or', 'L', 'T', 'N', '$cod_cli', '$id', '$date')";
		$result_id = mysqli_query($link1, $sql) or die(mysqli_error($link1));
		$new_pp = mysqli_insert_id($link1);

		$upd_ppa = "update tb_posicao_pallet set nr_posicao_temp = '$cod_estoque' where cod_estoque = '$new_pp'";
		$res_ppa = mysqli_query($link, $upd_ppa) or die(mysqli_error($link));

		$upd_pp = "update tb_posicao_pallet set nr_qtde = '$nr_qtde_new' where cod_estoque = '$cod_estoque'";
		$res_pp = mysqli_query($link, $upd_pp) or die(mysqli_error($link));

		$query_pedido="insert into tb_aloca (cod_estoque, fl_status, fl_empresa, usr_create, dt_create) values ('$new_pp', 'L', '$cod_cli', '$id', '$date')";
		$res_pedido = mysqli_query($link1,$query_pedido);

		if (mysqli_affected_rows($link1) > 0) {

			$array_info[] = array(

				'info' => "0",
				'n_qtde' => $nr_qtde_new,
			);
			echo (json_encode($array_info));

		} else {

			$array_info[] = array(

				'info' => "1",
			);
			echo (json_encode($array_info));

		}

	} else {

		$upd_pp = "update tb_posicao_pallet set nr_qtde = '0' where cod_estoque = '$cod_estoque'";
		$res_pp = mysqli_query($link, $upd_pp) or die(mysqli_error($link));

		$array_info[] = array(

			'info' => "3",
		);
		echo (json_encode($array_info));

	}
}

$link->close();
?>