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
concat('<p style=text-align:left>QTDE SKU BLOQUEADAS</p>|',GROUP_CONCAT(COALESCE(nr_sku_blq,0) ORDER BY ds_data SEPARATOR '|')) as nr_sku_blq, 
concat('<p style=text-align:left>VALOR BLOQUEADO</p>|',GROUP_CONCAT(concat('R$ ',format(COALESCE(vlr_sku_blq,0),2,'de_DE')) ORDER BY ds_data SEPARATOR '|')) as vlr_sku_blq,
concat('<p style=text-align:left>QTDE SKU EM QUALIDADE</p>|',GROUP_CONCAT(COALESCE(nr_est_qld,0) ORDER BY ds_data SEPARATOR '|')) as nr_est_qld,
concat('<p style=text-align:left>VALOR ESTOQUE QUALIDADE</p>|',GROUP_CONCAT(concat('R$ ',format(COALESCE(vlr_est_qld,0),2,'de_DE')) ORDER BY ds_data SEPARATOR '|')) as vlr_est_qld
from tb_fc_qld
where fl_empresa = '$cod_cli' and fl_status = 'A' 
order by ds_data asc";
$res_vg = mysqli_query($link, $sql_vg);

$meses = array("INDICADOR-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

$link->close();
?>
<?php include 'chart_qld.php';?>
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
  <button type="buttom" id="btnCadIndQld" class="btn btn-info btn-xs" style="float:left;width: 150px;background-color: #0061B3">NOVO</button>
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Material bloqueado e qualidade</strong></h1></span>
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

            $nr_sku_blq   = explode('|', $dados['nr_sku_blq']);
            $vlr_sku_blq  = explode('|', $dados['vlr_sku_blq']);
            $nr_est_qld   = explode('|', $dados['nr_est_qld']);
            $vlr_est_qld  = explode('|', $dados['vlr_est_qld']);
            $id           = explode('|', $dados['id']);

            $a = "<tr>";
            foreach(array_combine($id, $nr_sku_blq) as $d => $l){

              $a .= "<td class='indQld' data-ind=".$d." style='text-align:right'>".$l."</td>";

            }
            $a .= "</tr>";

            $b = "<tr>";
            foreach(array_combine($id, $vlr_sku_blq) as $d => $m){

              $b .= "<td class='indQld' data-ind=".$d." style='text-align:right'>".$m."</td>";

            }
            $b .= "</tr>";

            $c = "<tr>";
            foreach(array_combine($id, $nr_est_qld) as $d => $n){

              $c .= "<td class='indQld' data-ind=".$d." style='text-align:right'>".$n."</td>";

            }
            $c .= "</tr>";

            $u = "<tr>";
            foreach(array_combine($id, $vlr_est_qld) as $d => $o){

              $u .= "<td class='indQld' data-ind=".$d." style='text-align:right'>".$o."</td>";

            }
            $u .= "</tr>";

            echo $a,$b,$c,$u;

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
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <header>
      <span class="widget-icon"></span>
      <h2>QUANTIDADE DE SKU'S EM QUALIDADE</h2>
    </header>
    <div>
      <div class="widget-body no-padding">
        <div id="qld_sku" class="chart no-padding"></div>
      </div>
    </div>
  </div>
</div> 
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <header>
      <span class="widget-icon"></span>
      <h2>VALOR DE SKU'S EM QUALIDADE</h2>
    </header>
    <div>
      <div class="widget-body no-padding">
        <div id="qld_vlr" class="chart no-padding"></div>
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
    ykeys: ['nr_sku_blq','nr_est_qld',],
    labels: ['QTDE SKU BLOQUEADAS', 'QTDE SKU EM QUALIDADE'],
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
  config.element = 'qld_sku';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config).on('click', function(i, row){
    var id_ind = row.id;
    $.ajax
    ({
      url:"data/dashboard/modal/m_list_qld.php",
      method:"POST",
      data:{id_ind:id_ind},
      success:function(data)
      {
        $('#retModalSQld').html(data);
      }
    });
  });
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_qld); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['vlr_sku_blq','vlr_est_qld'],
    labels: ['VALOR BLOQUEADO','VALOR ESTOQUE QUALIDADE'],
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
  config.element = 'qld_vlr';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config).on('click', function(i, row){
    var id_ind = row.id;
    $.ajax
    ({
      url:"data/dashboard/modal/m_list_qld.php",
      method:"POST",
      data:{id_ind:id_ind},
      success:function(data)
      {
        $('#retModalSQld').html(data);
      }
    });
  });
</script>