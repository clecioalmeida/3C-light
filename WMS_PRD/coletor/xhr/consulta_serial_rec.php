<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$ds_lp = $_REQUEST['ds_lp'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql_parte = "SELECT t1.produto, t1.cod_estoque, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, COALESCE(t2.unid,'S/INFO') as unid, round(t1.nr_qtde, 0) as nr_qtde
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
where t1.ds_lp = '$ds_lp' and t1.fl_status = 'A'
group by t1.ds_lp";
$res_parte = mysqli_query($link, $sql_parte);

if(mysqli_num_rows($res_parte) > 0){
	
	$parte=mysqli_fetch_assoc($res_parte);

	$retorno = array(
		'info'	  => $parte['produto'],
		'end'	  => $parte['ds_prateleira'] . "-" . $parte['ds_coluna'] . "-" . $parte['ds_altura'],
		'estoque' => $parte['cod_estoque'],
		'qtde'    => $parte['nr_qtde'],
	);

}else{

	$retorno = array(
		'info'	=> $ds_lp,
	);

}

echo(json_encode($retorno));


$link->close();
?>