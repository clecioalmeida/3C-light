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
concat('<p style=text-align:left>ENTREGAS PROGRAMADAS</p>|',GROUP_CONCAT(nr_ped ORDER BY month(ds_data) SEPARATOR '|')) as nr_ped, 
concat('<p style=text-align:left>ENTREGAS REALIZADAS</p>|',GROUP_CONCAT(nr_at ORDER BY month(ds_data) SEPARATOR '|')) as nr_at, 
concat('<p style=text-align:left>PERCENTUAL REALIZADO (%)</p>|',GROUP_CONCAT(format(ent_percent,2) ORDER BY month(ds_data) SEPARATOR '|')) as ent_percent
FROM
(
  SELECT id,
  ds_data,
  month(ds_data) as mes, 
  sum(COALESCE(nr_ped,0)) as nr_ped, 
  sum(COALESCE(nr_at,0)) as nr_at, 
  CASE WHEN sum(nr_ped) = 0 THEN '0' ELSE format((sum(nr_at)/sum(nr_ped))*100,2) END as ent_percent
  from tb_fc_cron s
  where fl_empresa = '$cod_cli' and fl_status = 'A' and nr_ped is not null
  group by year(ds_data), month(ds_data)
  order by year(ds_data), month(ds_data) asc
) s";
$res_vg = mysqli_query($link, $sql_vg);

$meses = array("INDICADOR-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

$link->close();
?>
<?php include 'chart_cron_ent.php';?>
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
  <button type="buttom" id="btnCadIndCron" class="btn btn-xs" style="float:left;width: 150px;background-color: #0061B3;color:white">NOVO</button>
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Cumprimento do cronograma de entrega aos depósitos avançados&nbsp;&nbsp;</strong><i class="fa fa-caret-up icon-color-good"></i></h1></span>
  <img class="pull-right" src="img/logo3cfaz.png" alt="3Cfaz" style="width: 8%; height: 5%; margin-top: 0px">
</div>
<br><br><br><br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div class="widget-body" id="ctrl_transp">
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

            $nr_ped       = explode('|', $dados['nr_ped']);
            $nr_at        = explode('|', $dados['nr_at']);
            $ent_percent  = explode('|', $dados['ent_percent']);
            $mes          = explode('|', $dados['mes']);

            $a = "<tr>";
            foreach(array_combine($mes, $nr_ped) as $d => $f){

              $a .= "<td class='indCronAt' data-mes=".$d." style='text-align:right'>".$f."</td>";

            }
            $a .= "</tr>";

            $b = "<tr>";
            foreach(array_combine($mes, $nr_at) as $d => $g){

              $b .= "<td class='indCronAt' data-mes=".$d." style='text-align:right'>".$g."</td>";

            }
            $b .= "</tr>";

            $g = "<tr>";
            foreach(array_combine($mes, $ent_percent) as $d => $j){

              $g .= "<td class='indCronAt' data-mes=".$d." style='text-align:right'>".$j."</td>";

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

          $f = "<tr style='font-weight: bold'><td style='width:100px;'>META:</td><td style='width:10px;text-align:right'>100</td><td style='width:50px'></td><td>  RESPONSÁVEL: </td><td colspan='9'></td></tr>";

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
        <div id="cron_at" class="chart no-padding"></div>
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
  var data =<?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['percent'],
    labels: ['Percentual atendido'],
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors:function(row, series, type) {
      if(row.y >= 98){

        return "#009933";

      }else if(row.y > 90 && row.y < 98){

        return "#0061B3";

      }else{

        return "#D96123";

      }
    },
    axes: true,
    ymin: 40,
    ymax: 100,
    goals: [100],
    goalLineColors:['#0061B3'],
    goalStrokeWidth: 2,
    numLines: 5,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'cron_at';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config).on('click', function(i, row){
    var ds_mes = row.mes;
    $.ajax
    ({
      url:"data/dashboard/modal/m_list_cron_at.php",
      method:"POST",
      data:{ds_mes:ds_mes},
      success:function(data)
      {
        $('#retModalTransp').html(data);
      }
    });
  });
</script>