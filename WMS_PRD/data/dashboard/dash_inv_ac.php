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

$query_transp = "select id, ds_data, nr_sku_qtde, nr_sku_falta, nr_sku_sobra, CASE WHEN nr_ac_sku >= '100' THEN '100.00' ELSE nr_ac_sku end as nr_ac_sku, Concat('R$ ',format(vlr_ini,2,'de_DE')) as vlr_ini, Concat('R$ ',format(vlr_sobra,2,'de_DE')) as vlr_sobra, Concat('R$ ',format(vlr_falta,2,'de_DE')) as vlr_falta, Concat('R$ ',format(vlr_fim,2,'de_DE')) as vlr_fim, CASE WHEN vlr_div >= '100' THEN '100.00' ELSE vlr_div end as vlr_div 
from tb_fc_inv_dep 
where fl_empresa = '$cod_cli' and fl_status = 'A' and fl_tipo = 'A'";
$res_transp = mysqli_query($link, $query_transp);

$link->close();
?>
<?php include 'chart_inv_ac.php';?>
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
  <button type="buttom" id="btnCadInvAc" class="btn btn-info btn-xs" style="float:left;width: 150px;background-color: #0061B3">NOVO</button>
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>ACURACIDADE DE INVENTÁRIO</strong></h1></span>
  <img class="pull-right" src="img/logo3cfaz.png" alt="3Cfaz" style="width: 8%; height: 5%; margin-top: 0px">
</div>
<br><br><br><br><br>
<div class="col-xs-6 col-sm-6 col-md-12 col-lg-6">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <header>
      <span class="widget-icon"></span>
      <h2>ACURACIDADE DE ESTOQUE DOS DEPÓSITOS AVANÇADOS - QUANTIDADE</h2>
    </header>
    <div>
      <div class="widget-body no-padding">
        <div id="char_qtd" class="chart no-padding"></div>
      </div>
    </div>
  </div>
</div>
<div class="col-xs-6 col-sm-6 col-md-12 col-lg-6">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <header>
      <span class="widget-icon"></span>
      <h2>ACURACIDADE DE ESTOQUE DOS DEPÓSITOS AVANÇADOS - VALOR</h2>
    </header>
    <div>
      <div class="widget-body no-padding">
        <div id="char_vlr" class="chart no-padding"></div>
      </div>
    </div>
  </div>
</div> 
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <table id="RepIndCronExcel" class="table table-bordered" width="100%">
    <thead>
      <tr>
        <th>DATA</th>
        <th>QTDE SKU INVENTARIADA</th>
        <th>QTDE SKU SOBRA</th>
        <th>QTDE SKU FALTA</th>
        <th>ACURACIDADE SKU</th>
        <th>VLR INICIAL</th>
        <th>VLR SOBRA</th>
        <th>VLR FALTA</th>
        <th>QVLR FINAL</th>
        <th>VLR DIVERGENTE</th>
        <th>AÇÕES</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($dados = mysqli_fetch_assoc($res_transp)) {?>
        <tr class="odd gradeX">
          <td style="text-align: left;width:100px"><?php echo $dados['ds_data']; ?></td>
          <td style="text-align: right;width:50px"><?php echo $dados['nr_sku_qtde']; ?></td>
          <td style="text-align: right;width:50px"><?php echo $dados['nr_sku_sobra']; ?></td>
          <td style="text-align: right;width:50px"><?php echo $dados['nr_sku_falta']; ?></td>
          <td style="text-align: right;width:50px"><?php echo $dados['nr_ac_sku']; ?></td>
          <td style="text-align: right;width:200px"><?php echo $dados['vlr_ini']; ?></td>
          <td style="text-align: right;width:200px"><?php echo $dados['vlr_sobra']; ?></td>
          <td style="text-align: right;width:200px"><?php echo $dados['vlr_falta']; ?></td>
          <td style="text-align: right;width:200px"><?php echo $dados['vlr_fim']; ?></td>
          <td style="text-align: right;width:50px"><?php echo $dados['vlr_div']; ?></td>
          <td style="text-align: left;width:150px">
            <button type="submit" class="btn btn-primary btn-xs" id="btnUpdInvAc" value="<?php echo $dados['id'];?>">ALTERAR</button>
            <button type="submit" class="btn btn-danger btn-xs" id="btnDelInvAc" value="<?php echo $dados['id'];?>" disabled>EXCLUIR</button>
          </td>
        </tr>
      </tbody>
    <?php }?>
  </table>
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
    ykeys: ['nr_ac_sku'],
    labels: ['ACURACIDADE SKU'],
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    axes: true,
    ymin: 80,
    ymax: 100,
    goals: [100],
    goalLineColors:['#B22222'],
    goalStrokeWidth: 2,
    numLines: 5,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'char_qtd';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);


  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['vlr_div'],
    labels: ['ACURACIDADE VALOR ESTOQUE'],
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    axes: true,
    ymin: 80,
    ymax: 100,
    goals: [100],
    goalLineColors:['#B22222'],
    goalStrokeWidth: 2,
    numLines: 5,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'char_vlr';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>