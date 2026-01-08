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
concat('<p style=text-align:left>NOTAS FISCAIS RECEBIDAS</p>|',GROUP_CONCAT(nf_rec ORDER BY month(ds_data) SEPARATOR '|')) as nf_rec, 
concat('<p style=text-align:left>NOTAS FISCAIS RECEBIDAS ACIMA DO PRAZO</p>|',GROUP_CONCAT(nf_rec_div ORDER BY month(ds_data) SEPARATOR '|')) as nf_rec_div, 
concat('<p style=text-align:left>REALIZADAS NO PRAZO (%)</p>|',GROUP_CONCAT(percent ORDER BY month(ds_data) SEPARATOR '|')) as rec_percent
FROM
(
  SELECT ds_data, month(ds_data) as mes, 
  sum(COALESCE(nf_rec,0)) as nf_rec, 
  sum(COALESCE(nf_rec_div,0)) as nf_rec_div, 
  CASE WHEN nf_rec_div > 0 THEN format(((sum(nf_rec_div)/sum(nf_rec))*-100)+100,2) ELSE '0' END as percent
  from tb_fc_rec_sap s
  WHERE fl_empresa = '$cod_cli' and fl_status = 'A'
  group by month(s.ds_data)
  order by month(s.ds_data)
) s";
$res_vg = mysqli_query($link, $sql_vg);

$meses = array("INDICADOR-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

$link->close();
?>
<?php include 'chart_process_nf.php';?>
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
  <header>
    <button type="buttom" id="btnCadRecNf" class="btn btn-info btn-xs" style="float:left;width: 150px;background-color: #0061B3">NOVO</button>
  </header>  
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Processamento de notas fiscais em até 1 dia útil após recebimento&nbsp;&nbsp;&nbsp;</strong><i class="fa fa-caret-down icon-color-bad"></i></h1></span>
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

            $nf_rec       = explode('|', $dados['nf_rec']);
            $nf_rec_div   = explode('|', $dados['nf_rec_div']);
            $res          = explode('|', $dados['rec_percent']);
            $mes          = explode('|', $dados['mes']);

            $a = "<tr>";
            foreach(array_combine($mes, $nf_rec) as $d => $f){

              $a .= "<td class='indvg' data-mes=".$d." style='text-align:right'>".$f."</td>";

            }
            $a .= "</tr>";

            $b = "<tr>";
            foreach(array_combine($mes, $nf_rec_div) as $d => $g){

              $b .= "<td class='indvg' data-mes=".$d." style='text-align:right'>".$g."</td>";

            }
            $b .= "</tr>";

            $e = "<tr>";
            foreach(array_combine($mes, $res) as $d => $j){

              $e .= "<td class='indvg' data-mes=".$d." style='text-align:right'>".$j."</td>";

            }
            $e .= "</tr>";

            echo $a,$b,$e;

          }

          ?>
        </tbody>
      </table><br>
      <table>
        <tbody>

          <?php

          $f = "<tr style='font-weight: bold'><td style='width:100px;'>META:</td><td style='width:10px;text-align:right'>98%</td><td style='width:50px'></td><td>  RESPONSÁVEL: </td><td colspan='9'></td></tr>";

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
        <div id="rec_nf" class="chart no-padding"></div>
      </div>
    </div>
  </div>
</div> 
<!-- meus scripts -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#BtnIndGenExcel').on('click', function(){
      event.preventDefault();
      $('#BtnIndGenExcel').prop("disabled", true);
      var today = new Date();
      $("#RepIndGenExcel").table2excel({
        exclude: ".noExl",
        name: "Relatório de processamento de notas fiscais - Analítico",
                filename: "Relatório de processamento de notas fiscais - Analítico - " + today //do not include extension
              });
      $('#BtnIndGenExcel').prop("disabled", false);
    });
  });
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['percent'],
    labels: ['Índice:'],
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
    goals: [98],
    goalLineColors:['#0061B3'],
    goalStrokeWidth: 2,
    numLines: 5,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'rec_nf';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config).on('click', function(i, row){
    var ds_mes = row.ds_data;
    $.ajax
    ({
      url:"data/dashboard/modal/m_list_ind_rec.php",
      method:"POST",
      data:{ds_mes:ds_mes},
      success:function(data)
      {
        $('#retModalPrcNf').html(data);
      }
    });
  });
</script>