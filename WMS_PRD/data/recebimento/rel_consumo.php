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

$sql_veic = "select DISTINCT nm_grupo, cod_grupo
from tb_grupo";
$res_veic = mysqli_query($link, $sql_veic);

$sql_veic2 = "select DISTINCT nm_grupo, cod_grupo
from tb_grupo";
$res_veic2 = mysqli_query($link, $sql_veic2);

$meses = array("DATAS-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");


$head = "<tr>";
foreach ($meses as $value) {

  $mes = explode('-', $value);

  $head .= "<th class='indvg' data-mes=".$mes[1].">".$mes[0]."</th>";

}

$head .= "</tr>";

?>
<?php //include 'chart_abast_v2.php';?>
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

  .direita {
    text-align: right;

  }
</style>


<!-- VALORES DE MANUTENÇÃO POR FORNECEDOR -->

<br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Demonstração de Consumo / Acompanhamento Mensal&nbsp;&nbsp;&nbsp;</strong><i class="fa fa-caret-down icon-color-bad"></i></h1></span>
  <img class="pull-right" src="img/logo3cfaz.png" alt="3Cfaz" style="width: 8%; height: 5%; margin-top: 0px">
</div>
<br><br><br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div class="widget-body">
      <table id="RepIndDemExcel" class="table" width="100%">
        <thead>
          <?php

          echo $head;      
          ?>
        </thead>
        <tbody>
          <?php

          while ($dados_veic = mysqli_fetch_assoc($res_veic)) {

            $cod_grupo = $dados_veic['cod_grupo'];
            $nm_grupo = $dados_veic['nm_grupo'];

            $f = "<tr>";

            $f .= "<td style='text-align:left'>".$nm_grupo."</td>";

            $meses_dados = array("JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

            foreach ($meses_dados as $value) {

              $meses2 = explode('-', $value);
              $mes = explode('/', $meses2[1]);

                //echo $cod_grupo."-".$mes[0]."<br>";

              $sql_total1 = "SELECT grupo,
              coalesce(GROUP_CONCAT(item_total SEPARATOR '|'),0) as total
              FROM
              (
              SELECT case when t5.nm_grupo is null then 'OUTROS' else t5.nm_grupo end as grupo, 
              round(sum(COALESCE(t2.nr_qtde,0)),0) as item_total,
              t2.dt_create as dt_create
              from tb_posicao_pallet t1
              left join tb_pedido_coleta_produto t2 on t1.nr_pedido_ant = t2.nr_pedido
              left join tb_nf_entrada_item t3 on t1.nr_or = t3.cod_rec and t1.produto = t3.produto
              left join tb_produto t4 on t1.produto = t4.cod_prod_cliente
              left join tb_grupo t5 on t4.cod_grupo = t5.cod_grupo
              where t5.cod_grupo = '".$cod_grupo."' and month(t2.dt_create) = '".$mes[0]."' and t3.fl_status <> 'E' and t2.fl_status = 'F'
            ) s";
            $res_total1 = mysqli_query($link, $sql_total1);

                //var_dump($res_total);

            while ($dados_total=mysqli_fetch_assoc($res_total1)) {

              $total_mes = explode('|', $dados_total['total']);

            }

            foreach ($total_mes as $j) {

              $f .= "<td class='indManVeic' data-mes='".$mes[0]."' data-veic='".$cod_grupo."' style='text-align:right'>".$j."</td>";

            }

          }

          $f .= "</tr>";

          echo $f;

        }

        ?>
      </tbody>
    </table>
  </div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div>
      <div class="widget-body no-padding">
        <div id="graf_ab" class="chart no-padding"></div>
      </div>
    </div>
  </div>
</div>



<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <img class="pull-left" src="img/logo3c.png" alt="3C" style="width: 7%; height: 5.3%; margin-top: 0px">
  <span class="teste2"><h1><strong>Demonstração Financeira / Acompanhamento Mensal&nbsp;&nbsp;&nbsp;</strong><i class="fa fa-caret-down icon-color-bad"></i></h1></span>
  <img class="pull-right" src="img/logo3cfaz.png" alt="3Cfaz" style="width: 8%; height: 5%; margin-top: 0px">
</div>
<br><br><br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div class="widget-body">
      <table id="RepIndDemExcel" class="table" width="100%">
        <thead>
          <?php

          echo $head;      
          ?>
        </thead>
        <tbody>
          <?php

          while ($dados = mysqli_fetch_assoc($res_veic2)) {

            $cod_grupo = $dados['cod_grupo'];
            $nm_grupo = $dados['nm_grupo'];

            $m = "<tr>";

            $m .= "<td style='text-align:left'>".$nm_grupo."</td>";

            $meses_dados2 = array("JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

            foreach ($meses_dados2 as $value2) {

              $meses3 = explode('-', $value2);
              $mes2 = explode('/', $meses3[1]);

              $sql_media = "select max(id), round(avg(vlr_med),0) as vlr_med
              from tb_vlr_est t1
              left join tb_produto t2 on t1.cod_prd = t2.cod_prod_cliente
              left join tb_grupo t3 on t2.cod_grupo = t3.cod_grupo
              where t3.cod_grupo = '".$cod_grupo."'";
              $res_media = mysqli_query($link, $sql_media);

              $dados_media = mysqli_fetch_assoc($res_media);

              $sql_total = "SELECT grupo,
              coalesce(GROUP_CONCAT(round((qtd_total * '".$dados_media['vlr_med']."'),2) SEPARATOR '|'),0) as total
              FROM
              (
              SELECT case when t5.nm_grupo is null then 'OUTROS' else t5.nm_grupo end as grupo, 
              round(sum(COALESCE(t2.nr_qtde,0)),0) as qtd_total,
              t2.dt_create as dt_create
              from tb_posicao_pallet t1
              left join tb_pedido_coleta_produto t2 on t1.nr_pedido_ant = t2.nr_pedido
              left join tb_nf_entrada_item t3 on t1.nr_or = t3.cod_rec and t1.produto = t3.produto
              left join tb_produto t4 on t1.produto = t4.cod_prod_cliente
              left join tb_grupo t5 on t4.cod_grupo = t5.cod_grupo
              where t5.cod_grupo = '".$cod_grupo."' and month(t2.dt_create) = '".$mes2[0]."' and t3.fl_status <> 'E' and  t2.fl_status = 'F'
            ) s";
            $res_total = mysqli_query($link, $sql_total);

            while ($dados_total=mysqli_fetch_assoc($res_total)) {

              $total_mes2 = explode('|', $dados_total['total']);

            }

            foreach ($total_mes2 as $k) {

              $m .= "<td class='indManVeic' style='text-align:right'>".$k."</td>";

            }

          }

          $m .= "</tr>";

          echo $m;

        }

        ?>
      </tbody>
    </table>
  </div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div>
      <div class="widget-body no-padding">
        <div id="graf_ab" class="chart no-padding"></div>
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
  var data =<?php echo json_encode($array_ab); ?>,
  config = {
    data: data,
    xkey: 'ds_data',
    ykeys: ['total'],
    labels: ['TOTAL'],hideHover: 'auto',
    pointSize: 3,
    fillOpacity: 0.6,
    behaveLikeLine: true,
    resize: true,
    barColors: ['#0061B3','#009933','#D96123'],
    axes: true,
    //ymin: 0,
    //ymax: 100,
    //goals: [98],
    //goalLineColors:['#B22222'],
    //goalStrokeWidth: 2,
    numLines: 5,
    barGap:0.5,
    barSizeRatio:0.2,
    parseTime: false
  };
  config.element = 'graf_ab';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>