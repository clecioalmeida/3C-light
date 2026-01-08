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

$sql_vg = "SELECT id, nr_qtd_sol, nr_qtd_at,  GROUP_CONCAT(media_at order by ds_data asc) as media_at, GROUP_CONCAT(media_sol order by ds_data asc) as media_sol, at_percent  
FROM
(
  SELECT concat('ID,',GROUP_CONCAT(id order by ds_data asc)) as id, ds_data, concat('<p style=text-align:left>SOLICITADOS</p>,',GROUP_CONCAT(format(nr_qtd_sol,0,'de_DE') order by ds_data asc)) as nr_qtd_sol, concat('<p style=text-align:left>ATENDIDOS</p>,',GROUP_CONCAT(format(nr_qtd_at,0,'de_DE') order by ds_data asc)) as nr_qtd_at, format(AVG(nr_qtd_at),2) media_at, format(AVG(nr_qtd_sol),2) media_sol,
  concat('<p style=text-align:left>PERCENTUAL ATENDIDO (%)</p>,',GROUP_CONCAT(CASE WHEN nr_qtd_sol > 0 THEN format((nr_qtd_at/nr_qtd_sol)*100,2) ELSE 0 END order by ds_data asc)) as at_percent
  FROM tb_fc_qtd_at s
  WHERE fl_empresa = '$cod_cli'
  order by ds_data
) s";
$res_vg = mysqli_query($link, $sql_vg);

$meses = array("INDICADOR-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

$link->close();
?>
<?php include 'chart_qtd_at.php';?>
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
  <span class="teste2"><h1><strong>Atendimento de pedido de transferência da programação&nbsp;&nbsp;&nbsp;</strong><i class="fa fa-caret-up icon-color-good"></i></h1></span>
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

          while ($dados_sp = mysqli_fetch_array($res_vg)) {

            $nr_qtd_sol = explode(',', $dados_sp['nr_qtd_sol']);
            $nr_qtd_at  = explode(',', $dados_sp['nr_qtd_at']);
            $media_sol  = $dados_sp['media_sol'];
            $media_at   = $dados_sp['media_at'];
            $at_percent = explode(',', $dados_sp['at_percent']);
            $id         = explode(',', $dados_sp['id']);

            $h = "<tr>";
            foreach(array_combine($id, $nr_qtd_sol) as $d => $f){

              $h .= "<td class='indQtdAt' data-ind=".$d." style='text-align:right'>".$f."</td>";

            }
            $h .= "</tr>";

            $m = "<tr>";
            foreach(array_combine($id, $nr_qtd_at) as $d => $g){

              $m .= "<td class='indQtdAt' data-ind=".$d." style='text-align:right'>".$g."</td>";

            }
            $m .= "</tr>";

            $n = "<tr>";
            foreach(array_combine($id, $at_percent) as $d => $j){

              $n .= "<td class='indQtdAt' data-ind=".$d." style='text-align:right'>".$j."</td>";

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

          $f = "<tr style='font-weight: bold;color:#D96123'><td style='width:200px;'>MEDIA SOLICITADO:</td><td style='width:100px;text-align:right'>".$media_sol."</td><td style='width:50px;text-align:right'></td><td style='width:200px;'>MEDIA ATENDIDO:</td><td style='width:50px;text-align:right'>".$media_at."</td><td style='width:50px'></td><td>  RESPONSÁVEL: </td><td colspan='9'></td></tr>";

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
        <div id="at_ped" class="chart no-padding"></div>
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
    labels: ['% Atendido'],
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors:function(row, series, type) {
      if(row.y >= 95){

        return "#009933";

      }else if(row.y >= 80 && row.y < 95){

        return "#0061B3";

      }else{

        return "#D96123";

      }
    },
    axes: true,
    numLines: 5,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'at_ped';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config).on('click', function(i, row){
    var id_ind = row.id_ind;
    $.ajax
    ({
      url:"data/dashboard/modal/m_list_qtd_at.php",
      method:"POST",
      data:{id_ind:id_ind},
      success:function(data)
      {
        $('#retModalCron').html(data);
      }
    });
  });
</script>