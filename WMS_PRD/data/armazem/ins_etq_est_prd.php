<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:../../index.php");
	exit;

}else{

	$id 		= $_SESSION["id"];
	$id_oper 	= $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

foreach ($_REQUEST['cod_est'] as $c) {	

	$query_qtde = "select t1.nr_volume, t1.produto, t1.id_tar, t1.nr_qtde
	from tb_posicao_pallet t1
	where t1.cod_estoque = '$c'";
	$qtde = mysqli_query($link,$query_qtde);
	while ($dados=mysqli_fetch_assoc($qtde)) {

		for ($i = 1; $i <= $dados['nr_volume']; $i++) {

			$cod_etq 	=  uniqid();
			$produto 	= $dados['produto'];

			$ins_etq="insert into tb_etiqueta (
				cod_estoque, nr_seq, nr_qtde, fl_status, cod_etq, usr_create, dt_create
				) values (
					'$c', '$i','$nr_qtde', 'A', '$cod_etq', '$id', '$date'
					)";
			$etq = mysqli_query($link,$ins_etq);

		}
	}
}

if($etq){

	echo '<h3 style="background-color:#9AFF9A">Etiquetas geradas com sucesso.</h3>';

}else{

	echo "<h3>Ocorreu um erro.</h3>";

}
$link->close();
?>