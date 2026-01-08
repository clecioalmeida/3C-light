<?php include 'chart_item_cr.php';?>
<fieldset style="margin-top: -100px">
  <section>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="">
      <h2 style="color:white;text-align: left;">CENTRO DE CUSTO</h2>
      <form class="form-inline" id="formListDashDt">
        <div class="form-group">
          <input type="text" id="nr_cr_it" name="nr_cr_it" class="form-control" placeholder="Centro de custo" style="display:inline;text-align: right;"/>
          <input type="button" class="form-control btn-info" id="btnRetDashItemDtl" value="Pesquisar" style="display:inline"/>
        </div>
      </form>
    </div>
  </section>
</fieldset>
<fieldset>
  <section>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" id="">
      <header>
        <span class="widget-icon"></span>
        <h2 style="color: white">TOTAL DE ITENS ATENDIDOS POR CENTRO DE CUSTO - ANUAL</h2>
      </header>
      <div>
        <div class="widget-body no-padding" id="retDashItCr">
          <div>
            <table style="margin-left: 30px;margin-bottom: -20px">
              <tbody>
                <tr>
                  <td colspan="5" style="color: white">LEGENDA</td>
                </tr>
                <tr>
                  <td style="color: white">2020&nbsp;</td>
                  <td style="background-color: #0061B3;color: #0061B3">2020</td>
                  <td>&nbsp;&nbsp;&nbsp;</td>
                  <td style="color: white">2021&nbsp;</td>
                  <td style="background-color: #009933;color: #009933">2021</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="dash_it_cr" class="chart no-padding" style="height: 300px;"></div>
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
    ykeys: ['qtd_total1','qtd_total2'],
    labels: ['Qtde total de itens atendidos','Qtde total de itens atendidos'],
    pointSize: 5,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors: ['#0061B3','#009933','#D96123'],
    axes: true,
    ymax: 'auto',
    xLabelAngle: '45',
    padding: 40,
    barGap:4,
    barSizeRatio:0.55,
    parseTime: false,    
    labelTop: true 
  };
  config.element = 'dash_it_cr';
  config.stacked = false;
  config.hideHover = true;
  Morris.Bar(config);
</script>