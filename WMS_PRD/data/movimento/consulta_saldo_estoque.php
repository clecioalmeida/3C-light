<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION['cod_cli'];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$cod_prod_cliente = $_POST["cod_cli"];
$cod_Ped = $_POST["cod_Ped"];

$sql_prd = "select produto
from tb_pedido_coleta_produto 
where nr_pedido = '$cod_Ped' and produto = '$cod_prod_cliente' and nr_qtde > 0 and fl_status <> 'E'";
$res_prd = mysqli_query($link, $sql_prd);

if(mysqli_num_rows($res_prd) > 0){

	$info = '<h4 style="background-color: #FA8072;text-align: center;color:white">Produto já existe no pedido.</h4>';

	$array_dest[] = array(
		'texto' 			=> $info,
		'info' 				=> 6,
		'cod_produto'		=> "",
		'cod_prod_cliente'	=> "",
		'nm_produto' 		=> "",
		'saldo' 			=> "",
	);

}else{

	$sql_prod = "select cod_produto, nm_produto, cod_prod_cliente
	from tb_produto
	where cod_prod_cliente = '$cod_prod_cliente' and fl_empresa = '$cod_cli'";
	$res_sql = mysqli_query($link, $sql_prod);

	if(mysqli_num_rows($res_sql) > 0){

		$produto = mysqli_fetch_assoc($res_sql);
		$cod_prd 			= $produto['cod_produto'];
		$nm_produto 		= $produto['nm_produto'];
		$cod_prod_cliente 	= $produto['cod_prod_cliente'];

		$prod = "select round(coalesce(sum(t1.nr_volume),0),0) as volume, round(coalesce(sum(t1.nr_qtde),0),0) as item
		from tb_posicao_pallet t1 
		where t1.produto = '$cod_prod_cliente' and t1.nr_qtde > 0 and COALESCE(fl_bloq,'N') = 'N' and t1.fl_empresa = '$cod_cli'
		group by t1.produto";
		$res_prod = mysqli_query($link, $prod);
		$dados_prod = mysqli_fetch_assoc($res_prod);
		$item = $dados_prod['item'];

		$sel_prod = "select round(COALESCE(sum(nr_qtde),0),0) as reservado from tb_pedido_coleta_produto where fl_empresa = '$cod_cli' and produto = '$cod_prod_cliente' and (fl_status <> 'F' and fl_status <> 'E')";
		$res = mysqli_query($link, $sel_prod);
		$produto = mysqli_fetch_assoc($res);
		$reservado = $produto['reservado'];

		$saldo = $item-$reservado;

		if($saldo <= 0){

			$text = '<h4 style="background-color: #FA8072;text-align: center;color:white">Não há saldo para o produto. Estoque: '.$item.' | Reservado: '.$reservado.' | Saldo: '.$saldo.'</h4>';
			$info = 1;
		}else{

			$text = '<h4 style="background-color: #98FB98;text-align: center">Estoque: '.$item.' | Reservado: '.$reservado.' | Saldo: '.$saldo.'</h4>';
			$info = 0;

		}

		$array_dest[] = array(
			'texto' 			=> $text,
			'info' 				=> $info,
			'cod_produto'		=> $cod_prd,
			'cod_prod_cliente'	=> $cod_prod_cliente,
			'nm_produto' 		=> $nm_produto,
			'saldo' 			=> $saldo,
		);

	}else{

		$info = '<h4 style="background-color: #FA8072;text-align: center;color:white">Produto não encontrado.</h4>';

		$array_dest[] = array(
			'texto' 			=> $info,
			'info' 				=> 2,
			'cod_produto'		=> "",
			'cod_prod_cliente'	=> "",
			'nm_produto' 		=> "",
			'saldo' 			=> "",
		);

	}


}

echo(json_encode($array_dest));

$link->close();
?>