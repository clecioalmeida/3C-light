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

$sql_vg = "SELECT concat('ID|',GROUP_CONCAT(id ORDER BY ds_data SEPARATOR '|')) as id, 
concat('<p style=text-align:left>QTDE IPAL PREVISTO</p>|',GROUP_CONCAT(COALESCE(qtd_ipal_prev,0) ORDER BY ds_data SEPARATOR '|')) as qtd_ipal_prev, 
concat('<p style=text-align:left>QTDE IPAL EXECUTADAS</p>|',GROUP_CONCAT(COALESCE(qtd_ipal_exe,0) ORDER BY ds_data SEPARATOR '|')) as qtd_ipal_exe,
concat('<p style=text-align:left>IRREGULARIDADES DE SSO</p>|',GROUP_CONCAT(COALESCE(nr_irreg_seg,0) ORDER BY ds_data SEPARATOR '|')) as nr_irreg_seg,
concat('<p style=text-align:left>QTDE ACIDENTES FATAIS</p>|',GROUP_CONCAT(COALESCE(nr_acd_fat,0) ORDER BY ds_data SEPARATOR '|')) as nr_acd_fat
from tb_fc_seg
where fl_empresa = '$cod_cli' and fl_status = 'A' 
order by ds_data asc";
$res_vg = mysqli_query($link, $sql_vg);

$meses = array("INDICADOR-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

$link->close();
?>
<?php include 'chart_seg.php';?>
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
  <button type="buttom" id="btnCadIndSeg" class="btn btn-info btn-xs" style="float:left;width: 150px;background-color: #0061B3">NOVO</button>
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Ocorrência de irregularidades de segurança e saúde ocupacional e acidente com colaboradores da contratada</strong></h1></span>
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

            $qtd_ipal_prev  = explode('|', $dados['qtd_ipal_prev']);
            $qtd_ipal_exe   = explode('|', $dados['qtd_ipal_exe']);
            $nr_irreg_seg   = explode('|', $dados['nr_irreg_seg']);
            $nr_acd_fat     = explode('|', $dados['nr_acd_fat']);
            $id             = explode('|', $dados['id']);

            $a = "<tr>";
            foreach(array_combine($id, $qtd_ipal_prev) as $d => $l){

              $a .= "<td class='indSeg' data-ind=".$d." style='text-align:right'>".$l."</td>";

            }
            $a .= "</tr>";

            $b = "<tr>";
            foreach(array_combine($id, $qtd_ipal_exe) as $d => $m){

              $b .= "<td class='indSeg' data-ind=".$d." style='text-align:right'>".$m."</td>";

            }
            $b .= "</tr>";

            $c = "<tr>";
            foreach(array_combine($id, $nr_irreg_seg) as $d => $n){

              $c .= "<td class='indSeg' data-ind=".$d." style='text-align:right'>".$n."</td>";

            }
            $c .= "</tr>";

            $u = "<tr>";
            foreach(array_combine($id, $nr_acd_fat) as $d => $o){

              $u .= "<td class='indSeg' data-ind=".$d." style='text-align:right'>".$o."</td>";

            }
            $u .= "</tr>";

            echo $c,$u;

          }

          ?>
        </tbody>
      </table><br>
      <table>
        <tbody>

          <?php

          $t = "<tr style='font-weight: bold;color:#D96123'><td style='width:250px;'>META:</td><td style='width:100px;text-align:left'></td><td style='width:50px'></td><td>  RESPONSÁVEL: </td><td colspan='9'></td></tr>";

          echo $t;

          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="printGraph">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <header>
      <span class="widget-icon"></span>
      <h2>QUANTIDADE DE OCORRÊNCIAS</h2>
    </header>
    <div>
      <div class="widget-body no-padding">
        <div id="seg_ocor" class="chart no-padding"></div>
      </div>
    </div>
  </div>
</div> 
<!--div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <header>
      <span class="widget-icon"></span>
      <h2>QUANTIDADE DE IPALS</h2>
    </header>
    <div>
      <div class="widget-body no-padding">
        <div id="seg_ipal" class="chart no-padding"></div>
      </div>
    </div>
  </div>
</div--> 
<!-- meus scripts -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#BtnIndCronExcel').on('click', function(){
      event.preventDefault();
      $('#BtnIndCronExcel').prop("disabled", true);
      var today = new Date();
      $("#RepIndCronExcel").table2excel({
        exclude: ".noExl",
        name: "Relatório de cronograma de entregas - Analítico",
                filename: "Relatório de cronograma de entregas - Analítico - " + today //do not include extension
              });
      $('#BtnIndCronExcel').prop("disabled", false);
    });
  });
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_seg); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['nr_irreg_seg','nr_acd_fat'],
    labels: ['IRREG', 'ACID FATAIS'],
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors: ['#0061B3','#009933','#D96123'],
    axes: true,
    goals: 0,
    goalLineColors:['#0061B3'],
    goalStrokeWidth: 2,
    numLines: 5,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'seg_ocor';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_seg); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['qtd_ipal_prev','qtd_ipal_exe'],
    labels: ['IPAL PREV','IPAL EXE'],
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors: ['#0061B3','#009933','#D96123'],
    axes: true,
    numLines: 5,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'seg_ipal';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>