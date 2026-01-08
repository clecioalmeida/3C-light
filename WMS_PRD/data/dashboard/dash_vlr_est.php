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

$query_transp = "select id, date_format(ds_data,'%m/%Y') as ds_data, concat('R$ ',format(sum(COALESCE(vlr_total,0)),2,'de_DE')) as vlr_total, concat('R$ ',format(sum(COALESCE(vlr_medio,0)),2,'de_DE')) as vlr_medio from tb_fc_est where fl_empresa = '$cod_cli' and fl_tipo = 'V' group by month(ds_data)";
$res_transp = mysqli_query($link, $query_transp);

$link->close();
?>
<?php include 'chart_vlr_est.php';?>
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
  <button type="buttom" id="btnCadIndVlrEst" class="btn btn-info btn-xs" style="float:left;width: 150px;background-color: #0061B3">NOVO</button>
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Valor do estoque&nbsp;&nbsp;&nbsp;</strong><i class="fa fa-caret-up icon-color-good"></i></h1></span>
  <img class="pull-right" src="img/logo3cfaz.png" alt="3Cfaz" style="width: 8%; height: 5%; margin-top: 0px">
</div>
<br><br><br><br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div class="widget-body">
      <table id="RepIndDemExcel" class="table" width="100%">
        <thead>
          <tr>
            <th>DATA</th>
            <th>VALOR TOTAL DO ESTOQUE</th>
            <th>VALOR MÉDIO DO ESTOQUE</th>
            <th>AÇÕES</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($dados = mysqli_fetch_assoc($res_transp)) {?>
            <tr class="odd gradeX">
              <td style="text-align: left;width:200px"><?php echo $dados['ds_data']; ?></td>
              <td class="indVlrEst" style="text-align: right;width:100px"><?php echo $dados['vlr_total']; ?></td>
              <td class="indVlrEst" style="text-align: right;width:100px"><?php echo $dados['vlr_medio']; ?></td>
              <td class="indVlrEst" style="text-align: left;width:150px">
                <button type="submit" class="btn btn-primary btn-xs" id="btnUpdVlrEst" value="<?php echo $dados['id'];?>">ALTERAR</button>
                <button type="submit" class="btn btn-danger btn-xs" id="btnDelDem" value="<?php echo $dados['id'];?>" disabled>EXCLUIR</button>
              </td>
            </tr>
          </tbody>
        <?php }?>
      </table>
    </div>
  </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="printGraph">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div>
      <div class="widget-body no-padding">
        <div id="vlr_est" class="chart no-padding"></div>
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
    ykeys: ['vlr_total'],
    labels: ['Valor total do estoque'],hideHover: 'auto',
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
  config.element = 'vlr_est';
  config.stacked = false;
  Morris.Bar(config);
</script>