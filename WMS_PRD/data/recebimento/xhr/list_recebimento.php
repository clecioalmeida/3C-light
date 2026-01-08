<?php
	require_once('bd_class.php');

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$SQL = "select t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, t1.tp_rec, t1.dt_recebimento_previsto,  t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, t1.dt_recebimento_real, t1.nm_user_criado_por, t1.nm_user_conferido_por, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, t1.nm_user_recebido_por, t1.dt_user_recebido_por, t1.nm_user_autorizado_por, t1.dt_user_autorizado_por, t2.cod_cliente, t2.nm_cliente, t3.nm_tipo, t3.cod_tipo 
	from tb_recebimento t1 
	left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
	left join tb_tipo t3 on t1.tp_rec = t3.cod_tipo
	where t1.fl_status ='A'";

	$res = mysqli_query($link,$SQL); 
	$tr = mysqli_num_rows($res); 

/*
	$sql_recebimento = "select t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, dt_recebimento_previsto, t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, t1.dt_recebimento_real, t1.nm_user_criado_por, t1.nm_user_conferido_por, t1.lacre, t1.fl_status, t1.ds_obs, t2.cod_cliente, t2.nm_cliente, t3.*, t4.* from tb_recebimento t1 left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente left join tb_saldo_produto t3 on t1.cod_recebimento = t3.cod_compra_venda left join tb_nf_entrada t4 on t3.nr_nf_entrada = t4.nr_fisc_ent where t2.fl_status = 1 and t3.cod_compra_venda = '$cod_rec'";
		$resultado_nf = mysqli_query($link,$sql_recebimento);
		$tr = mysqli_num_rows($resultado_nf); 
*/
	$link->close();
?>
