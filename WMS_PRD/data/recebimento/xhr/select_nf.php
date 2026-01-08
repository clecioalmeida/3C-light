<?php 

 	$cod_rec = $_session['recebimento']['cod_recebimento'];
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();
	$sql_recebimento = "SELECT t1 . * , t2 . * FROM tb_saldo_produto t1 LEFT JOIN tb_produto t2 ON t1.produto = t2.cod_produto where t1.cod_compra_venda = '$cod_rec'";
	$resultado_nf = mysqli_query($link,$sql_recebimento);

$link->close();

?>