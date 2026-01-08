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

$id_tar = $_POST['id_tar'];

$sql_etq="select t1.id
from tb_etiqueta t1
where t1.id_tar = '$id_tar'";
$res_etq = mysqli_query($link,$sql_etq);

if(mysqli_num_rows($res_etq) > 0){

	echo '<h3 style="background-color:#9AFF9A">Etiquetas já foram geradas.</h3>';

}else{

	$query_qtde="select t1.cod_prod_cliente, t1.nm_produto, t2.nr_volume, t1.cod_produto 
	from tb_produto t1
	left join tb_inv_tarefa t2 on t1.cod_produto = t2.id_produto
	where t2.id = '$id_tar'";
	$qtde = mysqli_query($link,$query_qtde);
	while ($dados=mysqli_fetch_assoc($qtde)) {

		$cod_produto = $dados['cod_produto'];

		for ($i = 1; $i <= $dados['nr_volume']; $i++) {

			$cod_etq =  uniqid();

			$ins_etq="insert into tb_etiqueta (cod_item, id_tar, nr_seq, fl_status, cod_etq, usr_create, dt_create) values ('$cod_produto', '$id_tar', '$i', 'A', '$cod_etq', '$id', '$date')";
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