<?php 
	require_once('bd_class_dsv.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_torre = $_REQUEST['id_torre'];
	
	$sql_pos = "select t1.id, t1.id_item, t1.nr_posicao, t1.nr_qtde, t2.cod_produto, t2.compr, t2.peso from tb_item_torre t1 left join tb_produto t2 on t1.id_item = t2.cod_produto or t1.id_item = t2.id_torre where t1.id_torre = '$id_torre' and t1.fl_status <> 'E' order by t1.nr_posicao, t2.cod_produto asc";
	$res_pos = mysqli_query($link, $sql_pos);
	
	while ($pos=mysqli_fetch_assoc($res_pos)) {
		$array_pos[] = array(
			'nr_posicao' => $pos['nr_posicao'],
			'id' => $pos['id'],
			'nr_qtde' => $pos['nr_qtde'],
			'compr' => $pos['compr'],
			'peso' => $pos['peso'],
			'cod_produto' => $pos['cod_produto'],
			'id_item' => $pos['id_item'],
		);
	}
	
	echo(json_encode($array_pos));
$link->close();
?>