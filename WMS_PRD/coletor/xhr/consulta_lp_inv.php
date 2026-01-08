<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$ds_lp = $_REQUEST['ds_lp'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$sql_parte = "SELECT t1.produto, t1.cod_estoque, t1.ds_kva, t1.n_serie, t1.ds_fabr, t1.ds_ano, COALESCE(t2.unid,'S/INFO') as unid, round(t1.nr_qtde, 0) as nr_qtde
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
where t1.ds_lp = '$ds_lp' and t1.fl_status = 'A'
group by t1.ds_lp";
$res_parte = mysqli_query($link, $sql_parte);

if(mysqli_num_rows($res_parte) > 0){
	
	$parte=mysqli_fetch_assoc($res_parte);

	$retorno = array(
		'info'	  		=> "0",
		'cod_estoque' 	=> $parte['cod_estoque'],
		'produto' 		=> $parte['produto'],
		'kva'	  		=> $parte['ds_kva'],
		'serial'  		=> $parte['n_serie'],
		'fabr'    		=> $parte['ds_fabr'],
		'ano'     		=> $parte['ds_ano'],
	);

}else{

	$retorno = array(
		'info'			=> $ds_lp,
		'cod_estoque' 	=> "",
	);

}

echo(json_encode($retorno));


$link->close();
?>