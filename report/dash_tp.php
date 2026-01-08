<?php

require_once 'bd_class_dsv.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

/*$query_transp = "select t1.ds_data, sum(t1.nr_total_sts) as total_st, t2.nr_total_sts as finalizado  
from tb_fc_ag t1
left join tb_fc_ag t2 on t1.ds_data = t2.ds_data and t2.ds_status = 'FINALIZADO' 
where t1.fl_empresa = '$cod_cli' and t2.fl_empresa = '$cod_cli'
group by t1.ds_data";
$res_transp = mysqli_query($link, $query_transp);*/

$link->close();
?>
<?php include 'chart_tp.php';?>
<br><br>
<fieldset>
  <header>
    <h1>ATENDIMENTOS POR TEMPO</h1>
  </header>
</fieldset>
<fieldset>
  <section>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
      <header>
        <span class="widget-icon"></span>
        <h2>TOTAL DE ATENDIMENTOS POR TIPO</h2>
      </header>
      <div>
        <div class="widget-body no-padding">
          <div id="dash_total_tp" class="chart no-padding"></div>
        </div>
      </div>
    </div> 
  </section>
  <section>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
      <header>
        <span class="widget-icon"></span>
        <h2>TOTAL DE ATENDIMENTOS POR PROJETO / TIPO</h2>
      </header>
      <div>
        <div class="widget-body no-padding">
          <div id="dash_hora_prj" class="chart no-padding"></div>
        </div>
      </div>
    </div> 
  </section>
</fieldset>
<script type="text/javascript">
  var data =<?php echo json_encode($array_tipo); ?>,
  config = {
    data: data,
    xkey: 'tr_tipo',
    ykeys: ['total_tar_mes','total_hr_mes'],
    labels: ['Total de atendimentos','Total de horas gastas'],
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
  config.element = 'dash_total_tp';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_horas); ?>,
  config = {
    data: data,
    xkey: 'tr_tipo',
    ykeys: ['total_tar_mes','total_hr_mes'],
    labels: ['Total de atendimentos','Horas gastas'],
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
  config.element = 'dash_hora_prj';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>