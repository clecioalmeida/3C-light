<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id = $_SESSION["id"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

if(isset($_POST['cod_rec'])){

	$barcode = $_POST['barcodeAloc'];
	$cod_rec = $_POST['cod_rec'];
	$nr_qtde = $_POST['nr_qtde'];
	$id_endereco = $_POST['id_endereco'];

}else if(isset($_GET['cod_rec'])){

	$barcode = $_GET['barcodeAloc'];
	$cod_rec = $_GET['cod_rec'];
	$nr_qtde = $_GET['nr_qtde'];
	$id_endereco = $_GET['id_endereco'];
}

$array = explode('-', $barcode);

if(isset($array[0]) && isset($array[1])){

	$produto =  $array[0];
	$id_etq = $array[1];

	$sql_etq = "select count(id) as total_etq, COALESCE(sum(t2.nr_volume),0) as total_vol
	from tb_etiqueta t1
	left join tb_nf_entrada_item t2 on t1.cod_rec = t2.cod_rec
	where t1.cod_rec = '$cod_rec' and t1.fl_status = 'A'";
	$res_id=mysqli_query($link, $sql_etq);

	if(mysqli_num_rows($res_id) == 0){

		$array_estoque = array(

			'info' => "Totas as etiquetas já foram conferidas!",

		);

		echo(json_encode($array_estoque));

		exit();

	}else{

		$sql_id ="select id
		from tb_etiqueta
		where id = '$id_etq' and fl_status = 'A'";
		$res_id = mysqli_query($link, $sql_id);

		if(mysqli_num_rows($res_id) > 0){

			$upd_etq = "update tb_etiqueta set fl_status = 'L', id_end = '$id_endereco', usr_conf = '$id', dt_conf = '$date' where id = '$id_etq'";
			$res_etq = mysqli_query($link,$upd_etq);

			if(mysqli_affected_rows($link) > 0){

				$sql_l ="select count(id) as total_conf
				from tb_etiqueta
				where cod_rec = '$cod_rec' and fl_status = 'L'";
				$res_l = mysqli_query($link, $sql_l);

				$init = mysqli_fetch_assoc($res_l);
				$count = $init['total_conf'];

				$array_estoque = array(

					'count' => $count,
					'info' => "0",

				);

			}else{

				$array_estoque = array(

					'info' => "1",

				);

			}

		}else{

			$array_estoque = array(

				'info' => "2",

			);

		}

	}

}else{

	$array_estoque = array(

		'info' => "2",

	);

}

echo(json_encode($array_estoque));

$link->close();
?>