<?php 
	require_once('bd_class.php');
	
  $login  = $_SESSION["usuario"];
	$cod_estoque = $_GET['cod_estoque'];

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$SQL = "select pp.*, p.nm_produto from tb_posicao_pallet pp inner join tb_produto p on pp.produto = p.cod_produto where cod_estoque = $cod_estoque ";

	$res = mysqli_query($link,$SQL); 
	$tr = mysqli_num_rows($res); 

	$link->close();
?>
