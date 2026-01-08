<?php

require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$dt_ini = $_POST['dt_ini'];
$dt_fim = $_POST['dt_fim'];
$nr_cr  = $_POST['nr_cr'];

if($nr_cr != ""){

  $sql_veic4 = "select DISTINCT t1.ds_custo as cod_depto
  from tb_pedido_coleta t1
  where t1.ds_custo = '$nr_cr'";
  $res_veic4 = mysqli_query($link, $sql_veic4);

  $sql_veic3 = "select DISTINCT t1.ds_custo as cod_depto
  from tb_pedido_coleta t1
  where t1.ds_custo = '$nr_cr'";
  $res_veic3 = mysqli_query($link, $sql_veic3);

  $where = "and t6.ds_custo = '$nr_cr'";

}else{

  $sql_veic4 = "select DISTINCT t1.cod_depto
  from tb_funcionario t1
  left join tb_pedido_coleta t2 on t1.nr_matricula = t2.cod_almox
  where t2.cod_almox > 0 and t2.fl_status = 'F' and t1.cod_depto > 0
  order by t1.cod_depto";
  $res_veic4 = mysqli_query($link, $sql_veic4);

  $sql_veic3 = "select DISTINCT t1.cod_depto
  from tb_funcionario t1
  left join tb_pedido_coleta t2 on t1.nr_matricula = t2.cod_almox
  where t2.cod_almox > 0 and t2.fl_status = 'F' and t1.cod_depto > 0
  order by t1.cod_depto";
  $res_veic3 = mysqli_query($link, $sql_veic3);

  $where = " ";

}

$sql_veic = "SELECT t5.cod_grupo, case when t5.nm_grupo is null then 'OUTROS' else t5.nm_grupo end as grupo
from tb_pedido_coleta_produto t2
left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
left join tb_grupo t5 on t4.cod_grupo = t5.cod_grupo
group by t5.cod_grupo";
$res_veic = mysqli_query($link, $sql_veic);

$sql_veic2 = "SELECT t5.cod_grupo, case when t5.nm_grupo is null then 'OUTROS' else t5.nm_grupo end as grupo
from tb_pedido_coleta_produto t2
left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
left join tb_grupo t5 on t4.cod_grupo = t5.cod_grupo
group by t5.cod_grupo";
$res_veic2 = mysqli_query($link, $sql_veic2);

$meses = array("DATAS-00","JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");


$head = "<tr>";
foreach ($meses as $value) {

  $mes = explode('-', $value);

  $head .= "<th class='indvg' data-mes=".$mes[1].">".$mes[0]."</th>";

}

$head .= "</tr>";

?>
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

<div>
  <fieldset>
    <section>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="">
        <h2 style="color:white;text-align: left;">PERÍODO</h2>
        <form class="form-inline" id="formListDashDt">
          <div class="form-group">
            <input type="date" id="dt_ini" name="dt_ini" class="form-control" style="display:inline"/>
            <input type="date" id="dt_fim" name="dt_fim" class="form-control" style="display:inline"/>
            <input type="text" id="nr_cr" name="nr_cr" class="form-control" placeholder="Centro de custo" style="display:inline;text-align: right;"/>
            <input type="button" class="form-control btn-info" id="btnRetDashHome" value="Pesquisar" style="display:inline; width: 80px;border-radius:10px"/>
            <!--input type="button" class="form-control btn-success" id="BtnIndDemExcel" value="Excel" style="display:inline; width: 80px;border-radius:10px"/-->
          </div>
        </form>
      </div>
    </section>
  </fieldset>
