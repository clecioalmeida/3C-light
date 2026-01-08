<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;

} else {

  $id         = $_SESSION["id"];
  $cod_cli    = $_SESSION["cod_cli"];
}

?>
<?php

require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$query_transp = "select * from tb_fc_est where fl_tipo = 'P' and fl_empresa = '$cod_cli' order by ds_data desc";
$res_transp = mysqli_query($link, $query_transp);

$sql_ocupa = "select date_format(dt_fechamento,'%d-%m-%Y') as dt_fechamento, nr_ocp, nr_ocp_sku, nr_ocp_perc from tb_fc_saldo_dia where fl_tipo = 'P' and fl_empresa = '$cod_cli' and dt_fechamento BETWEEN CURRENT_DATE() -30 AND CURRENT_DATE() order by date(dt_fechamento) desc";
$res_ocp = mysqli_query($link, $sql_ocupa);

$link->close();
?>
<?php include 'chart_ocupa_ext.php';?>
<style type="text/css">
  .teste1 {
    position:relative;
    width:100px;
    height:100px;
    float:left
  }

  .teste2 {
    position:absolute;
    top:25%;
    left:50%;
    transform:translate(-50%,-50%)
  }
</style>
<br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <button type="buttom" id="" class="btn btn-info btn-xs" disabled style="float:left;width: 150px;background-color: #0061B3">NOVO</button>
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Ocupação externa</strong></h1></span>
  <img class="pull-right" src="img/logo3cfaz.png" alt="3Cfaz" style="width: 8%; height: 5%; margin-top: 0px">
