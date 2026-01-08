<?php include 'list_qtd_ton.php';?>
<?php include 'chart_qtd_ton.php';?>
<div class="row">
  <fieldset>
    <section>
      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <header>
          <span class="widget-icon"></span>
          <h2>PESO TRANSPORTADO POR DIA - MÊS ATUAL</h2>
        </header>
        <div>
          <div class="widget-body no-padding">
            <div id="dash_total_dia" class="chart no-padding"></div>
          </div>
        </div>
      </div> 
    </section>
    <section>
      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <header>
          <span class="widget-icon"></span>
          <h2>PESO TRANSPORTADO POR MÊS</h2>
        </header>
        <div>
          <div class="widget-body no-padding">
            <div id="dash_total_mes" class="chart no-padding"></div>
          </div>
        </div>
      </div> 
    </section>
    <section>
      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <header>
          <span class="widget-icon"></span>
          <h2>PESO POR DESTINO</h2>
        </header>
        <div>
          <div class="widget-body no-padding">
            <div id="dash_vol_dst" class="chart no-padding"></div>
          </div>
        </div>
      </div> 
    </section>
  </fieldset>
</div>
<div class="row">
  <fieldset>
    <section>
      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <table id="dt_basic" class="table table-bordered" width="100%">
          <thead style="color:black">
            <tr>
              <th style="width: 40px">DATA</th>
              <th style="width: 50px">PESO (t)</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($cte = mysqli_fetch_assoc($res_transp)) {
              ?>
              <tr>
                <td style="text-align: center;"><?php echo $cte['data_vg'];?></td>
                <td style="text-align: right;"><?php echo $cte['nr_peso'];?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div> 
    </section>
    <section>
      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <table id="dt_basic" class="table table-bordered" width="100%">
          <thead style="color:black">
            <tr>
              <th style="width: 40px">MÊS</th>
              <th style="width: 50px">PESO (t)</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($cte_mes = mysqli_fetch_assoc($res_mes)) {
              ?>
              <tr>
                <td style="text-align: center;"><?php echo $cte_mes['mes_vg']."/".$cte_mes['ano_vg'];?></td>
                <td style="text-align: right;"><?php echo $cte_mes['nr_peso'];?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div> 
    </section>
    <section>
      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <table id="dt_basic" class="table table-bordered" width="100%">
          <thead style="color:black">
            <tr>
              <th style="width: 20px">MÊS</th>
              <th style="width: 60px">DESTINO</th>
              <th style="width: 30px">TOTAL DE PESO TRANSPORTADO (t)</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($cte_dst = mysqli_fetch_assoc($res_dest)) {
              ?>
              <tr>
                <td style="text-align: center;"><?php echo $cte_dst['mes_vg']."/".$cte_dst['ano_vg'];?></td>
                <td style="text-align: left;"><?php echo $cte_dst['nm_municipio']."-".$cte_dst['nm_uf'];?></td>
                <td style="text-align: right;"><?php echo $cte_dst['nr_peso'];?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div> 
    </section>
  </fieldset>
</div>
<script type="text/javascript">
  var data =<?php echo json_encode($array_tipo); ?>,
  config = {
    data: data,
    xkey: 'data_man',
    ykeys: ['nr_peso'],
    labels: ['Peso transportado por dia'],
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
  config.element = 'dash_total_dia';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_horas); ?>,
  config = {
    data: data,
    xkey: 'data_veic',
    ykeys: ['nr_peso'],
    labels: ['Peso transportado por mês'],
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
  config.element = 'dash_total_mes';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_local); ?>,
  config = {
    data: data,
    xkey: 'ds_dst',
    ykeys: ['nr_peso'],
    labels: ['Peso transportado por local'],
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
  config.element = 'dash_vol_dst';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>