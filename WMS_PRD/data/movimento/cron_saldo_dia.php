<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id         = $_SESSION["id"];
	$cod_cli    = $_SESSION["cod_cli"];
}

?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d");
$data = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

/*if(date("m") == "01"){

	$year = date("Y")-1;
	$mes = "12";

}else{

	$year = date("Y");
	$mes = date("m")-1;

}*/

$sql_dt = "select produto, fl_empresa, sum(nr_qtde) as saldo from tb_posicao_pallet
where fl_status = 'A' and produto > 0 
group by produto, fl_empresa" or die(mysqli_error($sql_dt));
$res_dt = mysqli_query($link, $sql_dt);

if(mysqli_num_rows($res_dt) > 0){


	while ($dados=mysqli_fetch_assoc($res_dt)) {

		$produto 		= $dados['produto'];
		$saldo 			= $dados['saldo'];
		$fl_empresa 	= $dados['fl_empresa'];

		//$ds_data 		= $year."-".$mes;

		$sql_dt = "insert into tb_fc_saldo_dia (dt_fechamento, cod_produto, nr_saldo, fl_empresa, usr_create, dt_create) values ('$date', '$produto', '$saldo', '$fl_empresa', '999', '$data')" or die(mysqli_error($sql_dt));
		$res_dt = mysqli_query($link, $sql_dt);

	}
		echo "Funciona";

}else{

	echo "Não há dados para mostrar.";

}

$link->close();
?>