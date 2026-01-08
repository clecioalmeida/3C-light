<?php

require_once("bd_class.php");
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec = 1;//$_POST['cod_rec'];

$query_nf="select count(distinct t1.id) as qtde, sum(t2.nr_volume) as total 
from tb_nf_entrada_conf t1
left join tb_nf_entrada t2 on t1.cod_rec = t2.cod_rec
left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
where t1.cod_rec = '$cod_rec' and t1.fl_status = 'C' and t3.fl_status <> 'E'";
$res_nf = mysqli_query($link, $query_nf);

while ($dados=mysqli_fetch_array($res_nf)) {
	$nr_qtde_nf = $dados['qtde'];
	$total = $dados['total'];
echo $nr_qtde_nf."-".$total;
}
if($total == $nr_qtde_nf){
	/*$sql = "CALL prc_recebimento('$id', '$cod_rec')";
	$result_id = mysqli_query($link, $sql);*/

	/*$upd_or="update tb_recebimento set fl_status = 'F', nm_user_conferido_por = '$id', dt_user_conferido_por = now() where cod_recebimento = '$cod_rec'";
	$res_upd = mysqli_query($link, $upd_or);

	$retorno[] = array(
		'info' => "0",
	);

	echo(json_encode($retorno));*/

}else{

	/*$retorno[] = array(
		'info' => "1",
	);

	echo(json_encode($retorno));*/

}
$link->close();
?>