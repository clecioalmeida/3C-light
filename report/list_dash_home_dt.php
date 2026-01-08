<?php 
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$dt_ini = $_POST['dt_ini_hm'];
$dt_fim = $_POST['dt_fim_hm'];
$nr_cr  = $_POST['nr_cr_hm'];

$sql = "SELECT coalesce(t5.cod_grupo,0) as cod_grupo,  case when t5.nm_grupo is null then 'OUTROS' else t5.nm_grupo end as grupo,
              round(sum(COALESCE(t2.nr_qtde,0)),0) as item_total
              from tb_pedido_coleta_produto t2
              left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
              left join tb_grupo t5 on t4.cod_grupo = t5.cod_grupo
              left join tb_pedido_coleta t6 on t2.nr_pedido = t6.nr_pedido
              where t2.fl_status = 'F' and date(t6.dt_create) >= '$dt_ini' and date(t6.dt_create) <= '$dt_fim' and t6.ds_custo = '$nr_cr'
              group by year(t2.dt_create), coalesce(t5.cod_grupo,0)
              order by round(sum(COALESCE(t2.nr_qtde,0)),0) desc";
$res = mysqli_query($link, $sql);
while ($home = mysqli_fetch_assoc($res)) {

	$array_home[] = array(
		'grupo' 	     => $home['grupo'],
		'cod_grupo'      => $home['cod_grupo'],
        'item_total'     => $home['item_total'],
	);

}

$sql1 = "SELECT coalesce(t5.cod_grupo,0) as cod_grupo,  case when t5.nm_grupo is null then 'OUTROS' else t5.nm_grupo end as grupo,
              round(sum(t2.nr_qtde*t2.vl_unit),2) as vlr_total
              from tb_pedido_coleta_produto t2
              left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
              left join tb_grupo t5 on t4.cod_grupo = t5.cod_grupo
              left join tb_pedido_coleta t6 on t2.nr_pedido = t6.nr_pedido
              where t2.fl_status = 'F' and date(t6.dt_create) >= '$dt_ini' and date(t6.dt_create) <= '$dt_fim' and t6.ds_custo = '$nr_cr'
              group by year(t2.dt_create), coalesce(t5.cod_grupo,0)
              order by sum(t2.nr_qtde*t2.vl_unit) desc";
$res1 = mysqli_query($link, $sql1);
while ($home1 = mysqli_fetch_assoc($res1)) {

	$array_home1[] = array(
		'grupo' 	 => $home1['grupo'],
        'cod_grupo'  => $home1['cod_grupo'],
		'vlr_total'  => $home1['vlr_total'],
	);

}

$sql2 = "SELECT coalesce(t5.cod_grupo,0) as cod_grupo,  case when t5.nm_grupo is null then 'OUTROS' else t5.nm_grupo end as grupo,
              round(sum(COALESCE(t2.nr_qtde,0)),0) as item_total, (select round(sum(nr_qtde),0) from tb_pedido_coleta_produto where fl_status = 'F') as total_item
              from tb_pedido_coleta_produto t2
              left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
              left join tb_grupo t5 on t4.cod_grupo = t5.cod_grupo
              left join tb_pedido_coleta t6 on t2.nr_pedido = t6.nr_pedido
              where t2.fl_status = 'F' and date(t6.dt_create) >= '$dt_ini' and date(t6.dt_create) <= '$dt_fim' and t6.ds_custo = '$nr_cr'
              group by year(t2.dt_create), coalesce(t5.cod_grupo,0)
              order by round(sum(COALESCE(t2.nr_qtde,0)),0) desc";
$res2 = mysqli_query($link, $sql2);
while ($home2 = mysqli_fetch_assoc($res2)) {

	$percent1 = number_format(($home2['item_total']/$home2['total_item'])*100,2);

	$array_home2[] = array(
		'grupo' 	 => $home2['grupo'],
		'item_total' => $percent1,
	);

}

$sql3 = "SELECT coalesce(t5.cod_grupo,0) as cod_grupo,  case when t5.nm_grupo is null then 'OUTROS' else t5.nm_grupo end as grupo,
              round(sum(t2.nr_qtde*t2.vl_unit),2) as vlr_total, (select round(sum(nr_qtde*vl_unit),2) from tb_pedido_coleta_produto where fl_status = 'F') as total_vlr
              from tb_pedido_coleta_produto t2
              left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
              left join tb_grupo t5 on t4.cod_grupo = t5.cod_grupo
              left join tb_pedido_coleta t6 on t2.nr_pedido = t6.nr_pedido
              where t2.fl_status = 'F' and date(t6.dt_create) >= '$dt_ini' and date(t6.dt_create) <= '$dt_fim' and t6.ds_custo = '$nr_cr'
              group by coalesce(t5.cod_grupo,0)
              order by sum(t2.nr_qtde*t2.vl_unit) desc";
