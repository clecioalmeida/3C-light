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

foreach ($_REQUEST['cod_nf'] as $c) {	

	$query_qtde="select t1.cod_recebimento, t3.produto, coalesce(t3.nr_volume,0) as nr_qtde, t3.nr_qtde as qtde_item, t3.cod_nf_entrada_item
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
			$qtde_item 				= $dados['qtde_item'];

			$ins_etq="insert into tb_etiqueta (nr_docto, cod_item, cod_rec, nr_seq, nr_qtde, fl_status, cod_etq, fl_empresa, usr_create, dt_create) values ('$c', '$cod_nf_entrada_item', '$cod_rec', '$i', '$qtde_item', 'A', '$cod_etq', '$cod_cli', '$id', '$date')";
			$etq = mysqli_query($link,$ins_etq);

		}
	}

	$upd_it="update tb_nf_entrada_item set fl_status = 'T' where cod_nf_entrada_item = '$c' and fl_status <> 'E'";
	$res_it = mysqli_query($link,$upd_it);

}

if($etq){

	echo '<h3 style="background-color:#9AFF9A">Etiquetas geradas com sucesso.</h3>';

}else{

	echo "<h3>Ocorreu um erro.</h3>";

}
$link->close();
?>