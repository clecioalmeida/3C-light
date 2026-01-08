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

$id_rec = $_REQUEST['id_rec'];

foreach ($_REQUEST['cod_nf_item'] as $c) {

	$SQL = "select cod_nf_entrada_item from tb_nf_entrada where cod_nf_entrada";
	$res = mysqli_query($link,$SQL);

	$query_qtde="select t1.cod_recebimento, t3.produto, coalesce(t3.nr_volume,0) as nr_qtde, t3.cod_nf_entrada_item
	from tb_recebimento t1
	left join tb_nf_entrada_item t3 on t1.cod_recebimento = t3.cod_rec
	where t3.fl_status = 'A' and t3.cod_nf_entrada_item = '$c' and t3.nr_volume is not null
	group by t3.cod_nf_entrada_item";
	$qtde = mysqli_query($link,$query_qtde);
	while ($dados=mysqli_fetch_assoc($qtde)) {

		for ($i = 1; $i <= $dados['nr_qtde']; $i++) {

			$cod_etq =  uniqid();
			$cod_nf_entrada_item 	= $dados['cod_nf_entrada_item'];
			$cod_rec 				= $dados['cod_recebimento'];

			$ins_etq="insert into tb_etiqueta (nr_docto, cod_item, nr_seq, fl_status, cod_etq, cod_rec, fl_empresa, usr_create, dt_create) values ('$c', '$cod_nf_entrada_item', '$i', 'A', '$cod_etq', '$cod_rec', '$cod_cli', '$id', '$date')";
			$etq = mysqli_query($link,$ins_etq);

			if(mysqli_affected_rows($link) > 0){

				$upd_it="update tb_nf_entrada_item set fl_status = 'T' where cod_nf_entrada_item = '$cod_nf_entrada_item'";
				$res_it = mysqli_query($link,$upd_it);

			}

		}
	}

}

$sql_vol = "select sum(t1.nr_volume) as total_volume
from tb_nf_entrada_item t1
where t1.cod_rec = '$id_rec' and fl_status <> 'E'
group by t1.cod_rec";
$res_vol = mysqli_query($link, $sql_vol);
$dados_vol = mysqli_fetch_assoc($res_vol);
$nr_qtde    = $dados_vol['total_volume'];

$sql_etq = "select count(t2.id) as total_etq
from  tb_etiqueta t2
where t2.cod_rec = '$id_rec' and fl_status <> 'E'";
$res_etq = mysqli_query($link, $sql_etq);
$dados_etq = mysqli_fetch_assoc($res_etq);
$nr_alocado = $dados_etq['total_etq'];


if$nr_qtde == $nr_alocado){

	echo '<h3 style="background-color:#9AFF9A">Etiquetas geradas com sucesso.</h3>';

}else{

	echo "<h3>Algumas etiquetas não foram geradas.</h3>";

}
$link->close();
?>