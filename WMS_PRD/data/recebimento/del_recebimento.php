<?php
require_once("bd_class.php");

$objDb = new db();
$link = $objDb->conecta_mysql();

$del_rec = $_POST["del_rec"];


$sql = "update tb_recebimento set fl_status = 'E' WHERE cod_recebimento = '$del_rec'";
$res_sql = mysqli_query($link, $sql);

if($res_sql){


	$sql_nf="update tb_nf_entrada set fl_status = 'E' WHERE cod_rec = '$del_rec'";
	$res_nf = mysqli_query($link, $sql_nf);

	if($res_nf){

		$query_init="select cod_nf_entrada from tb_nf_entrada where cod_rec = '$del_rec'";
		$res_init=mysqli_query($link, $query_init);
		while ($init=mysqli_fetch_assoc($res_init)) {

			$sql_item="update tb_nf_entrada_item set fl_status = 'E' WHERE cod_nf_entrada = ".$init['cod_nf_entrada']."";
			$res_item = mysqli_query($link, $sql_item);
			
		}

		if($res_item){
			$array_conf = array(
				'info' => "A Ordem de Recebimento notas fiscais e seus itens foram deletados!",
			);

			echo(json_encode($array_conf));
		}else{

			$array_conf = array(
				'info' => "Ocorreu um erron na exclusão dos itens das notas fiscais!",
			);

			echo(json_encode($array_conf));
		}

	}else{

		$array_conf = array(
			'info' => "Ocorreu um erron na exclusão das notas fiscais!",
		);

		echo(json_encode($array_conf));
	}

}else{

		$array_conf = array(
			'info' => "Ocorreu um erron na exclusão da ordem de recebimento!",
		);

		echo(json_encode($array_conf));

}


$link->close();

?>