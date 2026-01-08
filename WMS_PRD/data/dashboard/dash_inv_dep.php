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
concat('<p style=text-align:left>QTDE SKU INVENTARIADA</p>|',GROUP_CONCAT(COALESCE(nr_sku_qtde,0) ORDER BY ds_data SEPARATOR '|')) as nr_sku_qtde, 
concat('<p style=text-align:left>QTDE SKU SOBRA</p>|',GROUP_CONCAT(COALESCE(nr_sku_sobra,0) ORDER BY ds_data SEPARATOR '|')) as nr_sku_sobra,
concat('<p style=text-align:left>QTDE SKU FALTA</p>|',GROUP_CONCAT(COALESCE(nr_sku_falta,0) ORDER BY ds_data SEPARATOR '|')) as nr_sku_falta,
concat('<p style=text-align:left>ACURACIDADE SKU</p>|',GROUP_CONCAT(concat(CASE WHEN nr_ac_sku >= '100' THEN '100.00' ELSE COALESCE(nr_ac_sku,0) END,'%') ORDER BY ds_data SEPARATOR '|')) as nr_ac_sku,
concat('<p style=text-align:left>VLR INICIAL</p>|',GROUP_CONCAT(concat('R$ ',format(COALESCE(vlr_ini,0),2,'de_DE')) ORDER BY ds_data SEPARATOR '|')) as vlr_ini,
concat('<p style=text-align:left>VLR SOBRA</p>|',GROUP_CONCAT(concat('R$ ',format(COALESCE(vlr_sobra,0),2,'de_DE')) ORDER BY ds_data SEPARATOR '|')) as vlr_sobra,
concat('<p style=text-align:left>VLR FALTA</p>|',GROUP_CONCAT(concat('R$ ',format(COALESCE(vlr_falta,0),2,'de_DE')) ORDER BY ds_data SEPARATOR '|')) as vlr_falta,
concat('<p style=text-align:left>VLR FINAL</p>|',GROUP_CONCAT(concat('R$ ',format(COALESCE(vlr_fim,0),2,'de_DE')) ORDER BY ds_data SEPARATOR '|')) as vlr_fim,
concat('<p style=text-align:left>ACURACIDADE VALOR</p>|',GROUP_CONCAT(concat(CASE WHEN vlr_div >= '100' THEN '100.00' ELSE COALESCE(vlr_div,0) END,'%') ORDER BY ds_data SEPARATOR '|')) as vlr_div
from tb_fc_inv_dep
where fl_empresa = '$cod_cli' and fl_status = 'A' and fl_tipo = 'D' 
order by ds_data asc";
$res_vg = mysqli_query($link, $sql_vg);

$meses = array("INDICADOR-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

$link->close();
?>
<?php include 'chart_inv_dep.php';?>
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
  <button type="buttom" id="btnCadInvDep" class="btn btn-info btn-xs" style="float:left;width: 150px;background-color: #0061B3">NOVO</button>
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Acuracidade do estoque nos depósitos avançados</strong></h1></span>
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

            $nr_sku_qtde    = explode('|', $dados['nr_sku_qtde']);
            $nr_sku_sobra   = explode('|', $dados['nr_sku_sobra']);
            $nr_sku_falta   = explode('|', $dados['nr_sku_falta']);
            $nr_ac_sku      = explode('|', $dados['nr_ac_sku']);
            $vlr_ini        = explode('|', $dados['vlr_ini']);
            $vlr_sobra      = explode('|', $dados['vlr_sobra']);
            $vlr_falta      = explode('|', $dados['vlr_falta']);
            $vlr_fim        = explode('|', $dados['vlr_fim']);
            $vlr_div        = explode('|', $dados['vlr_div']);
            $id             = explode('|', $dados['id']);

            $a = "<tr>";
            foreach(array_combine($id, $nr_sku_qtde) as $d => $l){

              $a .= "<td class='indInvDep' data-ind=".$d." style='text-align:right'>".$l."</td>";

            }
            $a .= "</tr>";

            $b = "<tr>";
            foreach(array_combine($id, $nr_sku_sobra) as $d => $m){

              $b .= "<td class='indInvDep' data-ind=".$d." style='text-align:right'>".$m."</td>";

            }
            $b .= "</tr>";

            $c = "<tr>";
            foreach(array_combine($id, $nr_sku_falta) as $d => $n){

              $c .= "<td class='indInvDep' data-ind=".$d." style='text-align:right'>".$n."</td>";

            }
            $c .= "</tr>";

            $u = "<tr>";
            foreach(array_combine($id, $nr_ac_sku) as $d => $o){

              $u .= "<td class='indInvDep' data-ind=".$d." style='text-align:right'>".$o."</td>";

            }
            $u .= "</tr>";

            $e = "<tr>";
            foreach(array_combine($id, $vlr_ini) as $d => $p){

              $e .= "<td class='indInvDep' data-ind=".$d." style='text-align:right'>".$p."</td>";

            }
            $e .= "</tr>";

            $f = "<tr>";
            foreach(array_combine($id, $vlr_sobra) as $d => $q){

              $f .= "<td class='indInvDep' data-ind=".$d." style='text-align:right'>".$q."</td>";

            }
            $f .= "</tr>";

            $i = "<tr>";
            foreach(array_combine($id, $vlr_falta) as $d => $t){

              $i .= "<td class='indInvDep' data-ind=".$d." style='text-align:right'>".$t."</td>";

            }
            $i .= "</tr>";

            $g = "<tr>";
            foreach(array_combine($id, $vlr_fim) as $d => $r){

              $g .= "<td class='indInvDep' data-ind=".$d." style='text-align:right'>".$r."</td>";

            }
            $g .= "</tr>";

            $h = "<tr>";
            foreach(array_combine($id, $vlr_div) as $d => $s){

              $h .= "<td class='indInvDep' data-ind=".$d." style='text-align:right'>".$s."</td>";

            }
            $h .= "</tr>";

            echo $a,$b,$c,$u,$e,$f,$i,$g,$h;

          }

          ?>
        </tbody>
      </table><br>
      <table>
        <tbody>

          <?php

          $t = "<tr style='font-weight: bold;color:#D96123'><td style='width:250px;'>META:</td><td style='width:100px;text-align:left'>100%</td><td style='width:50px'></td><td>  RESPONSÁVEL: </td><td colspan='9'></td></tr>";

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
        <div id="char_qtd" class="chart no-padding"></div>
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
    ykeys: ['vlr_div'],
    labels: ['ACURACIDADE VALOR'],
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors:function(row, series, type) {
      if(row.y < 100){

        return "#D96123";

      }else{

        return "#009933";

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
  config.element = 'char_qtd';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config).on('click', function(i, row){
    var id_ind = row.id;
    $.ajax
    ({
      url:"data/dashboard/modal/m_list_inv_dep.php",
      method:"POST",
      data:{id_ind:id_ind},
      success:function(data)
      {
        $('#retModalInv').html(data);
      }
    });
  });
</script>