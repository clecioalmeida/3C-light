<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$id_torre = $_REQUEST['id_torre'];

	$query="SET SQL_BIG_SELECTS=1";
	$res_query=mysqli_query($link, $query);

	$sql_conjunto = "select t1.id_torre, t1.id_parte, t1.id_item, t1.nr_posicao, t2.cod_produto, t2.nm_produto, t2.compr, t2.peso from tb_item_torre t1 
	left join tb_produto t2 on t1.id_item = t2.id_torre 
	where t1.id_torre = '$id_torre' group by t1.id_item
	order by t1.nr_posicao";
	$res_conjunto = mysqli_query($link, $sql_conjunto);

	while ($conjunto=mysqli_fetch_assoc($res_conjunto)) {
		$array_conjunto[] = array(
			'cod_produto'	=> $conjunto['cod_produto'],
			'id_parte' => $conjunto['id_parte'],
			'nm_produto' => $conjunto['nm_produto'],
			'id_item' => $conjunto['id_item'],
			'nr_posicao' => $conjunto['nr_posicao'],
			'compr' => $conjunto['compr'],
			'peso' => $conjunto['peso'],
		);
	}

	echo(json_encode($array_conjunto));