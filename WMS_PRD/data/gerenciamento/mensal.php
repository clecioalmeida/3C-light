<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$query = "select t1.produto, sum(t1.nr_qtde) as saldo, sum(t2.nr_qtde) as saida, sum(t3.nr_qtde) as entrada
	from tb_posicao_pallet t1
	left join tb_pedido_coleta_produto t2 on t1.produto = t2.produto
	left join tb_nf_entrada_item t3 on t1.produto = t3.produto
  	where t1.produto > 0 and t1.dt_user_mov >= '2018-01-01 00:00:00'
	group by t1.produto";
$res_saldo = mysqli_query($link, $query);

while ($dados = mysqli_fetch_assoc($res_saldo)) {
	$produto = $dados['produto'];
	$saldo = $dados['saldo'];
	$saida = $dados['saida'];
	$entrada = $dados['entrada'];

	$query_saldo = "insert into tb_giro (produto, nr_mes, dt_mes, qtd_rec, qtd_ped, nr_saldo, dt_create) values ('$produto', 4, now(), '$entrada', '$saida', '$saldo', now())";
	$res_giro = mysqli_query($link, $query_saldo);

}
$link->close();
?>