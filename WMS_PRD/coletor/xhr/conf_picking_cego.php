<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["cod_cli"])) {

	header("Location:../logout.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli=$_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido 		= $_POST['pedido'];
$cod_produto 	= $_POST['prd'];
$qtd 			= $_POST['qtd'];
$galpao 		= $_POST['galpao'];
$barcode 		= $_POST['barcode'];
$nr_qtde_conf 	= $_POST['nr_qtde_conf'];
$cod_estoque 	= $_POST['cod_estoque'];
$local 			= $_POST['local'];
$cod_col 		= $_POST['cod_col'];

$end = explode("-", $local);

if(isset($end[0]) && isset($end[1]) && isset($end[2]) && isset($end[3])){

	$id_end = $end[0];
	$rua 	= $end[1];
	$coluna = $end[2];
	$alt 	= $end[3];

	$query = "SET SQL_BIG_SELECTS=1";
	$res_query = mysqli_query($link, $query);

	$query_col = "select COALESCE(sum(nr_qtde_col),0) as nr_qtde_col
	from tb_coleta_pedido
	where cod_col = '$cod_col' and fl_status <> 'C'";
	$res_col = mysqli_query($link, $query_col);
	while ($col = mysqli_fetch_assoc($res_col)) {
		$qtde_col = $col['nr_qtde_col'];
	}

	$sql_c = "select fl_status
	from tb_pedido_coleta
	where nr_pedido = '$nr_pedido'";
	$res_c = mysqli_query($link, $sql_c);

	$status = mysqli_fetch_assoc($res_c);

	if($status['fl_status'] != 'M'){

		$sql_ini = "update tb_pedido_coleta set fl_status = 'M', usr_init_col = '$id', dt_init_col = '$date' where nr_pedido = '$nr_pedido'";
		$res_ini = mysqli_query($link, $sql_ini);

	}

	if ($qtde_col == $nr_qtde_conf) {

		$upd_col = "insert into tb_pedido_conferencia (nr_pedido, cod_col, produto, ds_prateleira, ds_coluna, ds_altura, nr_qtde, fl_conferido, fl_status, usr_create, dt_create) values ('$nr_pedido', '$cod_col', '$barcode', '$rua', '$coluna', '$alt', '$nr_qtde_conf', 'C', 'A', '$id', '$date')";
		$res_col = mysqli_query($link, $upd_col);

		if ($res_col) {

			$upd_conf = "update tb_coleta_pedido set fl_status = 'C' where cod_col = '$cod_col'";
			$res_conf = mysqli_query($link, $upd_conf);

			$sql_prd = "update tb_pedido_coleta_produto set fl_conferido = 'C', usr_fim_conf = '$id', dt_fim_conf = '$date' where produto = '$barcode' and nr_pedido = '$nr_pedido'";
			$res_prd = mysqli_query($link, $sql_prd);

			$query_conf = "select coalesce(sum(nr_qtde),0) as total_conf
			from tb_pedido_conferencia
			where cod_col = '$cod_col' and coalesce(fl_status,'A') <> 'E'";
			$res_sql = mysqli_query($link, $query_conf);
			$tr_conf = mysqli_num_rows($res_sql);

			while ($conf = mysqli_fetch_assoc($res_sql)) {
				$array_estoque = array(
					'info' => "<h3 style='background-color: #98FB98'>Total conferido: ".$conf['total_conf']."</h3>",
				);
			}

			echo (json_encode($array_estoque));
		}

	}else if($qtde_col > $nr_qtde_conf){

		$array_estoque = array(

			'info' => "<h3 style='background-color: #FF7F50'>Conferido: A quantidade coletada é menor que o solicitado!</h3>",
		);

		echo (json_encode($array_estoque));

		exit();

	}else if($qtde_col < $nr_qtde_conf){

		$array_estoque = array(

			'info' => "<h3 style='background-color: #FF7F50'>Conferido: A quantidade coletada é maior que o solicitado! ".$qtde_col."-".$nr_qtde_conf."</h3>",
		);

		echo (json_encode($array_estoque));

		exit();

	}

}else{

	$array_estoque = array(

		'info' => "<h3 style='background-color: #FF7F50'>O endereço não foi digitado corretamente.</h3>",
	);

	echo (json_encode($array_estoque));

	exit();

}

?>