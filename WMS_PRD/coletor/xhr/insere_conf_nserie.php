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
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_serial 	= $_POST['nr_serial'];
$nr_ped 	= $_POST['nr_ped'];
$ds_end 	= $_POST['ds_end'];

if($cod_cli == '3'){

	$ds_centro    = '1300';
	$ds_deposito  = '1310';

}else if($cod_cli == '4'){

	$ds_centro    = '5500';
	$ds_deposito  = '5510';

}

$sql = "select t1.id_produto, t2.nm_produto, t1.status_sap, t1.ds_centro, t1.ds_deposito, t1.status_usr 
from tb_nserie t1
left join tb_produto t2 on t1.id_produto = t2.cod_prod_cliente
 where t1.n_serie = '$nr_serial' and t1.fl_status = 'A'";
$res = mysqli_query($link, $sql);
$dados = mysqli_fetch_assoc($res);
$status_sap 	= $dados['status_sap'];
$status_usr 	= $dados['status_usr'];
$id_produto 	= $dados['id_produto'];
$nm_produto 	= $dados['nm_produto'];
$ds_centro 		= $dados['ds_centro'];
$ds_deposito 	= $dados['ds_deposito'];

if($dados['status_sap'] == 'DEPS' && $dados['status_usr'] == 'DEPS' && $dados['ds_centro'] == $ds_centro && $dados['ds_deposito'] == $ds_deposito){

	$upd = "update tb_nserie set cod_pedido = '$nr_ped', fl_status = 'C' where id_produto = '$id_produto' and n_serie = '$nr_serial'";
	$res_upd = mysqli_query($link, $upd);

	if(mysqli_affected_rows($link) > 0){

		$sql_conf = "select count(id) as conf 
		from tb_nserie
		where cod_pedido = '$nr_ped' and fl_status = 'C'";
		$res_conf = mysqli_query($link, $sql_conf);
		$dados_conf = mysqli_fetch_assoc($res_conf);
		$saldo 	= $dados_conf['conf'];
		

		$retorno = array(
			'info'		=> "<p style='background-color: #98FB98'> Produto: ".$id_produto." N.série: ".$nr_serial."</p>",
			'text' 		=> "<p style='background-color: #98FB98'>N.série:".$nr_serial." inserido.</p>",
			'conf' 		=> "Selecionado: ".$saldo,
			'saldo' 	=> "Endereço: ".$ds_end." Itens a coletar: ".$saldo,
			'produto'	=> $id_produto." - ".$nm_produto,
		);

	}else{

		$retorno = array(
			'text' => "<p style='background-color: #FF7F50'>Erro na inclusão do número de série no pedido.</p>",
		);

	}

}else{

	$retorno = array(
		'text' => "<p style='background-color: #FF7F50'>N.série:".$nr_serial." não pode ser utilizado.</p>",
	);

}

echo(json_encode($retorno));

$link->close();
?>