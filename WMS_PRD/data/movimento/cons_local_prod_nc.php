<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$produtoNc = $_REQUEST['produtoNc'];
$idGalpao = $_REQUEST['idGalpao'];
$idRua = $_REQUEST['idRua'];
$idColuna = $_REQUEST['idColuna'];
$idAltura = $_REQUEST['idAltura'];

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

$sql_local = "SELECT t1.cod_estoque, t1.produto, t2.ds_apelido, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.nr_qtde, t3.cod_prod_cliente, t3.nm_produto
	from tb_posicao_pallet t1
	left join tb_armazem t2 on t1.ds_galpao = t2.id
	left join tb_produto t3 on t1.produto = t3.cod_produto
	where t1.produto = '$produtoNc' and t1.ds_galpao = '$idGalpao' and t1.ds_prateleira = '$idRua' and t1.ds_coluna = '$idColuna' and t1.ds_altura = '$idAltura'";
$res_local = mysqli_query($link, $sql_local);

while ($local = mysqli_fetch_assoc($res_local)) {
	$array_local[] = array(
		'produto' => $local['produto'],
		'ds_apelido' => $local['ds_apelido'],
		'ds_prateleira' => $local['ds_prateleira'],
		'ds_coluna' => $local['ds_coluna'],
		'ds_altura' => $local['ds_altura'],
		'nr_qtde' => $local['nr_qtde'],
		'cod_prod_cliente' => $local['cod_prod_cliente'],
		'nm_produto' => $local['nm_produto'],
		'cod_estoque' => $local['cod_estoque'],
	);
}

echo (json_encode($array_local));
$link->close();
?>