$res3 = mysqli_query($link, $sql3);
while ($home3 = mysqli_fetch_assoc($res3)) {

	$percent2 = number_format(($home3['vlr_total']/$home3['total_vlr'])*100,2);

	$array_home3[] = array(
		'grupo' 	 => $home3['grupo'],
		'item_total' => $percent2,
	);

}

$sql4 = "SELECT year(t2.dt_create) as ano, round(sum(COALESCE(t2.nr_qtde,0)),0) as item_total
              from tb_pedido_coleta_produto t2
              left join tb_pedido_coleta t6 on t2.nr_pedido = t6.nr_pedido
              where t2.fl_status = 'F' and date(t6.dt_create) >= '$dt_ini' and date(t6.dt_create) <= '$dt_fim' and t6.ds_custo = '$nr_cr'
              group by year(t2.dt_create)";
$res4 = mysqli_query($link, $sql4);
while ($home4 = mysqli_fetch_assoc($res4)) {

	$array_home4[] = array(
		'ano' 	 		 => $home4['ano'],
		'item_total' 	 => $home4['item_total'],
	);

}

$sql5 = "SELECT year(t2.dt_create) as ano, round(sum(t2.nr_qtde*t2.vl_unit),2) as vlr_total
              from tb_pedido_coleta_produto t2
              left join tb_pedido_coleta t6 on t2.nr_pedido = t6.nr_pedido
              where t2.fl_status = 'F' and date(t6.dt_create) >= '$dt_ini' and date(t6.dt_create) <= '$dt_fim' and t6.ds_custo = '$nr_cr'
              group by year(t2.dt_create)";
$res5 = mysqli_query($link, $sql5);
while ($home5 = mysqli_fetch_assoc($res5)) {

	$array_home5[] = array(
		'ano' 	 		 => $home5['ano'],
		'vlr_total' 	 => $home5['vlr_total'],
	);

}

$link->close();
?>

<fieldset>
	<section>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="">
			<header>
				<span class="widget-icon"></span>
				<h2 style="color:white">CONSUMO ANUAL POR GRUPO (QTD)</h2>
			</header>
			<div>
				<div class="widget-body no-padding">
					<div id="dash_grupo_qtd" class="chart no-padding"></div>
				</div>
			</div>
		</div> 
	</section>
	<section>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
			<header>
				<span class="widget-icon"></span>
				<h2 style="color:white">CONSUMO ANUAL POR GRUPO (VALOR)</h2>
			</header>
			<div>
				<div class="widget-body no-padding">
					<div id="dash_grupo_vlr" class="chart no-padding"></div>
				</div>
			</div>
		</div> 
	</section>
	<section>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
			<header>
				<span class="widget-icon"></span>
				<h2 style="color:white">CONSUMO ANUAL POR GRUPO (% QTD)</h2>
			</header>
			<div>
				<div class="widget-body no-padding">
					<div id="dash_percent_qtd" class="chart no-padding"></div>
				</div>
			</div>
		</div> 
	</section>
	<section>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
			<header>
				<span class="widget-icon"></span>
				<h2 style="color:white">CONSUMO ANUAL POR GRUPO (% VALOR)</h2>
			</header>
			<div>
				<div class="widget-body no-padding">
					<div id="dash_percent_vlr" class="chart no-padding"></div>
				</div>
			</div>
		</div> 
	</section>
	<section>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
			<header>
				<span class="widget-icon"></span>
				<h2 style="color:white">CONSUMO ANUAL (QTD)</h2>
			</header>
			<div>
				<div class="widget-body no-padding">
					<div id="dash_qtd_anual" class="chart no-padding"></div>
				</div>
			</div>
		</div> 
	</section>
	<section>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
			<header>
				<span class="widget-icon"></span>
				<h2 style="color:white">CONSUMO ANUAL (VALOR)</h2>
			</header>
			<div>
				<div class="widget-body no-padding">
					<div id="dash_vlr_anual" class="chart no-padding"></div>
				</div>
			</div>
		</div> 
	</section>
