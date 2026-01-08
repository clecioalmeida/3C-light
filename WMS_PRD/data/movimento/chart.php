<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

	header("Location:index.php");
	exit;

}else{

	$id      = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];
}
?>
<?php
/*$path = $_SERVER['DOCUMENT_ROOT'] . '/dsv/3c_rj/WMS_DSV\\';

$file = $path . 'bd_class.php';*/

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

/* Pedidos por mês */

$pedido_mes = "select
case MONTH(dt_pedido)
when 1 then 'Janeiro'
when 2 then 'Fevereiro'
when 3 then 'Março'
when 4 then 'Abril'
when 5 then 'Maio'
when 6 then 'Junho'
when 7 then 'Julho'
when 8 then 'Agosto'
when 9 then 'Setembro'
when 10 then 'Outubro'
when 11 then 'Novembro'
when 12 then 'Dezembro'
end as mes,
count(nr_pedido) as total, MONTH(dt_pedido) as mes_n
from tb_pedido_coleta
group by YEAR(dt_pedido), MONTH(dt_pedido)";
$res_pedido_mes = mysqli_query($link, $pedido_mes);

//$chart_pedido = '';

while ($pedido = mysqli_fetch_array($res_pedido_mes)) {
	//$chart_pedido .= "{ total:".$dados["total"].", mes:".$dados["mes"]."}, ";
	$array_pedido[] = array(
		'total' => $pedido['total'],
		'mes' => $pedido['mes'],
		'mes_n' => $pedido['mes_n'],
	);
}

//$chart_pedido=substr($chart_pedido, 0, -2);

/* Recebimento por status */

$recebimento_mes = "select
case MONTH(t1.dt_janela)
when 1 then 'Janeiro'
when 2 then 'Fevereiro'
when 3 then 'Março'
when 4 then 'Abril'
when 5 then 'Maio'
when 6 then 'Junho'
when 7 then 'Julho'
when 8 then 'Agosto'
when 9 then 'Setembro'
when 10 then 'Outubro'
when 11 then 'Novembro'
when 12 then 'Dezembro'
end as mes_tipo,
CASE t1.fl_tipo WHEN 'N' THEN count(t1.fl_tipo) END as normal, CASE t2.fl_tipo WHEN 'E' THEN count(t2.fl_tipo) END as extra,
Year(t1.dt_janela) as ano_tipo
from tb_janela t1
left join tb_janela t2 on t1.id = t2.id
where t1.fl_status <> 'A'
group by YEAR(t1.dt_janela), MONTH(t1.dt_janela),MONTH(t2.dt_janela), t1.fl_tipo
order by YEAR(t1.dt_janela), MONTH(t1.dt_janela) asc, t1.fl_tipo desc";
$res_recebimento_mes = mysqli_query($link, $recebimento_mes);


while ($rec = mysqli_fetch_assoc($res_recebimento_mes)) {

	$array_rec[] = array(
		'normal' => $rec['normal'],
		'extra' => $rec['extra'],
		'mes_tipo' => $rec['mes_tipo'],
	);
}

/* Pedidos por status */

/*$pedido_status = "select t3.cod_prod_cliente, t3.nm_produto, sum(t1.nr_qtde) as saldo, sum(t2.nr_qtde) as saida, sum(t2.nr_qtde/90) as nivel, count(distinct t2.nr_pedido) as freq
		from tb_posicao_pallet t1
		left join tb_pedido_coleta_produto t2 on t1.produto = t2.produto
		left join tb_produto t3 on t1.produto = t3.cod_prod_cliente
		where t1.produto > 0 and  t2.dt_create BETWEEN CURDATE() - INTERVAL 90 DAY AND CURDATE()
		group by t1.produto
		order by count(distinct t2.nr_pedido) desc
		limit 0,90";
		$res_pedido_status = mysqli_query($link, $pedido_status);*/

//$chart_pedido_status = '';

/*while ($status = mysqli_fetch_array($res_pedido_status)) {
	$array_status[] = array(
		'nivel' => $status['nivel'],
		'cod_prod_cliente' => $status['cod_prod_cliente'],
		'freq' => $status['freq'],
	);
}*/

//$chart_pedido_status=substr($chart_pedido_status, 0, -2);

// ------ PAINEL PÁGINA HOME ----->

$sql_status = "select
case fl_status
when 'A' then 'ABERTO'
when 'P' then 'FINALIZADO'
when 'X' then 'EXPEDIÇÃO'
when 'C' then 'AG. COLETA'
when 'M' then 'COL. INICIADA'
when 'F' then 'COLETADO'
end as tr_status,
count(cod_pedido) as total_status, (select count(cod_pedido) as total from tb_pedido_coleta) as total
from tb_pedido_coleta
where fl_status <> 'L' and fl_status <> 'D' and fl_status <> 'E'
group by fl_status";
$res_status = mysqli_query($link, $sql_status);

$sql_tempo_a = "SELECT avg(DATEDIFF(dt_exp, dt_create)) as tempo_total FROM tb_pedido_coleta_produto where dt_exp is not null";
$tempo_a = mysqli_query($link, $sql_tempo_a);

