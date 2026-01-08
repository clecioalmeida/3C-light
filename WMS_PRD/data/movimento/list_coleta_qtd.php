<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

if($_POST['listColeta'] != ""){

	$listColeta = $_POST['listColeta'];
	
	$sql_parte = "select t1.nr_pedido, COALESCE(sum(t1.nr_qtde),0) as tot_qtd, COALESCE(sum(t2.nr_qtde),0) as tot_conf
	from tb_pedido_coleta_produto t1
	left join tb_pedido_conferencia t2 on t1.nr_pedido = t2.nr_pedido and t1.produto = t2.produto
	where t1.nr_pedido = '$listColeta' and (t1.fl_status = 'M' or t1.fl_status = 'D')
	group by t1.nr_pedido";
	$res_parte = mysqli_query($link, $sql_parte);

}else{

	$sql_parte = "select t1.nr_pedido, COALESCE(sum(t1.nr_qtde),0) as tot_qtd, COALESCE(sum(t2.nr_qtde),0) as tot_conf
	from tb_pedido_coleta_produto t1
	left join tb_pedido_conferencia t2 on t1.nr_pedido = t2.nr_pedido and t1.produto = t2.produto
	where (t1.fl_status = 'M' or t1.fl_status = 'D')
	group by t1.nr_pedido";
	$res_parte = mysqli_query($link, $sql_parte);

}	

while ($parte=mysqli_fetch_assoc($res_parte)) {
	$array_parte[] = array(
		'nr_pedido'	=> $parte['nr_pedido'],
		'tot_qtd' => $parte['tot_qtd'],
		'tot_conf' => $parte['tot_conf'],
		'percentual' => ($parte['tot_conf']/$parte['tot_qtd'])*100,
	);
}


echo(json_encode($array_parte));
$link->close();
?>