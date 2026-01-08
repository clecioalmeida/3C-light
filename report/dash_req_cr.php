<?php include 'chart_req_cr.php';?>
<fieldset>
</fieldset>
<fieldset>
  <section>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="">
      <header>
        <span class="widget-icon"></span>
        <h2 style="color: white">TOTAL DE REQUISIÇÕES ATENDIDAS POR CENTRO DE CUSTO - ANO ATUAL</h2>
      </header>
      <div>
        <div class="widget-body no-padding">
          <div id="dash_cr_mes" class="chart no-padding" style="height: 300px;"></div>
        </div>
      </div>
    </div> 
  </section>
  <section>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="">
      <header>
        <span class="widget-icon"></span>
        <h2 style="color: white">VALOR TOTAL DE REQUISIÇÕES ATENDIDAS POR CENTRO DE CUSTO - ANO ATUAL</h2>
      </header>
      <div>
        <div class="widget-body no-padding">
          <div id="dash_cr_vlr" class="chart no-padding" style="height: 300px;"></div>
        </div>
      </div>
    </div> 
  </section>
</fieldset>
<script src="js/morris-labeltop.js"></script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'centro_custo',
    ykeys: ['cr_total'],
    labels: ['Total de requisições atendidas'],
    pointSize: 5,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors:function(row, series, type) {
      if(row.y < 100){

        return "#009933";

      }else if(row.y >= 100 && row.y < 500){

        return "#0061B3";

      }else{

         return "#D96123";

      }
    },
    axes: true,
    ymax: 'auto',
    xLabelAngle: '45',
    padding: 40,
    barGap:4,
    barSizeRatio:0.55,
    parseTime: false,    
    labelTop: true 
  };
  config.element = 'dash_cr_mes';
  config.stacked = false;
  config.hideHover = true;
  Morris.Bar(config);
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'centro_custo',
    ykeys: ['vlr_total'],
    labels: ['Valor total atendido'],
    pointSize: 5,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors:function(row, series, type) {
      if(row.y < 100){

        return "#009933";

      }else if(row.y >= 100 && row.y < 500){

        return "#0061B3";

      }else{

         return "#D96123";

      }
    },
    axes: true,
    ymax: 'auto',
    xLabelAngle: '45',
    padding: 40,
    barGap:4,
    barSizeRatio:0.55,
    parseTime: false,    
    labelTop: true 
  };
  config.element = 'dash_cr_vlr';
  config.stacked = false;
  config.hideHover = true;
  Morris.Bar(config);
</script>