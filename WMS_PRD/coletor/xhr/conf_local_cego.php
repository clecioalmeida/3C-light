<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_produto 	= $_POST['prd'];
$local 			= $_POST['local'];
$endereco 		= $_POST['end'];
$nr_pedido 		= $_POST['pedido'];
$galpao 		= $_POST['galpao_conf'];
$rua 			= $_POST['rua_conf'];
$col 			= $_POST['col_conf'];
$alt 			= $_POST['alt_conf'];

$end = explode("-", $local);

if(isset($end[0]) && isset($end[1]) && isset($end[2]) && isset($end[3])){

	$id_end = $end[0];
	$rua = $end[1];
	$col = $end[2];
	$alt = $end[3];

	$local_conf = $galpao.$rua.$col.$alt;

	$sql_end = "select t2.id 
	from tb_coleta_pedido t1
	left join tb_endereco t2 on t1.ds_galpao = t2.galpao and t1.ds_prateleira = t2.rua and t1.ds_coluna = t2.coluna and t1.ds_altura = t2.altura
	where t1.nr_pedido = '$nr_pedido' and t1.produto = '$cod_produto' and t1.ds_galpao = '$galpao' and t1.ds_prateleira = '$rua' and t1.ds_coluna = '$col' and t1.ds_altura = '$alt'";
	$res_end = mysqli_query($link, $sql_end);
	$endereco = mysqli_fetch_assoc($res_end);
	$conf_end = $endereco['id'];

	if($conf_end == $id_end){

		$query_conf = "select coalesce(nr_qtde_conf,0) as total
		from tb_pedido_coleta_produto
		where nr_pedido = '$nr_pedido' and produto = '$cod_produto'";
		$res_conf = mysqli_query($link, $query_conf);
		$tr_conf = mysqli_num_rows($res_conf);

		while ($conf = mysqli_fetch_assoc($res_conf)) {
			$retorno[] = array(
				'total' => $conf['total'],
				'info' => "1",
				'rua' => $rua,
				'col' => $col,
				'alt' => $alt,
			);
		}

		echo (json_encode($retorno));

	}else{

		$retorno[] = array(
			'info' => "<h3 style='background-color:#FF7F50'>Digite o endereço corretamente ou bipe a etiqueta de endereço.</h3>",
		);
		echo (json_encode($retorno));

	}

}else{

	$retorno[] = array(
		'info' => "<h3 style='background-color:#FF7F50'>Digite o endereço corretamente ou bipe a etiqueta de endereço.</h3>",
	);
	echo (json_encode($retorno));

}

$link->close();
?>