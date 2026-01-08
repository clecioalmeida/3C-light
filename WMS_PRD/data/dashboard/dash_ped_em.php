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

$query_transp = "select * from tb_fc_qtd_at where fl_empresa = '$cod_cli'";
$res_transp = mysqli_query($link, $query_transp);

$sql_vg = "SELECT id, nr_total_ped, nr_total_em, media_em, em_percent 
FROM
(
  SELECT concat('ID,',GROUP_CONCAT(id order by ds_data asc)) as id, ds_data, concat('<p style=text-align:left>PEDIDOS EMERGENCIAIS</p>,',GROUP_CONCAT(format(nr_total_em,0,'de_DE') order by ds_data asc)) as nr_total_em, concat('<p style=text-align:left>PEDIDOS ATENDIDOS</p>,',GROUP_CONCAT(format(nr_total_ped,0,'de_DE') order by ds_data asc)) as nr_total_ped, format(AVG(nr_total_em),2) media_em,
  concat('<p style=text-align:left>PERCENTUAL EMERGENCIAL (%)</p>,',GROUP_CONCAT(CASE WHEN nr_total_ped > 0 THEN format((nr_total_em/nr_total_ped)*100,2) ELSE 0 END order by ds_data asc)) as em_percent
  FROM tb_fc_qtd_at s
  WHERE fl_empresa = '$cod_cli'
  order by ds_data
) s";
$res_vg = mysqli_query($link, $sql_vg);

$meses = array("INDICADOR-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

$link->close();
?>
<?php include 'chart_qtd_em.php';?>
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
  <span class="teste2"><h1><strong>Atendimento de pedidos emergenciais&nbsp;&nbsp;&nbsp;</strong><i class="fa fa-caret-down icon-color-bad"></i></h1></span>
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

            $nr_total_ped = explode(',', $dados['nr_total_ped']);
            $nr_total_em  = explode(',', $dados['nr_total_em']);
            $media_em     = $dados['media_em'];
            $em_percent   = explode(',', $dados['em_percent']);
            $id           = explode(',', $dados['id']);

            $h = "<tr>";
            foreach(array_combine($id, $nr_total_ped) as $d => $f){

              $h .= "<td class='indCronAt' data-ind=".$d." style='text-align:right'>".$f."</td>";

            }
            $h .= "</tr>";

            $m = "<tr>";
            foreach(array_combine($id, $nr_total_em) as $d => $g){

              $m .= "<td class='indCronAt' data-ind=".$d." style='text-align:right'>".$g."</td>";

            }
            $m .= "</tr>";

            $n = "<tr>";
            foreach(array_combine($id, $em_percent) as $d => $j){

              $n .= "<td class='indCronAt' data-ind=".$d." style='text-align:right'>".$j."</td>";

            }
            $n .= "</tr>";

            echo $h,$m,$n;

          }

          ?>
        </tbody>
      </table><br>
      <table>
        <tbody>

          <?php

          $f = "<tr style='font-weight: bold;color:#D96123'><td style='width:250px;'>MEDIA DE EMERGENCIAIS:</td><td style='width:100px;text-align:right'>".$media_em."</td><td style='width:50px'></td><td>  RESPONSÁVEL: </td><td colspan='9'></td></tr>";

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
        <div id="at_em" class="chart no-padding"></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#BtnIndCronExcel').on('click', function(){
      event.preventDefault();
      $('#BtnIndCronExcel').prop("disabled", true);
      var today = new Date();
      $("#RepIndCronExcel").table2excel({
        exclude: ".noExl",
        name: "Relatório de cronograma de entregas - Analítico",
        filename: "Relatório de cronograma de entregas - Analítico - " + today 
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
    labels: ['% Atendido'],
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors:function(row, series, type) {
      if(row.y >= 10){

        return "#D96123";

      }else if(row.y >= 5 && row.y < 10){

        return "#0061B3";

      }else{

        return "#009933";

      }
    },
    axes: true,
    numLines: 5,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'at_em';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>