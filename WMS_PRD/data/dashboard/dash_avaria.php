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

$sql_vg = "SELECT concat('MES|',GROUP_CONCAT(mes ORDER BY month(ds_data) SEPARATOR '|')) as mes, 
concat('<p style=text-align:left>3C SERVICES (SKU)</p>|',GROUP_CONCAT(sku_int ORDER BY month(ds_data) SEPARATOR '|')) as sku_int, 
concat('<p style=text-align:left>3C SERVICES (VALOR)</p>|',GROUP_CONCAT(concat('R$ ',format(vlr_int,2,'de_DE')) ORDER BY month(ds_data) SEPARATOR '|')) as vlr_int, 
concat('<p style=text-align:left>FORNECEDOR (SKU)</p>|',GROUP_CONCAT(sku_for ORDER BY month(ds_data) SEPARATOR '|')) as sku_for, 
concat('<p style=text-align:left>FORNECEDOR (VALOR)</p>|',GROUP_CONCAT(concat('R$ ',format(vlr_for,2,'de_DE')) ORDER BY month(ds_data) SEPARATOR '|')) as vlr_for, 
concat('<p style=text-align:left>EDP (SKU)</p>|',GROUP_CONCAT(sku_cli ORDER BY month(ds_data) SEPARATOR '|')) as sku_cli, 
concat('<p style=text-align:left>EDP (VALOR)</p>|',GROUP_CONCAT(concat('R$ ',format(vlr_cli,2,'de_DE')) ORDER BY month(ds_data) SEPARATOR '|')) as vlr_cli, 
concat('<p style=text-align:left>TOTAL (SKU)</p>|',GROUP_CONCAT(sku_total ORDER BY month(ds_data) SEPARATOR '|')) as sku_total,
concat('<p style=text-align:left>TOTAL (VALOR)</p>|',GROUP_CONCAT(concat('R$ ',format(vlr_total,2,'de_DE')) ORDER BY month(ds_data) SEPARATOR '|')) as vlr_total
FROM
(
  SELECT ds_data, month(ds_data) as mes, 
  sum(COALESCE(sku_int,0)) as sku_int, 
  sum(COALESCE(vlr_int,0)) as vlr_int, 
  sum(COALESCE(sku_for,0)) as sku_for, 
  sum(COALESCE(vlr_for,0)) as vlr_for, 
  sum(COALESCE(sku_cli,0)) as sku_cli, 
  sum(COALESCE(vlr_cli,0)) as vlr_cli, 
  sum(COALESCE(sku_total,0)) as sku_total,
  sum(COALESCE(vlr_total,0)) as vlr_total
  from tb_fc_avaria s
  WHERE fl_empresa = '$cod_cli' and fl_status = 'A' and fl_tipo = 'A'
  group by month(s.ds_data)
  order by month(s.ds_data)
) s";
$res_vg = mysqli_query($link, $sql_vg);

