<?php
$date = date('m');

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$query_transp = "SELECT date_format(t1.dt_conhecimento, '%d/%m/%Y') as data_vg, round(sum(t1.nr_peso_kg)/1000,2) as nr_peso, sum(t1.vl_total_frete) as total_fat
from tb_conhecimento t1
where month(t1.dt_conhecimento) = '$date' and t1.nr_fatura > 0
group by day(t1.dt_conhecimento)";
$res_transp = mysqli_query($link, $query_transp);

$query_mes = "SELECT month(t1.dt_conhecimento) as mes_vg, year(t1.dt_conhecimento) as ano_vg, round(sum(t1.nr_peso_kg)/1000,2) as nr_peso, sum(t1.vl_total_frete) as total_fat
from tb_conhecimento t1
where month(t1.dt_conhecimento) = '$date' and t1.nr_fatura > 0
group by month(t1.dt_conhecimento)";
$res_mes = mysqli_query($link, $query_mes);

?>
<?php include 'chart_vol_fat.php';?>
<div class="row">
  <fieldset>
    <section>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
        <header>
          <span class="widget-icon"></span>
          <h2>TRANSPORTE - VOLUME X FATURAMENTO</h2>
        </header>
        <div>
          <div class="widget-body no-padding">
            <div id="dash_vol_fat" class="chart no-padding"></div>
          </div>
        </div>
      </div> 
    </section>
    <section>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
        <header>
          <span class="widget-icon"></span>
          <h2>TRANSPORTE - VOLUME X FATURAMENTO</h2>
        </header>
        <div>
          <div class="widget-body no-padding">
            <div id="dash_total_mes" class="chart no-padding"></div>
          </div>
        </div>
      </div> 
    </section>
  </fieldset>
</div>
<div class="row">
  <fieldset>
    <section>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <table id="dt_basic" class="table table-bordered" width="100%">
          <thead style="color:black">
            <tr>
              <th style="width: 40px">DATA</th>
              <th style="width: 40px">TOTAL DE PESO TRANSPORTADO (t)</th>
              <th style="width: 50px">TOTAL FATURADO (R$)</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($cte = mysqli_fetch_assoc($res_transp)) {
              ?>
              <tr>
                <td style="text-align: center;"><?php echo $cte['data_vg'];?></td>
                <td style="text-align: right;"><?php echo $cte['nr_peso'];?></td>
                <td style="text-align: right;"><?php echo $cte['total_fat'];?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div> 
    </section>
    <section>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <table id="dt_basic" class="table table-bordered" width="100%">
          <thead style="color:black">
            <tr>
              <th style="width: 40px">MÊS</th>
              <th style="width: 40px">TOTAL DE PESO TRANSPORTADO (t)</th>
              <th style="width: 50px">TOTAL FATURADO (R$)</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($cte_mes = mysqli_fetch_assoc($res_mes)) {
              ?>
              <tr>
                <td style="text-align: center;"><?php echo $cte_mes['mes_vg']."/".$cte_mes['ano_vg'];?></td>
                <td style="text-align: right;"><?php echo $cte_mes['nr_peso'];?></td>
                <td style="text-align: right;"><?php echo $cte_mes['total_fat'];?></td>
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
    ykeys: ['nr_peso','total_fat'],
    labels: ['Peso transportado','Valor faturado'],
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
  config.element = 'dash_vol_fat';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_horas); ?>,
  config = {
    data: data,
    xkey: 'data_veic',
    ykeys: ['nr_peso','total_fat'],
    labels: ['Peso transportado','Valor faturado'],
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