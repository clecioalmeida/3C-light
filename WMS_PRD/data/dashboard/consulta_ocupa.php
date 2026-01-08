<?php 
	require_once('bd_class.php');
	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$query="SET SQL_BIG_SELECTS=1";
    $res_query=mysqli_query($link, $query);

	$id_armazem = $_REQUEST['id_armazem'];
	
	$sql_ocupa = "select t1.id, t1.galpao, t1.rua, t1.coluna, t1.altura, t2.cod_estoque
	from tb_endereco t1
	left join tb_posicao_pallet t2 on t1.galpao = t2.ds_galpao and t1.rua = t2.ds_prateleira
	and t1.coluna = t2.ds_coluna and t1.altura = t2.ds_altura
	where t1.galpao = '$id_armazem' and t1.rua = 'A01'
	group by t1.rua, t1.coluna, t1.altura
	order by t1.rua, t1.coluna, t1.altura";
	$res = mysqli_query($link, $sql_ocupa);

	while ($query=mysqli_fetch_array($res)) {
		$array_end[] = array(
		    'rua' => $query['rua'],
		    'end' => array(
		         'coluna' => $query['coluna'],
		         'altura' => $query['altura'],
		       )
		    );
		}
	
	echo(json_encode($array_end));
$link->close();