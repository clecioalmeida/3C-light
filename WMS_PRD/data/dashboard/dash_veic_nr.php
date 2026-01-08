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

$sql_vg = "SELECT concat('ID,',GROUP_CONCAT(id order by ds_data asc)) as id, ds_data,
concat('<p style=text-align:left>ENTREGAS PROGRAMADAS</p>,',GROUP_CONCAT(nr_veic_total order by ds_data asc)) as nr_veic_total, 
concat('<p style=text-align:left>ENTREGAS REALIZADAS COM FIXOS</p>,',GROUP_CONCAT(nr_veic_fx order by ds_data asc)) as nr_veic_fx,
concat('<p style=text-align:left>MÉDIA</p>,',GROUP_CONCAT(CASE WHEN nr_veic_fx > 0 THEN format((nr_veic_fx/nr_dia_total),2) ELSE 0 END order by ds_data asc)) as veic_percent
from tb_fc_veic
where fl_empresa = '$cod_cli'
order by ds_data asc";
$res_vg = mysqli_query($link, $sql_vg);

$sql_sp = "SELECT concat('ID,',GROUP_CONCAT(id order by ds_data asc)) as id, ds_data,
concat('<p style=text-align:left>ENTREGAS PROGRAMADAS</p>,',GROUP_CONCAT(nr_veic_total order by ds_data asc)) as nr_veic_total, 
concat('<p style=text-align:left>ENTREGAS REALIZADAS COM SPOT</p>,',GROUP_CONCAT(nr_veic_sp order by ds_data asc)) as nr_veic_sp,
concat('<p style=text-align:left>MÉDIA</p>,',GROUP_CONCAT(CASE WHEN nr_veic_sp > 0 THEN format((nr_veic_sp/nr_dia_total),2) ELSE 0 END order by ds_data asc)) as veic_percent
from tb_fc_veic
where fl_empresa = '$cod_cli'
order by ds_data asc";
$res_sp = mysqli_query($link, $sql_sp);

$meses1 = array("INDICADOR VEÍCULOS SPOT-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

$meses2 = array("INDICADOR VEÍCULOS FIXOS-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

$link->close();
?>
<?php include 'chart_veic_nr.php';?>
<?php include 'chart_veic_spt.php';?>
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
  <button type="buttom" id="btnCadIndCron" class="btn btn-info btn-xs" style="float:left;width: 150px;background-color: #0061B3">NOVO</button>
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Veículos da frota fixa e spots expedidos</strong></h1></span>
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
          foreach ($meses1 as $value) {

            $mes = explode('-', $value);

            $head .= "<th>".$mes[0]."</th>";

          }

          $head .= "</tr>";

          echo $head;      
          ?>
        </thead>
        <tbody>
          <?php

          while ($dados_sp = mysqli_fetch_array($res_sp)) {

            $nr_veic_total  = explode(',', $dados_sp['nr_veic_total']);
            $nr_veic_sp     = explode(',', $dados_sp['nr_veic_sp']);
            $veic_percent   = explode(',', $dados_sp['veic_percent']);
            $id             = explode(',', $dados_sp['id']);

            $h = "<tr>";
            foreach(array_combine($id, $nr_veic_total) as $d => $f){

              $h .= "<td class='indVeicNr' data-ind=".$d." style='text-align:right'>".$f."</td>";

            }
            $h .= "</tr>";

            $m = "<tr>";
            foreach(array_combine($id, $nr_veic_sp) as $d => $g){

              $m .= "<td class='indVeicNr' data-ind=".$d." style='text-align:right'>".$g."</td>";

            }
            $m .= "</tr>";

            $k = "<tr>";
            foreach(array_combine($id, $veic_percent) as $d => $j){

              $k .= "<td class='indVeicNr' data-ind=".$d." style='text-align:right'>".$j."</td>";

            }
            $k .= "</tr>";

            echo $h,$m,$k;

          }

          ?>
        </tbody>
      </table><br>
      <table>
        <tbody>

          <?php

          $f = "<tr style='font-weight: bold'><td style='width:100px;'>META:</td><td style='width:10px;text-align:right'></td><td style='width:50px'></td><td>  RESPONSÁVEL: </td><td colspan='9'></td></tr>";

          echo $f;

          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="printGraph">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div>
      <div class="widget-body no-padding">
        <div id="veic_sp" class="chart no-padding"></div>
      </div>
    </div>
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div class="widget-body">
      <table id="RepIndDemExcel" class="table" width="100%">
        <thead>
          <?php
          $head = "<tr>";
          foreach ($meses2 as $value) {

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

            $nr_veic_total_fx   = explode(',', $dados['nr_veic_total']);
            $nr_veic_fx         = explode(',', $dados['nr_veic_fx']);
            $veic_percent_fx    = explode(',', $dados['veic_percent']);
            $id                 = explode(',', $dados['id']);

            $a = "<tr>";
            foreach(array_combine($id, $nr_veic_total_fx) as $d => $f){

              $a .= "<td class='indVeicFx' data-ind=".$d." style='text-align:right'>".$f."</td>";

            }
            $a .= "</tr>";

            $b = "<tr>";
            foreach(array_combine($id, $nr_veic_fx) as $d => $g){

              $b .= "<td class='indVeicFx' data-ind=".$d." style='text-align:right'>".$g."</td>";

            }
            $b .= "</tr>";

            $g = "<tr>";
            foreach(array_combine($id, $veic_percent_fx) as $d => $j){

              $g .= "<td class='indVeicFx' data-ind=".$d." style='text-align:right'>".$j."</td>";

            }
            $g .= "</tr>";

            echo $a,$b,$g;

          }

          ?>
        </tbody>
      </table><br>
      <table>
        <tbody>

          <?php

          $f = "<tr style='font-weight: bold'><td style='width:100px;'>META:</td><td style='width:10px;text-align:right'></td><td style='width:50px'></td><td>  RESPONSÁVEL: </td><td colspan='9'></td></tr>";

          echo $f;

          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="printGraph">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div>
      <div class="widget-body no-padding">
        <div id="veic_fx" class="chart no-padding"></div>
      </div>
    </div>
  </div>
</div>
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
  var data =<?php echo json_encode($array_spot); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['media'],
    labels: ['Média'],
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
  config.element = 'veic_sp';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config).on('click', function(i, row){
    var ds_mes = row.ds_mes;
    $.ajax
    ({
      url:"data/dashboard/modal/m_list_dest_veic.php",
      method:"POST",
      data:{ds_mes:ds_mes},
      success:function(data)
      {
        $('#retModalTransp').html(data);
      }
    });
  });
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['media'],
    labels: ['Média'],
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
  config.element = 'veic_fx';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config).on('click', function(i, row){
    var ds_mes = row.ds_mes;
    $.ajax
    ({
      url:"data/dashboard/modal/m_list_dest_veic.php",
      method:"POST",
      data:{ds_mes:ds_mes},
      success:function(data)
      {
        $('#retModalTransp').html(data);
      }
    });
  });
</script>