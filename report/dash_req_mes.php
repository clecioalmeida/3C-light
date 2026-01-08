<?php include 'chart_req_mes.php';?>
<fieldset>
</fieldset>
<fieldset>
  <section>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="">
      <header>
        <span class="widget-icon"></span>
        <h2 style="color: white">TOTAL DE REQUISIÇÕES ATENDIDAS POR MÊS</h2>
      </header>
      <div>
        <div class="widget-body no-padding">
          <div id="dash_req_mes" class="chart no-padding"></div>
        </div>
      </div>
    </div> 
  </section>
</fieldset>
<script type="text/javascript">
  var data =<?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'data_req',
    ykeys: ['req_total'],
    labels: ['Total de requisições atendidas'],
    pointSize: 5,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors: ['#0061B3','#009933','#D96123'],
    axes: false,
    ymax: 'auto',
    xLabelAngle: '45',
    padding: 40,
    barGap:4,
    barSizeRatio:0.55,
    parseTime: false
  };
  config.element = 'dash_req_mes';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>