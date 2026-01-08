<?php 
	require_once('bd_class.php');

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$SQL = "select pp.*, p.nm_produto from tb_posicao_pallet pp inner join tb_produto p on pp.produto = p.cod_produto where ds_galpao = 'RECEBIMENTO' and ds_prateleira = 'R' and ds_coluna = '1' and ds_altura = '1' and nr_qtde > 0 order by nr_nf_entrada desc, cod_estoque ";

	$res = mysqli_query($link,$SQL); 
	$tr = mysqli_num_rows($res); 

	$link->close();
?>
