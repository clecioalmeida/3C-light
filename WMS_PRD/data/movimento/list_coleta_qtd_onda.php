<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$listColeta = $_POST['listColeta'];
	
	$sql_parte = "select distinct t1.nr_pedido, t2.*, t3.*
		from tb_coleta_pedido t1
		left join vw_progresso_col_a t2 on t1.nr_pedido = t2.nr_pedido
		left join vw_progresso_col_b t3 on t1.nr_pedido = t3.nr_pedido
		where t1.nr_onda > 0";
	$res_parte = mysqli_query($link, $sql_parte);
	
	while ($parte=mysqli_fetch_assoc($res_parte)) {
		$array_parte[] = array(
			'tot_qtd' => $parte['tot_qtd'],
			'tot_conf' => $parte['tot_conf'],
			'percentual' => ($parte['tot_conf']/$parte['tot_qtd'])*100,
		);
	}
	

	echo(json_encode($array_parte));
$link->close();
?>