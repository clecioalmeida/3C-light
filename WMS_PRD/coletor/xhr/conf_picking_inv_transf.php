<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id 	 = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$localInv 		= $_POST['localInv'];
$barcode 		= $_POST['barcode'];
$nr_qtde_inv 	= $_POST['nr_qtde_inv'];
$nr_vol_inv 	= $_POST['nr_vol_inv'];
$nrInvConf 		= $_POST['nrInvConf'];
$id_galpao 		= $_POST['id_galpao'];
//$nr_ca_inv 		= $_POST['nr_ca_inv'];
$nr_lp_inv 		= $_POST['nr_lp_inv'];
$nr_kva_inv 	= $_POST['nr_kva_inv'];
$nr_serial_inv 	= $_POST['nr_serial_inv'];
$nr_fabr_inv 	= $_POST['nr_fabr_inv'];
$nr_ano_inv 	= $_POST['nr_ano_inv'];
$cod_estoque 	= $_POST['cod_estoque'];
/*$dt_ca_inv 		= $_POST['dt_ca_inv'];
$nr_ld_inv 		= $_POST['nr_ld_inv'];
$dt_ld_inv 		= $_POST['dt_ld_inv'];
$dt_val_inv 	= $_POST['dt_val_inv'];*/

$end = explode("-", $localInv);

if(isset($end[0]) && isset($end[1]) && isset($end[2]) && isset($end[3])){

	$id_end = $end[0];
	$rua 	= strtoupper($end[1]);
	$col 	= strtoupper($end[2]);
	$alt 	= strtoupper($end[3]);

	//$cod_prod_cliente = explode("-", $barcode);

	//if(isset($cod_prod_cliente[0]) && isset($cod_prod_cliente[1])){

		$cod_cliente 	= $barcode;
		//$id_etq 		= $cod_prod_cliente[1];

		$query_init = "SELECT cod_produto, nm_produto
		from tb_produto
		where cod_prod_cliente = '$cod_cliente' and fl_empresa = '$cod_cli'";
		$res_init = mysqli_query($link, $query_init);

		if(mysqli_num_rows($res_init) > 0){

			$init = mysqli_fetch_assoc($res_init);
			$cod_produto 	= $init['cod_produto'];
			$nm_produto 	= $init['nm_produto'];

			$upd_col = "INSERT into tb_inv_tarefa (
				id_inv, id_estoque, id_produto, id_galpao, id_rua, id_coluna, id_altura, nr_volume,
				ds_lp, fl_status, fl_tipo, fl_empresa, user_create, dt_create, ds_kva, ds_serial, ds_fabr, ds_ano
				) values (
					'$nrInvConf', '$cod_estoque', '$cod_produto', '$id_galpao', '$rua', '$col', '$alt', '$nr_vol_inv', 
					 '$nr_lp_inv', 'A', 'R', '$cod_cli', '$id', '$date', '$nr_kva_inv', '$nr_serial_inv', '$nr_fabr_inv', '$nr_ano_inv'
					 )";
			$res_col = mysqli_query($link1, $upd_col);

			if(mysqli_affected_rows($link1) > 0){

				$nTar = mysqli_insert_id($link1);
	
				$ins_conf = "INSERT into tb_inv_conf (
					id_tar, cont_1, cont_2, dt_conf_1, user_create, dt_create
					) values (
						'$nTar', '$nr_qtde_inv', '$nr_qtde_inv', '$date', '$id', '$date'
						)";
				$res_conf = mysqli_query($link, $ins_conf);
	
				$retorno = array(
					'info' => "<p style=background-color:#009933;color:white;text-align:center>Tarefa gravada com sucesso.</p>",
				);
	
				echo(json_encode($retorno));
	
			}else{
	
				$retorno = array(
					'info' => "<p style=background-color:#D96123;color:white;text-align:center>Erro na gravação da tarefa.</p>",
				);
	
				echo(json_encode($retorno));
			}

		}else{

			$retorno = array(
				'info' => "<p style=background-color:#D96123;color:white;text-align:center>Produto não cadastrado.</p>",
			);
	
			echo(json_encode($retorno));

		}

	/*}else{

		$retorno = array(
			'info' => "<p style=background-color:#D96123;color=white>Produto inválido.</p>",
		);

		echo(json_encode($retorno));

	}*/

}else{

	$retorno = array(
		'info' => "<p style=background-color:#D96123;color=white>Endereço inválido.</p>",
	);

	echo(json_encode($retorno));

}

$link->close();
$link1->close();
?>