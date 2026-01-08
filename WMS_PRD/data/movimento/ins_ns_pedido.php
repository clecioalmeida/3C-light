<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$link1 = $objDb->conecta_mysql();

if (isset($_POST["nserie"])) {

	$nr_ped = $_POST["nr_ped"];
	$ns_fim = $_POST["ns_fim"];
	$ns_ini = $_POST["ns_ini"];

	$total = count($_POST["nserie"]);

	foreach ($_POST["nserie"] as $value) {

		$sql_ns = "select n_serie from tb_nserie where cod_pedido = '$nr_ped' and n_serie = '$value'" or die(mysqli_error($sql));
		$res_ns = mysqli_query($link1, $sql_ns);

		if(mysqli_num_rows($res_ns) > 0){

			echo "Número de série ".$value." já existe no pedido.";

			goto end;


		}else{

			$sql = "update tb_nserie set cod_pedido = '$nr_ped', fl_status = 'C' WHERE n_serie = '$value'" or die(mysqli_error($sql));
			$resultado_id = mysqli_query($link, $sql);

		}
	}

	$sql_count = "select count(n_serie) as total from tb_nserie where cod_pedido = '$nr_ped'" or die(mysqli_error($sql));
	$res_count = mysqli_query($link, $sql_count);
	$count = mysqli_fetch_assoc($res_count);
	$total_rec = $count['total'];

	if($total_rec > 0){


		$sql_ped = "select id_produto, count(n_serie) as total_prd from tb_nserie where cod_pedido = '$nr_ped' and n_serie >= '$ns_ini' and n_serie <= '$ns_fim' group by id_produto" or die(mysqli_error($sql));
		$res_ped = mysqli_query($link1, $sql_ped);

		while ($dados = mysqli_fetch_assoc($res_ped)) {

			$sql_prod = "insert into tb_pedido_coleta_produto (produto, nr_pedido, nr_qtde, fl_status, usr_create, dt_create) values ('".$dados['id_produto']."', '".$nr_ped."','".$dados['total_prd']."', 'A', '$id', '$date')";
			$res_prod = mysqli_query($link1, $sql_prod); 

		}

		echo "Foram incluídos ".$total_rec." números de série no pedido ".$nr_ped.".";

	}else{
		
		echo "Ocorreu um erro na gravação dos números de série.";

	}

	end:

}

$link->close();
$link1->close();
?>