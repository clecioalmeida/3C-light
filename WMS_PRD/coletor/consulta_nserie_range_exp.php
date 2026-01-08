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

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_serial_ini 	= $_POST['nr_serial_ini'];
$nr_serial_fim 	= $_POST['nr_serial_fim'];
$nr_ped 		= $_POST['nr_ped'];

for ($i=$nr_serial_ini; $i <= $nr_serial_fim; $i++) {

	$sql = "select t1.cod_pedido, t1.n_serie, t1.id_produto, t2.nm_produto
	from tb_nserie t1
	left join tb_produto t2 on t1.id_produto = t2.cod_prod_cliente
	where t1.cod_pedido = '$nr_ped' and t1.n_serie = '$i' and t1.fl_status = 'C'";
	$res = mysqli_query($link, $sql);

	if(mysqli_num_rows($res) > 0){

		$dados = mysqli_fetch_assoc($res);

		$cod_pedido 	= $dados['cod_pedido'];
		$n_serie 		= $dados['n_serie'];
		$id_produto 	= $dados['id_produto'];
		$nm_produto 	= $dados['nm_produto'];

		$upd = "update tb_nserie set fl_status = 'G' where cod_pedido = '$cod_pedido' and n_serie = '$i'";
		$res_upd = mysqli_query($link, $upd);

		if(mysqli_affected_rows($link) > 0){

			$sql_conf = "select count(id) as conf 
			from tb_nserie
			where cod_pedido = '$nr_ped' and fl_status = 'G'";
			$res_conf = mysqli_query($link, $sql_conf);
			$dados_conf = mysqli_fetch_assoc($res_conf);
			$saldo 	= $dados_conf['conf'];

			$retorno[] = array(
				'info'		=> "<p style='background-color: #98FB98'> Produto: ".$id_produto." N.série: ".$i."</p>",
				'text' 		=> "<p style='background-color: #98FB98'>N.série:".$i." inserido.</p>",
				'produto' 	=> $id_produto." - ".$nm_produto,
			);

		}else{

			$retorno[] = array(
				'text' => "<p style='background-color: #FF7F50'>Erro na inclusão do número de série no pedido.</p>",
			);

		}


	}else{

		$retorno[] = array(
			'text' => "<p style='background-color: #FF7F50'>Erro na inclusão do número de série no pedido.</p>",
		);

	}
}

echo(json_encode($retorno));

$link->close();
?>