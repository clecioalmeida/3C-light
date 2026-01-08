<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id_usr 	= $_SESSION["id"];
	$cod_cli 	= $_SESSION["cod_cli"];
}
?>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$date 		= date("Y-m-d H:i:s");
$date_col 	= date("Y-m-d H:00:00");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

if(isset($_POST['nr_serial'])){

	$nr_serial 	= $_POST['nr_serial'];
	$nr_pallet 	= $_POST['nr_pallet'];
	$cod_prd 	= $_POST['cod_prd'];
	$nm_for 	= $_POST['nm_for'];

	if($_POST['id_col'] == "0"){

		$ins_col = "INSERT into tb_nserie_col 
		(ds_data, nm_fornecedor, fl_status, usr_create, dt_create) 
		values 
		('$date_col', '$nm_for', 'A', '$id_usr', '$date')";
		$res_col = mysqli_query($link, $ins_col);

		$id_col = mysqli_insert_id($link);

	}else{

		$id_col 	= $_POST['id_col'];

	}

	$sql = "select n_serie from tb_nserie where n_serie = '$nr_serial' and fl_status <> 'E'";
	$res = mysqli_query($link, $sql);

	if(mysqli_num_rows($res) > 0){

		$retorno = array(
			'info'		=> "3",
			'text' 		=> "<tr style='background-color: #FF7F50'>
			<td>N.série: ".$nr_serial."</td><td> - Número de série já incluído.</td><td></td>
			</tr>",
		);

	}else{

		$ins = "INSERT into tb_nserie 
		(n_serie, ds_emb_primaria, id_col, id_produto, nm_fornecedor, fl_status, fl_empresa, usr_create, dt_create) 
		values 
		('$nr_serial', '$nr_pallet', '$id_col', '$cod_prd', '$nm_for', 'A', '$cod_cli', '$id_usr', '$date')";
		$res_ins = mysqli_query($link, $ins);

		if(mysqli_affected_rows($link) > 0){

			$sql_conf = "select count(id) as conf 
			from tb_nserie
			where fl_status = 'A' and id_col = '$id_col'";
			$res_conf = mysqli_query($link, $sql_conf);
			$dados_conf = mysqli_fetch_assoc($res_conf);
			$saldo 	= $dados_conf['conf'];

			$retorno = array(
				'info'		=> "0",
				'text' 		=> "<tr style='background-color: #98FB98'>
				<td>N.série: ".$nr_serial."</td><td>Data: ".$date."</td>
				<td style='text-align:center'><button data-role='none' value='".$nr_serial."' id='btnDelSerialLight'>EXCLUIR</button></td>
				</tr>",
				'conf' 		=> $saldo,
				'id_col' 	=> $id_col,
			);

		}else{

			$retorno = array(
				'info'		=> "1",
				'text' => "<h3 style='background-color:#FF7F50'>Erro na inclusão do número de série.</h3>",
			);

		}

	}

}else{

    $retorno = array(
		'info'		=> "2",
        'info' => "<h3 style='background-color:#FF7F50'>Favor informar o número de série!</h3>",
    );

}

echo(json_encode($retorno));

$link->close();
?>