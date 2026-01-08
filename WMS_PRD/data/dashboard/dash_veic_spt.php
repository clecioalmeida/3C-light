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

$query_transp = "select * from tb_fc_veic where fl_empresa = '$cod_cli' order by ds_data asc";
$res_transp = mysqli_query($link, $query_transp);

$link->close();
?>
<?php include 'chart_veic_spt.php';?>
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
    <button type="buttom" id="btnCadIndCron" class="btn btn-info btn-xs" style="float:left;width: 150px">NOVO</button>
    <button type="submit" class="btn btn-primary btn-xs" id="BtnIndCronExcel" style="float:left;width: 150px">Excel</button>
    <button onclick="printContent('printGraph')" type="submit" id="print" class="btn btn-success btn-xs" style="float:left;width: 150px"> IMPRIMIR GRÁFICO</button><br><br>
</div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <table id="RepIndCronExcel" class="table table-bordered" width="100%">
        <thead>
            <tr>
                <th>DATA</th>
                <th>TOTAL DE ENTREGAS</th>
                <th>ENTREGA SPOT</th>
                <th>MÉDIA POR DIA</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($dados = mysqli_fetch_assoc($res_transp)) {?>
                <tr class="odd gradeX">
                    <td style="text-align: left;width:100px"><?php echo $dados['ds_data']; ?></td>
                    <td style="text-align: right;width:100px"><?php echo $dados['nr_veic_total']; ?></td>
                    <td style="text-align: right;width:100px"><?php echo $dados['nr_veic_sp']; ?></td>
                    <td style="text-align: right;width:50px">
                        <?php 
                            if($dados['nr_veic_sp'] > 0 && $dados['nr_veic_total']  > 0){

                                echo number_format(($dados['nr_veic_sp']/$dados['nr_dia_total']), 2, '.', '');

                            }else{

                               echo "0.00"; 
                           }                       
                       ?>
                   </td>
                   <td style="text-align: left;width:150px">
                      <button type="submit" class="btn btn-primary btn-xs" id="btnUpdCron" value="<?php echo $dados['id'];?>">ALTERAR</button>
                      <button type="submit" class="btn btn-danger btn-xs" id="btnDelCron" value="<?php echo $dados['id'];?>" disabled>EXCLUIR</button>
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
            <h2>VEÍCULOS EXPEDIDO SPOT</h2>
        </header>
        <div>
            <div class="widget-body no-padding">
                <div id="cron_at" class="chart no-padding"></div>
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
      ykeys: ['media'],
      labels: ['Média'],
      pointSize: 3,
      fillOpacity: 0.6,
      behaveLikeLine: true,
      resize: true,
      axes: true,
      //ymin: 80,
      //ymax: 100,
      //events: ['media'],
      //goals: ['media'],
      //goalLineColors:['#B22222'],
      //goalStrokeWidth: 2,
      numLines: 5,
      barGap:4,
      barSizeRatio:0.35,
      parseTime: true
  };
  config.element = 'cron_at';
  config.stacked = false;
  config.hideHover = false;
  Morris.Bar(config);
</script>