</div>
<br><br><br><br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div class="widget-body">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <table id="RepIndDemExcel" class="table" width="100%">
          <thead>
            <tr>
              <th>DATA</th>
              <th>TOTAL SKU'S ARMAZENADOS</th>
              <th>TOTAL OCUPADAS</th>
              <th>% OCUPAÇÃO</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($dados = mysqli_fetch_assoc($res_transp)) {?>
              <tr class="odd gradeX">
                <td style="text-align: left;width:100px"><?php echo $dados['ds_data']; ?></td>
                <td class="ind_ocupa_ext" data-ind="<?php echo $dados['id'];?>" style="text-align: right;width:100px"><?php echo $dados['nr_total_sku']; ?></td>
                <td class="ind_ocupa_ext" data-ind="<?php echo $dados['id'];?>" style="text-align: right;width:100px"><?php echo $dados['nr_pos_ocp']; ?></td>
                <td class="ind_ocupa_ext" data-ind="<?php echo $dados['id'];?>" style="text-align: right;width:100px"><?php echo $dados['nr_ocupa_sku']."%"; ?></td>
              </tr>
            </tbody>
          <?php }?>
        </table>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
        <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
          <header>
            <span class="widget-icon"></span>
            <h2>PERCENTUAL DE OCUPAÇÃO - EXTERNO</h2>
          </header>
          <div>
            <div class="widget-body no-padding">
              <div id="perc_ocupa" class="chart no-padding"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <table id="RepIndDemExcel" class="table" width="100%">
          <thead>
            <tr>
              <th>DATA</th>
              <th>TOTAL SKU'S ARMAZENADOS</th>
              <th>TOTAL OCUPADAS</th>
              <th>% OCUPAÇÃO</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($ocupacao = mysqli_fetch_assoc($res_ocp)) {?>
              <tr class="odd gradeX">
                <td style="text-align: left;width:150px"><?php echo $ocupacao['dt_fechamento']; ?></td>
                <td style="text-align: right;width:100px"><?php echo $ocupacao['nr_ocp_sku']; ?></td>
                <td style="text-align: right;width:100px"><?php echo $ocupacao['nr_ocp']; ?></td>
                <td style="text-align: right;width:100px"><?php echo $ocupacao['nr_ocp_perc']."%"; ?></td>
              </tr>
            </tbody>
          <?php }?>
        </table>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
        <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
          <header>
            <span class="widget-icon"></span>
            <h2>SKU'S ARMAZENADOS</h2>
          </header>
          <div>
            <div class="widget-body no-padding">
              <div id="sku_arm" class="chart no-padding"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"></div> 
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
        <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
          <header>
            <span class="widget-icon"></span>
            <h2>PERCENTUAL DE OCUPAÇÃO POR DIA - INTERNO</h2>
          </header>
          <div>
            <div class="widget-body no-padding">
              <div id="perc_ocupa_dia" class="chart no-padding"></div>
            </div>
          </div>
        </div>
      </div> 
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"></div> 
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
        <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
          <header>
            <span class="widget-icon"></span>
            <h2>TOTAL DE SKU'S ARMAZENADOS POR DIA</h2>
          </header>
          <div>
            <div class="widget-body no-padding">
              <div id="sku_arm_dia" class="chart no-padding"></div>
            </div>
          </div>
        </div>
      </div>
    </div>    
    <!-- meus scripts -->
    <script type="text/javascript">
      $(document).ready(function(){
        $('#BtnIndDemExcel').on('click', function(){
          event.preventDefault();
          $('#BtnIndDemExcel').prop("disabled", true);
          var today = new Date();
          $("#RepIndDemExcel").table2excel({
            exclude: ".noExl",
            name: "Relatório de processamento de notas fiscais - Analítico",
                filename: "Relatório de processamento de notas fiscais - Analítico - " + today //do not include extension
              });
          $('#BtnIndDemExcel').prop("disabled", false);
        });
      });
    </script>
    <script type="text/javascript">
      var data =<?php echo json_encode($array_parte); ?>,
      config = {
        data: data,
        xkey: 'ds_data',
        ykeys: ['nr_ocupa_sku'],
        labels: ['Percentual Ocupação'],hideHover: 'auto',
        pointSize: 3,
        fillOpacity: 0.6,
        hideHover: 'auto',
        behaveLikeLine: true,
        resize: true,
        barColors:function(row, series, type) {
          if(row.y >= 90){

            return "#D96123";

          }else if(row.y < 90 && row.y >= 70){

            return "#009933";

          }else{

            return "#0061B3";

          }
        },
        axes: true,
        barGap:4,
        barSizeRatio:0.35,
        parseTime: true
      };
      config.element = 'perc_ocupa';
      config.stacked = false;
      Morris.Bar(config);
    </script>
    <script type="text/javascript">
      var data =<?php echo json_encode($array_parte); ?>,
      config = {
        data: data,
        xkey: 'ds_data',
        ykeys: ['nr_total_sku'],
        labels: ["SKU's Armazenados"],hideHover: 'auto',
        pointSize: 3,
        fillOpacity: 0.6,
        hideHover: 'auto',
        behaveLikeLine: true,
        resize: true,
        barColors: ['#0061B3','#009933','#D96123'],
        axes: true,
        barGap:4,
        barSizeRatio:0.35,
        parseTime: true
      };
      config.element = 'sku_arm';
      config.stacked = false;
      Morris.Bar(config);
    </script>
    <script type="text/javascript">
      var data =<?php echo json_encode($array_dia); ?>,
      config = {
        data: data,
        xkey: 'dt_fechamento',
        ykeys: ['nr_ocp_perc'],
        labels: ["Percentual Ocupação"],hideHover: 'auto',
        pointSize: 3,
        fillOpacity: 0.6,
        hideHover: 'auto',
        behaveLikeLine: true,
        resize: true,
        barColors:function(row, series, type) {
          if(row.y >= 90){

            return "#D96123";

          }else if(row.y < 90 && row.y >= 70){

            return "#009933";

          }else{

            return "#0061B3";

          }
        },
        axes: true,
        barGap:4,
        barSizeRatio:0.35,
        parseTime: true
      };
      config.element = 'perc_ocupa_dia';
      config.stacked = false;
      Morris.Line(config);
    </script>
    <script type="text/javascript">
      var data =<?php echo json_encode($array_dia); ?>,
      config = {
        data: data,
        xkey: 'dt_fechamento',
        ykeys: ['nr_ocp_sku'],
        labels: ["SKU's Armazenados"],hideHover: 'auto',
        pointSize: 3,
        fillOpacity: 0.6,
        hideHover: 'auto',
        behaveLikeLine: true,
        resize: true,
        barColors: ['#0061B3','#009933','#D96123'],
        axes: true,
        barGap:4,
        barSizeRatio:0.35,
        parseTime: true
      };
      config.element = 'sku_arm_dia';
      config.stacked = false;
      Morris.Line(config);
    </script>