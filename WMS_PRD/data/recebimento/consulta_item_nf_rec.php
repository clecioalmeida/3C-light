<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$cod_nf_entrada = $_REQUEST['cod_nfEntrada'];
	
	$sql_itemNf = "select t1.cod_nf_entrada_item, t1.cod_nf_entrada, t4.nr_fisc_ent, t1.nr_qtde, t1.vl_unit, t1.nr_peso_unit, t1.fl_status, t2.cod_prod_cliente, t2.cod_produto, t2.nm_produto, t3.estado 
  from tb_nf_entrada_item t1
  left join tb_produto t2 on t1.produto = t2.cod_produto
  left join tb_estado_produto t3 on t1.estado_produto = t3.id
  left join tb_nf_entrada t4 on t1.cod_nf_entrada = t4.cod_nf_entrada
  where t1.cod_nf_entrada = '$cod_nf_entrada' and t1.fl_status <> 'E'
  group by t1.cod_nf_entrada_item" or die(mysqli_error($sql_itemNf));
	$res_itemNf = mysqli_query($link, $sql_itemNf);
	
	while ($item_nf=mysqli_fetch_assoc($res_itemNf)) {
		$array_itemNf[] = array(
			'cod_nf_entrada' => $item_nf['cod_nf_entrada'],
			'cod_nf_entrada_item' => $item_nf['cod_nf_entrada_item'],
			'nr_fisc_ent' => $item_nf['nr_fisc_ent'],
			'cod_produto' => $item_nf['cod_prod_cliente'],
			'produto' => $item_nf['cod_produto'],
			'nm_produto' => $item_nf['nm_produto'],
			'estado' => $item_nf['estado'],
			'nr_qtde' => $item_nf['nr_qtde'],
			'vl_unit' => $item_nf['vl_unit'],
			'nr_peso_unit' => $item_nf['nr_peso_unit'],
			'fl_status' => $item_nf['fl_status'],
		);
	}
	
	

	echo(json_encode($array_itemNf));
$link->close();
?>