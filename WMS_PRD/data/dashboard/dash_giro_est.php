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

$query_transp = "select * from tb_giro where fl_empresa = '$cod_cli'";
$res_transp = mysqli_query($link, $query_transp);

$link->close();
?>
<?php include 'chart_giro_est.php';?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.1/dist/html2canvas.min.js"></script>
<script type="text/javascript">
  function printContent(el){
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
  }
</script>
<br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <button type="buttom" id="btnCadIndDem" class="btn btn-info btn-xs" style="float:left;width: 150px" disabled>NOVO</button>
  <button type="submit" class="btn btn-primary btn-xs" id="BtnIndDemExcel" style="float:left;width: 150px">Excel</button>
  <button onclick="printContent('printGraph')" type="submit" id="print" class="btn btn-success btn-xs" style="float:left;width: 150px"> IMPRIMIR GRÁFICO</button><br><br>
</div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
  <table id="RepIndDemExcel" class="table table-bordered" width="100%">
    <thead>
      <tr>
        <th>DATA</th>
        <th>PRODUTO</th>
        <th>SAIDAS</th>
        <th>MÉDIA</th>
        <th>GIRO</th>
        <th>AÇÕES</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($dados = mysqli_fetch_assoc($res_transp)) {?>
        <tr class="odd gradeX">
          <td style="text-align: left;width:100px"><?php echo $dados['ds_data']; ?></td>
          <td style="text-align: right;width:100px"><?php echo $dados['produto']; ?></td>
          <td style="text-align: right;width:100px"><?php echo $dados['nr_exp']; ?></td>
          <td style="text-align: right;width:100px"><?php echo $dados['nr_media']; ?></td>
          <td style="text-align: right;width:100px"><?php echo $dados['nr_giro']; ?></td>
          <td style="text-align: left;width:150px">
            <button type="submit" class="btn btn-primary btn-xs" id="btnUpdDem" value="<?php echo $dados['id'];?>" disabled>ALTERAR</button>
            <button type="submit" class="btn btn-danger btn-xs" id="btnDelDem" value="<?php echo $dados['id'];?>" disabled>EXCLUIR</button>
          </td>
        </tr>
      </tbody>
    <?php }?>
  </table>
</div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <header>
      <span class="widget-icon"></span>
      <h2>PRODUTOS COM MAIOR GIRO</h2>
    </header>
    <div>
      <div class="widget-body no-padding">
        <div id="giroEstoque" class="chart no-padding"></div>
      </div>
    </div>
  </div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"></div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <header>
      <span class="widget-icon"></span>
      <h2>TEMPO DE GIRO</h2>
    </header>
    <div>
      <div class="widget-body no-padding">
        <div id="tempoEstoque" class="chart no-padding"></div>
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
  var data =
  <?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'produto',
    ykeys: ['giro'],
    labels: ['Giro'],
    fillOpacity: 0.6,
    hideHover: 'auto',
    behaveLikeLine: true,
    parseTime: false,
    resize: true,
    pointFillColors:['#ffffff'],
    pointStrokeColors: ['black'],
    lineColors:['gray','red']
  };
  config.element = 'giroEstoque';
  Morris.Bar(config);

</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'produto',
    ykeys: ['giro','tempo'],
    labels: ['Saldo médio', 'Tempo médio'],hideHover: 'auto',
    pointSize: 3,
    parseTime: false,
    resize: true
  };
  config.element = 'tempoEstoque';
  config.stacked = true;
  Morris.Line(config);
</script>
<!--script type="text/javascript">
  var data =<?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'produto',
    ykeys: ['giro'],
    labels: ['Giro'],hideHover: 'auto',
    pointSize: 3,
    fillOpacity: 0.6,
    hideHover: 'auto',
    behaveLikeLine: true,
    resize: true,
    axes: true,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
};
config.element = 'giroEstoque';
config.stacked = false;
Morris.Bar(config);
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_parte); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['nr_total_sku'],
    labels: ["SKU's Armazenados"],hideHover: 'auto',
    pointSize: 3,
    fillOpacity: 0.6,
    hideHover: 'auto',
    behaveLikeLine: true,
    resize: true,
    axes: true,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
};
config.element = 'sku_arm';
config.stacked = false;
Morris.Bar(config);
</script-->