$meses = array("INDICADOR-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

$link->close();
?>
<?php include 'chart_av.php';?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.1/dist/html2canvas.min.js"></script>
<script type="text/javascript">
  function printContent(el){
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
  }
</script>
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
  <button type="buttom" id="btnCadIndAv" class="btn btn-info btn-xs" style="float:left;width: 150px;background-color: #0061B3">NOVO</button>
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Avarias em materiais&nbsp;&nbsp;&nbsp;</strong><i class="fa fa-caret-down icon-color-bad"></i></h1></span>
  <img class="pull-right" src="img/logo3cfaz.png" alt="3Cfaz" style="width: 8%; height: 5%; margin-top: 0px">
</div>
<br><br><br><br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div class="widget-body">
      <table id="RepIndDemExcel" class="table" width="100%">
        <thead>
          <?php
          $head = "<tr>";
          foreach ($meses as $value) {

            $mes = explode('-', $value);

            $head .= "<th>".$mes[0]."</th>";

          }

          $head .= "</tr>";

          echo $head;      
          ?>
        </thead>
        <tbody>
          <?php

          while ($dados = mysqli_fetch_array($res_vg)) {

            $sku_int   = explode('|', $dados['sku_int']);
            $vlr_int   = explode('|', $dados['vlr_int']);
            $sku_for   = explode('|', $dados['sku_for']);
            $vlr_for   = explode('|', $dados['vlr_for']);
            $sku_cli   = explode('|', $dados['sku_cli']);
            $vlr_cli   = explode('|', $dados['vlr_cli']);
            $sku_total = explode('|', $dados['sku_total']);
            $vlr_total = explode('|', $dados['vlr_total']);
            $mes        = explode('|', $dados['mes']);

            $a = "<tr>";
            foreach(array_combine($mes, $sku_int) as $d => $f){

              $a .= "<td class='indAv' data-mes=".$d." style='text-align:right'>".$f."</td>";

            }
            $a .= "</tr>";

            $b = "<tr>";
            foreach(array_combine($mes, $vlr_int) as $d => $g){

              $b .= "<td class='indAv' data-mes=".$d." style='text-align:right'>".$g."</td>";

            }
            $b .= "</tr>";

            $e = "<tr>";
            foreach(array_combine($mes, $sku_for) as $d => $j){

              $e .= "<td class='indAv' data-mes=".$d." style='text-align:right'>".$j."</td>";

            }
            $e .= "</tr>";

            $f = "<tr>";
            foreach(array_combine($mes, $vlr_for) as $d => $j){

              $f .= "<td class='indAv' data-mes=".$d." style='text-align:right'>".$j."</td>";

            }
            $f .= "</tr>";

            $g = "<tr>";
            foreach(array_combine($mes, $sku_cli) as $d => $j){

              $g .= "<td class='indAv' data-mes=".$d." style='text-align:right'>".$j."</td>";

            }
            $g .= "</tr>";

            $h = "<tr>";
            foreach(array_combine($mes, $vlr_cli) as $d => $j){

              $h .= "<td class='indAv' data-mes=".$d." style='text-align:right'>".$j."</td>";

            }
            $h .= "</tr>";

            $i = "<tr>";
            foreach(array_combine($mes, $sku_total) as $d => $j){

              $i .= "<td class='indAv' data-mes=".$d." style='text-align:right'>".$j."</td>";

            }
            $i .= "</tr>";

            $k = "<tr>";
            foreach(array_combine($mes, $vlr_total) as $d => $j){

              $k .= "<td class='indAv' data-mes=".$d." style='text-align:right'>".$j."</td>";

            }
            $k .= "</tr>";

            echo $a,$b,$e,$f,$g,$h,$i,$k;

          }

          ?>
        </tbody>
      </table><br>
      <table>
        <tbody>

          <?php

          $f = "<tr style='font-weight: bold'><td style='width:100px;'>META:</td><td style='width:10px;text-align:right'>0</td><td style='width:50px'></td><td>  RESPONSÁVEL: </td><td colspan='9'></td></tr>";

          echo $f;

          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <header>
      <span class="widget-icon"></span>
      <h2>AVARIAS POR SKU</h2>
    </header>
    <div>
      <div class="widget-body no-padding">
        <div id="av_sku" class="chart no-padding"></div>
      </div>
    </div>
  </div>
</div> 
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <header>
      <span class="widget-icon"></span>
      <h2>AVARIAS POR VALOR</h2>
    </header>
    <div>
      <div class="widget-body no-padding">
        <div id="av_vlr" class="chart no-padding"></div>
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
  var data =<?php echo json_encode($array_avaria); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['sku_int','sku_for','sku_cli','sku_total'],
    labels: ['3C SERVICES (SKU)', 'FORNECEDOR (SKU)', 'EDP (SKU)', 'TOTAL (SKU)'],
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors:function(row, series, type) {
      if(row.y >= 3){

        return "#D96123";

      }else if(row.y > 0 && row.y < 3){

        return "#0061B3";

      }else{

        return "#009933";

      }
    },
    axes: true,
    goals: [0],
    goalLineColors:['#0061B3'],
    goalStrokeWidth: 2,
    numLines: 5,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'av_sku';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_avaria); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['vlr_int','vlr_for','vlr_cli','vlr_total'],
    labels: ['3C SERVICES (VALOR)', 'FORNECEDOR (VALOR)', 'EDP (VALOR)', 'TOTAL (VALOR)'],
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors:function(row, series, type) {
      if(row.y >= 5000){

        return "#D96123";

      }else if(row.y > 0 && row.y < 5000){

        return "#0061B3";

      }else{

        return "#009933";

      }
    },
    axes: true,
    goals: [0],
    goalLineColors:['#0061B3'],
    goalStrokeWidth: 2,
    numLines: 5,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'av_vlr';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>