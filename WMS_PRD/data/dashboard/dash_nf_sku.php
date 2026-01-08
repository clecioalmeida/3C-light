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

$sql_vg = "SELECT concat('MES,',GROUP_CONCAT(ds_data ORDER BY month(ds_data))) as mes, 
concat('<p style=text-align:left>TOTAL NOTAS FISCAIS</p>,',GROUP_CONCAT(COALESCE(nr_nf_rec,0) ORDER BY ds_data)) as nr_nf_rec, 
concat('<p style=text-align:left>TOTAL FORNECEDORES</p>,',GROUP_CONCAT(COALESCE(nr_forn_rec,0) ORDER BY ds_data)) as nr_forn_rec,
concat('<p style=text-align:left>TOTAL SKUs RECEBIDOS</p>,',GROUP_CONCAT(COALESCE(nr_sku_rec,0) ORDER BY ds_data)) as nr_sku_rec,  
concat('<p style=text-align:left>MÉDIA SKUs / FORNECEDOR</p>,',GROUP_CONCAT(format((nr_sku_rec/nr_forn_rec),2) ORDER BY ds_data)) as avg_sku
from tb_fc_sku_rec
where fl_empresa = '$cod_cli'
order by month(ds_data) asc";
$res_vg = mysqli_query($link, $sql_vg);

$meses = array("INDICADOR-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

$link->close();
?>
<?php include 'chart_nf_sku.php';?>
<style type="text/css">
  .teste1 {
    position:relative;
    width:100px;
    height:100px;
    /* o float e o border é só para visualizar */  
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
  <button type="buttom" id="" class="btn btn-info btn-xs" disabled style="float:left;width: 150px;background-color: #0061B3">NOVO</button>
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Quantidade de Notas Fiscais e SKU's recebidos</strong></h1></span>
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

            $nr_nf_rec   = explode(',', $dados['nr_nf_rec']);
            $nr_forn_rec = explode(',', $dados['nr_forn_rec']);
            $nr_sku_rec  = explode(',', $dados['nr_sku_rec']);
            $avg_sku     = explode(',', $dados['avg_sku']);
            $mes          = explode(',', $dados['mes']);

            $a = "<tr>";
            foreach(array_combine($mes, $nr_nf_rec) as $d => $f){

              $a .= "<td class='indSku' data-mes=".$d." style='text-align:right'>".$f."</td>";

            }
            $a .= "</tr>";

            $b = "<tr>";
            foreach(array_combine($mes, $nr_forn_rec) as $d => $g){

              $b .= "<td class='indSku' data-mes=".$d." style='text-align:right'>".$g."</td>";

            }
            $b .= "</tr>";

            $g = "<tr>";
            foreach(array_combine($mes, $avg_sku) as $d => $j){

              $g .= "<td class='indSku' data-mes=".$d." style='text-align:right'>".$j."</td>";

            }
            $g .= "</tr>";

            $e = "<tr>";
            foreach(array_combine($mes, $nr_sku_rec) as $d => $j){

              $e .= "<td class='indSku' data-mes=".$d." style='text-align:right'>".$j."</td>";

            }
            $e .= "</tr>";

            echo $a,$b,$e,$g;

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
        <div id="rec_nf" class="chart no-padding"></div>
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
  var data =<?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['nr_nf_rec', 'nr_sku_rec', 'nr_forn_rec', 'media'],
    labels: ['Total Nfs', 'Total SKU', 'Total Fornecedores', 'Média Sku x Nf'],hideHover: 'auto',
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors: ['#0061B3','#009933','#D96123'],
    axes: true,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'rec_nf';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config).on('click', function(i, row){
    var ds_mes = row.ds_mes;
    $.ajax
    ({
      url:"data/dashboard/modal/m_list_nf_sku.php",
      method:"POST",
      data:{ds_mes:ds_mes},
      success:function(data)
      {
        $('#retModalPrcNf').html(data);
      }
    });
  });
</script>