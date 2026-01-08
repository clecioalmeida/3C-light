<?php 
	require_once('bd_class_dsv.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_pos = $_REQUEST['id_pos'];
	$id_torre = $_REQUEST['id_torre'];

	$big_select="set sql_big_selects=1";
	$res_select = mysqli_query($link,$big_select);
	
	$sql_parte_inv = "select t1.id_torre, t1.id_parte, t1.id_item, t1.nr_posicao, t2.parte, t2.id
					from tb_item_torre t1
					left join tb_tp_torre t2 on t1.id_parte = t2.id
					left join tb_produto t3 on t1.id_item = t3.id_torre or t1.id_item = t3.cod_produto
					where t1.nr_posicao = '$id_pos' and t1.id_torre = '$id_torre' and t3.fl_status <> 'E'
					order by t2.parte";
	$res_parte_inv = mysqli_query($link, $sql_parte_inv);
	
	while ($parte_inv=mysqli_fetch_assoc($res_parte_inv)) {
		$array_parte_inv[] = array(
			'id'	=> $parte_inv['id_parte'],
			'parte' => $parte_inv['parte'],
		);
	}
	
	echo(json_encode($array_parte_inv));
$link->close();
?>