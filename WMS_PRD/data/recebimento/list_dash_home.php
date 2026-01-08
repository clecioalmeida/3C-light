<?php include "chart_home_qtd.php";?>
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