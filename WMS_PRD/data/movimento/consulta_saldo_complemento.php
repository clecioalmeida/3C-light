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

$cod_prod_cliente = $_POST["prod_cliente"];

$sql_prod = "select cod_produto, nm_produto, cod_prod_cliente
from tb_produto
where cod_prod_cliente = '$cod_prod_cliente'";
$res_sql = mysqli_query($link, $sql_prod);

if(mysqli_num_rows($res_sql) > 0){

	$produto = mysqli_fetch_assoc($res_sql);
	$cod_prd = $produto['cod_produto'];
	$nm_produto = $produto['nm_produto'];

	$prod = "select coalesce(sum(t1.nr_volume),0) as volume,coalesce(sum(t1.nr_qtde),0) as item
	from tb_posicao_pallet t1 
	where t1.produto = '$cod_prod_cliente' and t1.nr_qtde > 0 and fl_bloq <> 'S'
	group by t1.produto";
	$res_prod = mysqli_query($link, $prod);
	$dados_prod = mysqli_fetch_assoc($res_prod);
	$item = $dados_prod['item'];

	$sel_prod = "select COALESCE(sum(nr_qtde),0) as reservado from tb_pedido_coleta_produto where fl_empresa = '$cod_cli' and produto = '$cod_prod_cliente' and (fl_status <> 'F' and fl_status <> 'E')";
	$res = mysqli_query($link, $sel_prod);
	$produto = mysqli_fetch_assoc($res);
	$reservado = $produto['reservado'];

	$saldo = $item-$reservado;

	$info = '<h4 style="background-color: #98FB98;text-align: center">Produto: '.$nm_produto.' | Estoque: '.$item.' | Reservado: '.$reservado.' | Saldo: '.$saldo.'</h4>';

	$array_dest[] = array(
		'texto' => $info,
		'info' => 0,
		'cod_produto'	=> $cod_prd,
		'cod_prod_cliente'	=> $cod_prod_cliente,
		'nm_produto' => $nm_produto,
		'saldo' => $saldo,
	);
	/*echo $item."<br>";
	echo $reservado."<br>";
	echo $saldo."<br>";*/

}else{

	$info = '<h4 style="background-color: #98FB98;text-align: center">Produto não encontrado.</h4>';

	$array_dest[] = array(
		'texto' => $info,
		'info' => 1,
		'cod_produto'	=> "",
		'cod_prod_cliente'	=> "",
		'nm_produto' => "",
		'saldo' => "",
	);

}

echo(json_encode($array_dest));

$link->close();
?>