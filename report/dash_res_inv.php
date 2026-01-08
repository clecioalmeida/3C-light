<?php include 'chart_res_inv.php';?>
<fieldset>
</fieldset>
<fieldset>
  <section>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="">
      <header>
        <span class="widget-icon"></span>
        <h2 style="color: white">APURAÇÃO DE INVENTÁRIOS - ANO ATUAL</h2>
      </header>
      <div>
        <div class="widget-body no-padding">
          <div id="dash_cr_mes" class="chart no-padding"></div>
        </div>
      </div>
    </div> 
  </section>
</fieldset>
<script type="text/javascript">
  var data =<?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'dt_inv',
    ykeys: ['nr_ac_qtd','nr_ac_end'],
    labels: ['Acuracidade por quantidade','Acuracidade por endereço'],
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
  config.element = 'dash_cr_mes';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config).on('click', function(i, row){
    var Thisdt_inv = row.dt_inv;
    $.ajax
    ({
      url:"modal/m_dtl_inv.php",
      method:"POST",
      data:{dt_inv:Thisdt_inv},
      success:function(data)
      {
        $('#retModalDash').html(data);
      }
    });
  });
</script>