$sql_tempo_b = "SELECT avg(DATEDIFF(dt_init_col, dt_create)) as inicio_coleta FROM tb_pedido_coleta_produto where dt_init_col is not null";
$tempo_b = mysqli_query($link, $sql_tempo_b);

$sql_tempo_c = "SELECT avg(DATEDIFF(dt_fim_coleta, dt_init_col)) as tempo_coleta FROM tb_pedido_coleta_produto where dt_fim_coleta is not null and dt_init_col is not null";
$tempo_c = mysqli_query($link, $sql_tempo_c);

$sql_rec_a = "select avg(DATEDIFF(t3.dt_rec, t1.dt_user_criado_por)) as tempo_total
from tb_recebimento t1
left join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec
left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
where YEAR(NOW()) and MONTH(t1.dt_user_criado_por) > 1
and t1.dt_user_conferido_por is not null and t3.dt_rec is not null";
$rec_a = mysqli_query($link, $sql_rec_a);

$sql_rec_b = "select avg(DATEDIFF(t1.dt_user_conferido_por, t1.dt_user_criado_por)) as tempo_rec
from tb_recebimento t1
left join tb_nf_entrada t2 on t1.cod_recebimento = t2.cod_rec
left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
where YEAR(NOW()) and MONTH(t1.dt_user_criado_por) > 1
and t1.dt_user_conferido_por is not null and t3.dt_rec is not null";
$rec_b = mysqli_query($link, $sql_rec_b);

$sql_status_rec = "select
case fl_status
when 'A' then 'ABERTO'
when 'C' then 'CONFERÊNCIA'
when 'F' then 'RECEBIDO'
end as tr_status_rec,
count(COD_RECEBIMENTO) as total_status_rec, (select count(COD_RECEBIMENTO) as total from tb_recebimento) as total_rec
from tb_recebimento
group by fl_status";
$res_status_rec = mysqli_query($link, $sql_status_rec);

/*$ped_tempo_b = "select day(t1.dt_limite) as dia, avg(DATEDIFF(t3.dt_entrega, t1.dt_limite)) as tempo_b
	from tb_pedido_coleta t1
	left join tb_nf_saida t2 on t1.nr_pedido = t2.nr_pedido
	left join tb_entrega t3 on t2.nr_nf_formulario = t3.nr_nf
	where t3.dt_entrega > 0
	group by MONTH(t1.dt_limite), DAY(t1.dt_limite)";
$ped_b = mysqli_query($link, $ped_tempo_b);

while ($pedido_entrega = mysqli_fetch_array($ped_b)) {
	$array_entrega[] = array(
		'ped_dia' => $pedido_entrega['dia'],
		'tempo_b' => $pedido_entrega['tempo_b'],
		'prazo' => 2,
	);
}*/

$ped_ocor = "select day(dt_abertura) as dia, count(cod_ocorrencia) as total
from tb_ocorrencias where tipo = 'T' and fl_status = 'A'
group by day(dt_abertura), month(dt_abertura)";
$ocor = mysqli_query($link, $ped_ocor);

while ($ocorrencia = mysqli_fetch_array($ocor)) {
	$array_ocor[] = array(
		'dia' => $ocorrencia['dia'],
		'total' => $ocorrencia['total'],
		'target' => 3,
	);
}

/*$query_giro = "select produto, total, media, (total/media) as giro
from (select produto, sum(qtd_ped) as total, avg(nr_saldo) as media from tb_giro
WHERE nr_mes >=  MONTH(now()) - 13 group by produto) virtual
where total > 0
order by giro desc
limit 0,10";
$res_gir = mysqli_query($link, $query_giro);

while ($giro = mysqli_fetch_array($res_gir)) {
	$array_giro[] = array(
		'produto' => $giro['produto'],
		'total' => $giro['total'],
		'giro' => $giro['giro'],
		//'target' => 0,
	);
}*/

/*$query_tempo = "select produto, (total/media) as giro, tempo
from (select produto, sum(qtd_ped) as total, avg(nr_saldo) as media,
(DATEDIFF(MAX(dt_mes), MIN(dt_mes))/(sum(qtd_ped)/avg(nr_saldo))) as tempo
from tb_giro
WHERE nr_mes >=  DAY(now()) - 395 group by produto) virtual
where total > 0
order by giro desc
limit 0,10";
$res_tempo = mysqli_query($link, $query_tempo);

while ($tempo = mysqli_fetch_array($res_tempo)) {
	$array_tempo[] = array(
		'produto' => $tempo['produto'],
		'tempo' => $tempo['tempo'],
		'giro' => $tempo['giro'],
	);
}*/

$sql_ped_fin = "select date_format(dt_create, '%d/%m/%Y') as data, count(nr_pedido) as total
from tb_pedido_coleta where fl_status <> 'E' and fl_status <> 'F' and fl_empresa = '$cod_cli' and date(dt_create)
    BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -30 DAY) AND CURRENT_DATE()
group by date(dt_create)";
$res_ped_fin = mysqli_query($link, $sql_ped_fin);

while ($pedido = mysqli_fetch_array($res_ped_fin)) {
	$array_pedido_fin[] = array(
		'data' => $pedido['data'],
		'total' => $pedido['total'],
	);
}

$link->close();
?>
