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

$query_transp = "select id, ds_data, coalesce(nr_nf_rec,0) as nr_nf_rec, coalesce(nr_forn_rec,0) as nr_forn_rec, coalesce(nr_sku_rec,0) as nr_sku_rec from tb_fc_sku_rec where fl_empresa = '$cod_cli'";
$res_transp = mysqli_query($link, $query_transp);

$link->close();
?>
<?php include 'chart_nf_sku.php';?>
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
        <th>TOTAL NOTAS FISCAIS</th>
        <th>TOTAL FORNECEDORES</th>
        <th>TOTAL SKU'S RECEBIDOS</th>
        <th>MÉDIA SKU X NOTA</th>
        <th>AÇÕES</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($dados = mysqli_fetch_assoc($res_transp)) {?>
        <tr class="odd gradeX">
          <td style="text-align: left;width:100px"><?php echo $dados['ds_data']; ?></td>
          <td style="text-align: right;width:100px"><?php echo $dados['nr_nf_rec']; ?></td>
          <td style="text-align: right;width:100px"><?php echo $dados['nr_forn_rec']; ?></td>
          <td style="text-align: right;width:100px"><?php echo $dados['nr_sku_rec']; ?></td>
          <td style="text-align: right;width:50px">
            <?php 
            if($dados['nr_sku_rec'] > 0 && $dados['nr_forn_rec']  > 0){

             echo number_format(($dados['nr_sku_rec']/$dados['nr_forn_rec']), 2, '.', ''); 

           }else{

             echo "0.00%"; 
           }                       
           ?>
         </td>
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
      <h2>QUANTIDADE DE NOTAS FISCAIS E SKU RECEBIDOS</h2>
    </header>
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

  $(document).ready(function() {

    pageSetUp();

    var responsiveHelper_dt_basic1 = undefined;

    var breakpointDefinition = {
      tablet : 1024,
      phone : 480
    };

    $('#dt_basic1').dataTable({
      "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
      "t"+
      "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
      "autoWidth" : true,
      "oLanguage": {
        "sSearch": '<button type="buttom" id="btnCadRecNf" class="btn btn-primary" style="padding: right;width: 100px">NOVO</button><!--span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span-->'
      },
      "preDrawCallback" : function() {

        if (!responsiveHelper_dt_basic1) {
          responsiveHelper_dt_basic1 = new ResponsiveDatatablesHelper($('#dt_basic1'), breakpointDefinition);
        }
      },
      "rowCallback" : function(nRow) {
        responsiveHelper_dt_basic1.createExpandIcon(nRow);
      },
      "drawCallback" : function(oSettings) {
        responsiveHelper_dt_basic1.respond();
      }
    });          
  })

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
    hideHover: 'auto',
    behaveLikeLine: true,
    resize: true,
    axes: true,
    barGap:4,
    barSizeRatio:0.35,
    parseTime: true
  };
  config.element = 'rec_nf';
  config.stacked = false;
  Morris.Bar(config);
</script>