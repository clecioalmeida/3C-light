<?php 
require_once('bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, date_format(t1.dt_recebimento_previsto,'%d/%m/%Y') dt_recebimento_previsto, t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, t1.dt_recebimento_real, t1.nm_user_criado_por, t1.nm_user_conferido_por, t1.lacre, t1.fl_status, t1.ds_obs, t2.cod_cliente, t2.nm_cliente from tb_recebimento t1 left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente where t1.fl_status <> 'F'";

$res = mysqli_query($link,$SQL); 
$tr = mysqli_num_rows($res); 

$link->close();
?>