</div>
<br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <span class="teste2" style="color:white"><h1><strong>Demonstração de Consumo / Grupo de produtos&nbsp;&nbsp;&nbsp;<i class="icon-append fa fa-file-excel-o" id="BtnIndDemExcel1" style="margin-left: 5px"></i></strong></h1></span>
</div>
<br><br><br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div class="widget-body">
      <table id="RepIndDemExcel1" class="table" width="100%">
        <thead>
          <?php

          echo $head;      
          ?>
        </thead>
        <tbody>
          <?php

          while ($dados_veic = mysqli_fetch_assoc($res_veic)) {

            $cod_grupo = $dados_veic['cod_grupo'];
            $nm_grupo = $dados_veic['grupo'];

            $f = "<tr>";

            $f .= "<td style='text-align:left'>".$nm_grupo."</td>";

            $meses_dados = array("JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

            foreach ($meses_dados as $value) {

              $meses2 = explode('-', $value);
              $mes = explode('/', $meses2[1]);

              $sql_total1 = "SELECT cod_grupo, coalesce(GROUP_CONCAT(item_total SEPARATOR '|'),0) as total
              FROM
              (
              SELECT t5.cod_grupo, 
              round(sum(COALESCE(t2.nr_qtde,0)),0) as item_total,
              t2.dt_create as dt_create
              from tb_pedido_coleta_produto t2
              left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
              left join tb_grupo t5 on t4.cod_grupo = t5.cod_grupo
              left join tb_pedido_coleta t6 on t2.nr_pedido = t6.nr_pedido
              where coalesce(t5.cod_grupo,0) = '".$cod_grupo."' and month(t2.dt_create) = '".$mes[0]."' and date(t2.dt_create) >= '".$dt_ini."' and date(t2.dt_create) <= '".$dt_fim."' and t2.fl_status = 'F' " .$where."
            ) s";
            $res_total1 = mysqli_query($link, $sql_total1);

            while ($dados_total=mysqli_fetch_assoc($res_total1)) {

              $total_mes = explode('|', $dados_total['total']);

            }

            foreach ($total_mes as $j) {

              $f .= "<td class='ConsGrupoQtd' data-mes='".$mes[0]."' data-grp='".$cod_grupo."' style='text-align:right'>".$j."</td>";

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
</div><br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <span class="teste2" style="color:white"><h1><strong>Demonstração Financeira / Grupo de produtos&nbsp;&nbsp;&nbsp;<i class="icon-append fa fa-file-excel-o" id="BtnIndDemExcel2" style="margin-left: 5px"></i></strong></h1></strong></h1></span>
  <br><br><br><br>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div class="widget-body">
      <table id="RepIndDemExcel2" class="table" width="100%">
        <thead>
          <?php

          echo $head;      
          ?>
        </thead>
        <tbody>
          <?php

          while ($dados = mysqli_fetch_assoc($res_veic2)) {

            $cod_grupo = $dados['cod_grupo'];
            $nm_grupo = $dados['grupo'];

            $m = "<tr>";

            $m .= "<td style='text-align:left'>".$nm_grupo."</td>";

            $meses_dados2 = array("JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

            foreach ($meses_dados2 as $value2) {

              $meses3 = explode('-', $value2);
              $mes2 = explode('/', $meses3[1]);

              $sql_total = "SELECT coalesce(GROUP_CONCAT(concat('R$ ',(qtd_total)) SEPARATOR '|'),0) as total, cod_grupo
              FROM
              (
              SELECT format(sum(t2.nr_qtde*t2.vl_unit),2,'de_De') as qtd_total,
              t5.cod_grupo
              from tb_pedido_coleta_produto t2
              left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
              left join tb_grupo t5 on t4.cod_grupo = t5.cod_grupo
              left join tb_pedido_coleta t6 on t2.nr_pedido = t6.nr_pedido
              where coalesce(t5.cod_grupo,0) = '".$cod_grupo."' and month(t2.dt_create) = '".$mes2[0]."' and date(t2.dt_create) >= '".$dt_ini."' and date(t2.dt_create) <= '".$dt_fim."' and t2.fl_status = 'F' " .$where."
            ) s";
            $res_total = mysqli_query($link, $sql_total);

            while ($dados_total=mysqli_fetch_assoc($res_total)) {

              $total_mes2 = explode('|', $dados_total['total']);

            }

            foreach ($total_mes2 as $k) {

              $m .= "<td class='ConsGrupoVlr' data-mes='".$mes2[0]."' data-grp='".$cod_grupo."' style='text-align:right'>".$k."</td>";

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
</div><br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <span class="teste2" style="color:white"><h1><strong>Demonstração de Consumo / Centro de custo&nbsp;&nbsp;&nbsp;<i class="icon-append fa fa-file-excel-o" id="BtnIndDemExcel3" style="margin-left: 5px"></i></strong></h1></strong></h1></span>
  <br><br><br><br>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div class="widget-body">
      <table id="RepIndDemExcel3" class="table" width="100%">
        <thead>
          <?php

          echo $head;      
          ?>
        </thead>
        <tbody>
          <?php

          while ($dados_veic3 = mysqli_fetch_assoc($res_veic3)) {

            $cod_depto  = $dados_veic3['cod_depto'];

            $n = "<tr>";

            $n .= "<td style='text-align:left'>".$cod_depto."</td>";

            $meses_dados3 = array("JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

            foreach ($meses_dados3 as $value3) {

              $meses4 = explode('-', $value3);
              $mes4 = explode('/', $meses4[1]);

              $sql_total1 = "SELECT cod_depto,
              coalesce(GROUP_CONCAT(item_total SEPARATOR '|'),0) as total
              FROM
              (
              SELECT coalesce(t6.ds_custo,0) as cod_depto, round(sum(COALESCE(t2.nr_qtde,0)),0) as item_total,
              t2.dt_create as dt_create
              from tb_pedido_coleta t6
              left join tb_pedido_coleta_produto t2 on t2.nr_pedido = t6.nr_pedido
              where t6.ds_custo = '".$cod_depto."' and month(t6.dt_create) = '".$mes4[0]."' and date(t6.dt_create) >= '".$dt_ini."' and date(t6.dt_create) <= '".$dt_fim."' and t6.fl_status = 'F'
            ) s";
            $res_total1 = mysqli_query($link, $sql_total1);

            while ($dados_total=mysqli_fetch_assoc($res_total1)) {

              $total_mes = explode('|', $dados_total['total']);

            }

            foreach ($total_mes as $o) {

              $n .= "<td class='ConsCcQtd' data-mes='".$mes4[0]."' data-cc='".$cod_depto."' style='text-align:right'>".$o."</td>";

            }

          }

          $n .= "</tr>";

          echo $n;

        }

        ?>
      </tbody>
    </table>
  </div>
</div>
</div><br><br>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <span class="teste2" style="color:white"><h1><strong>Demonstração Financeira / Centro de custo&nbsp;&nbsp;&nbsp;<i class="icon-append fa fa-file-excel-o" id="BtnIndDemExcel4" style="margin-left: 5px"></i></strong></h1></strong></h1></span>
  <br><br><br><br>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
    <div class="widget-body">
      <table id="RepIndDemExcel4" class="table" width="100%">
        <thead>
          <?php

          echo $head;      
          ?>
        </thead>
        <tbody>
          <?php

          while ($dados4 = mysqli_fetch_assoc($res_veic4)) {

            $cod_depto = $dados4['cod_depto'];

            $p = "<tr>";

            $p .= "<td style='text-align:left'>".$cod_depto."</td>";

            $meses_dados4 = array("JANEIRO-01/2020", "FEVEREIRO-02/2020", "MARÇO-03/2020", "ABRIL-04/2020", "MAIO-05/2020", "JUNHO-06/2020", "JULHO-07/2020", "AGOSTO-08/2020", "SETEMBRO-09/2020", "OUTUBRO-10/2020", "NOVEMBRO-11/2020", "DEZEMBRO-12/2020");

            foreach ($meses_dados4 as $value4) {

              $meses5 = explode('-', $value4);
              $mes5 = explode('/', $meses5[1]);

              $sql_total = "SELECT coalesce(GROUP_CONCAT(concat('R$ ',total_ped) SEPARATOR '|'),0) as total, ds_custo
              FROM
              (
              select format(sum(t1.nr_qtde*t1.vl_unit),2,'de_De') as total_ped, t6.ds_custo
              from tb_pedido_coleta_produto t1
              left join tb_pedido_coleta t6 on t1.nr_pedido = t6.nr_pedido
              where t6.ds_custo = '".$cod_depto."' and month(t6.dt_create) = '".$mes5[0]."' and date(t6.dt_create) >= '".$dt_ini."' and date(t6.dt_create) <= '".$dt_fim."' and t6.fl_status = 'F'
            ) s";
            $res_total = mysqli_query($link, $sql_total);
            while ($dados_total=mysqli_fetch_assoc($res_total)) {

              $total_mes2 = explode('|', $dados_total['total']);

            }

            foreach ($total_mes2 as $q) {

              $p .= "<td class='ConsCcVlr' data-mes='".$mes5[0]."' data-cc='".$cod_depto."' style='text-align:right'>".$q."</td>";

            }

          }

          $p .= "</tr>";

          echo $p;

        }


        ?>
      </tbody>
    </table>
  </div>
</div>
</div>
<?php  $link->close(); ?>
<!-- meus scripts -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#BtnIndDemExcel1').on('click', function(){
      event.preventDefault();
      $('#BtnIndDemExcel1').prop("disabled", true);
      var today = new Date();
      $("#RepIndDemExcel1").table2excel({
        exclude: ".noExl",
        name: "Relatório de consumo EPI's - Analítico",
        filename: "Relatório de consumo EPI's - Analítico"
      });
      $('#BtnIndDemExcel1').prop("disabled", false);
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#BtnIndDemExcel2').on('click', function(){
      event.preventDefault();
      $('#BtnIndDemExcel2').prop("disabled", true);
      var today = new Date();
      $("#RepIndDemExcel2").table2excel({
        exclude: ".noExl",
        name: "Relatório de consumo EPI's - Analítico",
        filename: "Relatório de consumo EPI's - Analítico"
      });
      $('#BtnIndDemExcel2').prop("disabled", false);
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#BtnIndDemExcel3').on('click', function(){
      event.preventDefault();
      $('#BtnIndDemExcel3').prop("disabled", true);
      var today = new Date();
      $("#RepIndDemExcel3").table2excel({
        exclude: ".noExl",
        name: "Relatório de consumo EPI's - Analítico",
        filename: "Relatório de consumo EPI's - Analítico"
      });
      $('#BtnIndDemExcel3').prop("disabled", false);
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#BtnIndDemExcel4').on('click', function(){
      event.preventDefault();
      $('#BtnIndDemExcel4').prop("disabled", true);
      var today = new Date();
      $("#BtnIndDemExcel4").table2excel({
        exclude: ".noExl",
        name: "Relatório de consumo EPI's - Analítico",
        filename: "Relatório de consumo EPI's - Analítico"
      });
      $('#BtnIndDemExcel4').prop("disabled", false);
    });
  });
</script>