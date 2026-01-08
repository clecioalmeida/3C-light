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

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto 	= $_POST['produto'];
$local 			= $_POST['local'];

$end = explode("-", $local);

if(isset($end[0]) && isset($end[1]) && isset($end[2]) && isset($end[3])){

	$id_end = $end[0];
	$rua = $end[1];
	$col = $end[2];
	$alt = $end[3];

	$local_conf = $rua.$col.$alt;

	$sql_end = "select sum(nr_qtde) as saldo_end, produto
	from tb_posicao_pallet
	where ds_prateleira = '$rua' and ds_coluna = '$col' and ds_altura = '$alt' and produto = '$cod_produto' and fl_empresa = '$cod_cli' and fl_status = 'A'";
	$res_end = mysqli_query($link, $sql_end);

	$end = mysqli_fetch_assoc($res_end);

	if($end['saldo_end'] > 0){
		$retorno = array(
			'saldo' => "<h4 style='background-color:#90EE90'>Saldo endereço: ".$end['saldo_end']."</h4>",
			'info' => "1",
			'rua' => $rua,
			'col' => $col,
			'alt' => $alt,
		);

		echo (json_encode($retorno));

	}else{

		$retorno = array(
			'info' => "<h4 style='background-color:#E9967A'>Produto não existe no endereço.</h4>",
		);

		echo (json_encode($retorno));

	}

}else{

	$retorno = array(
		'info' => "<h3 style='background-color:#FF7F50'>Digite o endereço corretamente ou bipe a etiqueta de endereço.</h3>",
	);

	echo (json_encode($retorno));

}

$link->close();
?>