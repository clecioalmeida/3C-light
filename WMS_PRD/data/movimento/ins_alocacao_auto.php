<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

$cod_est = $_POST['cod_estoque'];

$retorno = "";

foreach($cod_est as $cod){

	$sql_aloca="select cod_estoque, produto, cod_produto, ds_galpao, nr_qtde, nr_volume, produto, nr_or from tb_posicao_pallet where cod_estoque = '$cod'";
	$res_aloca = mysqli_query($link,$sql_aloca);

	$dados = mysqli_fetch_assoc($res_aloca);
	$qtd_aloc = $dados['nr_qtde']/$dados['nr_volume'];

	$tr = 0;

	for ($i = 0; $i < $dados['nr_volume']; $i++) {

		$sql = "insert into tb_posicao_pallet (produto, cod_produto, ds_galpao, nr_volume, nr_qtde, nr_posicao_temp, nr_or, fl_status, fl_tipo, fl_bloq, fl_empresa, user_update, dt_update) values ('".$dados['produto']."', '".$dados['cod_produto']."', '".$dados['ds_galpao']."', '1', '".$qtd_aloc."', '".$cod."', '".$dados['nr_or']."', 'L', 'T', 'N', '$cod_cli', '$id', '$date')";
		$result_id = mysqli_query($link1, $sql) or die(mysqli_error($link1));

		$tr += mysqli_affected_rows($link1);

		$ncod = mysqli_insert_id($link1);

		if($ncod){

			$query_pedido="insert into tb_aloca (cod_estoque, fl_status, fl_empresa, usr_create, dt_create) values ('$ncod', 'L', '$cod_cli', '$id', '$date')";
			$res_pedido = mysqli_query($link,$query_pedido);

		}

		$upd_aloc="update tb_posicao_pallet set nr_qtde = '0', fl_status = 'E' where cod_estoque = '$cod'";
		$res_aloc = mysqli_query($link,$upd_aloc);

	}

	if($dados['nr_volume'] == $tr){

		$retorno .= "Foram inseridos ".$tr." registros do produto ".$dados['produto'];

	}else{

		$retorno .= "Ocorreu um erro na gravação do volume.";

	}
}

echo $retorno;

$link->close();
$link1->close();
?>