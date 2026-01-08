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

$query_transp = "SELECT dt_exp as data_exp, date_format(dt_exp,'%d-%m-%Y') as dt_exp, sum(nr_total_ped) as nr_total_ped, round(avg(nr_total_dia),2) as media_dia FROM tb_fc_tmp_ped WHERE fl_empresa = '$cod_cli' and date(dt_exp) BETWEEN CURRENT_DATE() -30 AND CURRENT_DATE()
group by date(dt_exp) order by date(dt_exp) desc limit 60";
$res_transp = mysqli_query($link, $query_transp);

$sql_mes = "SELECT concat(month(dt_exp),'-',year(dt_exp)) as dt_exp, sum(nr_total_ped) as nr_total_ped, round(avg(nr_total_dia),2) as media_mes FROM tb_fc_tmp_ped WHERE fl_empresa = '$cod_cli'
group by month(dt_exp)";
$res_mes = mysqli_query($link, $sql_mes);

$link->close();
?>
<?php include 'chart_tempo_medio.php';?>
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
  <button type="buttom" id="" class="btn btn-info btn-xs" disabled style="float:left;width: 150px;background-color: #0061B3">NOVO</button>
</div>
<br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Tempo médio de entrega&nbsp;&nbsp;&nbsp;</strong><i class="fa fa-caret-down icon-color-bad"></i></h1></span>
  <img class="pull-right" src="img/logo3cfaz.png" alt="3Cfaz" style="width: 8%; height: 5%; margin-top: 0px">
</div>
<br><br><br><br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div class="widget-body">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <table id="RepIndCronExcel" class="table" width="100%">
          <thead>
            <tr>
              <th>MÊS</th>
              <th>TOTAL PEDIDOS</th>
              <th>TEMPO MÉDIO (DATA DO PEDIDO X FIM DA EXPEDIÇÃO)</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($dados_mes = mysqli_fetch_assoc($res_mes)) {?>
              <tr>
                <td style="text-align: left;width:200px"><?php echo $dados_mes['dt_exp']; ?></td>
                <td style="text-align: right;width:15px"><?php echo $dados_mes['nr_total_ped']; ?></td>
                <td style="text-align: right;width:15px"><?php echo $dados_mes['media_mes']; ?></td>
              </tr>
            </tbody>
          <?php }?>
        </table>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
        <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
          <header>
            <span class="widget-icon"></span>
            <h2>TEMPO MÉDIO MENSAL DE EXPEDIÇÃO</h2>
          </header>
          <div>
            <div class="widget-body no-padding">
              <div id="tmp_exp_mes" class="chart no-padding"></div>
            </div>
          </div>
        </div>
      </div> 
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <table id="RepIndCronExcel" class="table" width="100%">
          <thead>
            <tr>
              <th>DIA</th>
              <th>TOTAL PEDIDOS</th>
              <th>TEMPO MÉDIO (DATA DO PEDIDO X FIM DA EXPEDIÇÃO)</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($dados = mysqli_fetch_assoc($res_transp)) {?>
              <tr class="indTmpExpede" data-exp="<?php echo $dados['data_exp']; ?>">
                <td style="text-align: left;width:200px"><?php echo $dados['dt_exp']; ?></td>
                <td style="text-align: right;width:15px"><?php echo $dados['nr_total_ped']; ?></td>
                <td style="text-align: right;width:100px"><?php echo $dados['media_dia']; ?></td>
              </tr>
            </tbody>
          <?php }?>
        </table>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="printGraph">
        <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
          <header>
            <span class="widget-icon"></span>
            <h2>TEMPO MÉDIO DE EXPEDIÇÃO POR DIA - MÊS ATUAL</h2>
          </header>
          <div>
            <div class="widget-body no-padding">
              <div id="tmp_exp" class="chart no-padding"></div>
            </div>
          </div>
        </div>
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
  var data =<?php echo json_encode($array_expede); ?>,
  config = {
    data: data,
    xkey: 'dt_exp',
    ykeys: ['media_dia', 'prazo'],
    labels: ['Tempo médio', 'Prazo'],hideHover: 'auto',
    pointSize: 3,
    parseTime: false,
    resize: true
  };
  config.element = 'tmp_exp';
  config.stacked = true;
  Morris.Line(config).on('click', function(i, row){
    var dt_exp = row.data_exp;
    $.ajax
    ({
      url:"data/dashboard/modal/m_list_tmp_exp.php",
      method:"POST",
      data:{dt_exp:dt_exp},
      success:function(data)
      {
        $('#retModalCron').html(data);
      }
    });
  });
</script>
<script type="text/javascript">
  var data =<?php echo json_encode($array_mes); ?>,
  config = {
    data: data,
    xkey: 'dt_exp',
    ykeys: ['media_mes', 'prazo'],
    labels: ['Tempo médio', 'Prazo'],hideHover: 'auto',
    pointSize: 3,
    parseTime: false,
    resize: true
  };
  config.element = 'tmp_exp_mes';
  config.stacked = true;
  Morris.Line(config);
</script>