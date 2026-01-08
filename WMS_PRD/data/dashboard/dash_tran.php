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
concat('<p style=text-align:left>NO PRAZO</p>|',GROUP_CONCAT(concat(COALESCE(nr_prazo,0),'%') ORDER BY ds_data SEPARATOR '|')) as nr_prazo, 
concat('<p style=text-align:left>EM ATRASO</p>|',GROUP_CONCAT(concat(COALESCE(nr_atraso,0),'%') ORDER BY ds_data SEPARATOR '|')) as nr_atraso,
format((sum(nr_prazo)/count(id)),2) as avg_prazo
from tb_fc_tran
where fl_empresa = '$cod_cli' and fl_status = 'A' 
order by ds_data asc";
$res_vg = mysqli_query($link, $sql_vg);

$meses = array("INDICADOR-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

$link->close();
?>
<?php include 'chart_tran.php';?>
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
  <button type="buttom" id="btnCadIndTran" class="btn btn-info btn-xs" style="float:left;width: 150px;background-color: #0061B3">NOVO</button>
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Trânsito</strong></h1></span>
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

            $nr_prazo   = explode('|', $dados['nr_prazo']);
            $nr_atraso  = explode('|', $dados['nr_atraso']);
            $id         = explode('|', $dados['id']);
            $media      = $dados['avg_prazo'];

            $a = "<tr>";
            foreach(array_combine($id, $nr_prazo) as $d => $l){

              $a .= "<td class='indTran' data-ind=".$d." style='text-align:right'>".$l."</td>";

            }
            $a .= "</tr>";

            $b = "<tr>";
            foreach(array_combine($id, $nr_atraso) as $d => $m){

              $b .= "<td class='indTran' data-ind=".$d." style='text-align:right'>".$m."</td>";

            }
            $b .= "</tr>";

            echo $a,$b;

          }

          ?>
        </tbody>
      </table><br>
      <table>
        <tbody>

          <?php

          $t = "<tr style='font-weight: bold;color:#009933'>
          <td style='width:100px;'>META:</td>
          <td style='width:100px;text-align:right'>100%</td>
          <td style='width:50px'></td><td>  MÉDIA: </td>
          <td style='width:100px;text-align:right'>".$media."%</td>
          <td style='width:50px'></td><td>  RESPONSÁVEL: </td>
          <td colspan='9'></td>
          </tr>";

          echo $t;

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
        <div id="ind_tran" class="chart no-padding"></div>
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
  var data =<?php echo json_encode($array_qld); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['nr_prazo','nr_atraso',],
    labels: ['NO PRAZO (%)', 'EM ATRASO (%)'],
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors:function(row, series, type) {
      if(row.y >= 100){

        return "#009933";

      }else if(row.y > 90 && row.y < 100){

        return "#0061B3";

      }else{

        return "#D96123";

      }
    },
    axes: true,
    ymin: 0,
    ymax: 100,
    goals: [100],
    goalLineColors:['#0061B3'],
    goalStrokeWidth: 2,
    numLines: 5,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'ind_tran';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config).on('click', function(i, row){
    var id_ind = row.id;
    $.ajax
    ({
      url:"data/dashboard/modal/m_list_tran.php",
      method:"POST",
      data:{id_ind:id_ind},
      success:function(data)
      {
        $('#retModalTransp').html(data);
      }
    });
  });
</script>