</fieldset>

<script type="text/javascript">
	var data =<?php echo json_encode($array_home); ?>,
	config = {
		data: data,
		xkey: 'grupo',
		ykeys: ['item_total'],
		labels: ['Quantidade de itens por grupo'],
		pointSize: 3,
		fillOpacity: 0.6,
		behaveLikeLine: true,
		resize: true,
		axes: true,
		barColors: ['#0061B3'],
		barGap:4,
		barSizeRatio:0.35,
		parseTime: true
	};
	config.element = 'dash_grupo_qtd';
	config.stacked = false;
	config.hideHover = false;
	Morris.Bar(config).on('click', function(i, row){
		var ThisCodgrupo = row.cod_grupo;
		$.ajax
		({
			url:"modal/m_grupo_qtd_anual.php",
			method:"POST",
			data:{cod_grupo:ThisCodgrupo},
			success:function(data)
			{
				$('#retModalDash').html(data);
			}
		});
	});
</script>
<script type="text/javascript">
	var data =<?php echo json_encode($array_home1); ?>,
	config = {
		data: data,
		xkey: 'grupo',
		ykeys: ['vlr_total'],
		labels: ['Valor total por grupo'],
		pointSize: 3,
		fillOpacity: 0.6,
		behaveLikeLine: true,
		resize: true,
		axes: true,
		barColors: ['#D96123'],
		barGap:4,
		barSizeRatio:0.35,
		parseTime: true
	};
	config.element = 'dash_grupo_vlr';
	config.stacked = false;
	config.hideHover = false;
	Morris.Bar(config).on('click', function(i, row){
		var ThisCodgrupo = row.cod_grupo;
		$.ajax
		({
			url:"modal/m_grupo_vlr_anual.php",
			method:"POST",
			data:{cod_grupo:ThisCodgrupo},
			success:function(data)
			{
				$('#retModalDash').html(data);
			}
		});
	});
</script>
<script type="text/javascript">
	var data =<?php echo json_encode($array_home2); ?>,
	config = {
		data: data,
		xkey: 'grupo',
		ykeys: ['item_total'],
		labels: ['Percentual por grupo'],
		pointSize: 3,
		fillOpacity: 0.6,
		behaveLikeLine: true,
		resize: true,
		axes: true,
		barColors: ['#009933'],
		barGap:4,
		barSizeRatio:0.35,
		parseTime: true
	};
	config.element = 'dash_percent_qtd';
	config.stacked = false;
	config.hideHover = false;
	Morris.Bar(config);
</script>
<script type="text/javascript">
	var data =<?php echo json_encode($array_home3); ?>,
	config = {
		data: data,
		xkey: 'grupo',
		ykeys: ['item_total'],
		labels: ['Percentual por grupo'],
		pointSize: 3,
		fillOpacity: 0.6,
		behaveLikeLine: true,
		resize: true,
		axes: true,
		barColors: ['#009933'],
		barGap:4,
		barSizeRatio:0.35,
		parseTime: true
	};
	config.element = 'dash_percent_vlr';
	config.stacked = false;
	config.hideHover = false;
	Morris.Bar(config);
</script>
<script type="text/javascript">
	var data =<?php echo json_encode($array_home4); ?>,
	config = {
		data: data,
		xkey: 'ano',
		ykeys: ['item_total'],
		labels: ['Quantidade total'],
		pointSize: 3,
		fillOpacity: 0.6,
		behaveLikeLine: true,
		resize: true,
		axes: true,
		barColors: ['#009933'],
		barGap:4,
		barSizeRatio:0.35,
		parseTime: true
	};
	config.element = 'dash_qtd_anual';
	config.stacked = false;
	config.hideHover = false;
	Morris.Bar(config);
</script>
<script type="text/javascript">
	var data =<?php echo json_encode($array_home5); ?>,
	config = {
		data: data,
		xkey: 'ano',
		ykeys: ['vlr_total'],
		labels: ['Quantidade total'],
		pointSize: 3,
		fillOpacity: 0.6,
		behaveLikeLine: true,
		resize: true,
		axes: true,
		barColors: ['#009933'],
		barGap:4,
		barSizeRatio:0.35,
		parseTime: true
	};
	config.element = 'dash_vlr_anual';
	config.stacked = false;
	config.hideHover = false;
	Morris.Bar(config);
</script>