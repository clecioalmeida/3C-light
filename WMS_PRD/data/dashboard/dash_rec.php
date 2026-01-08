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
date_default_timezone_set('America/Sao_Paulo');
$data = date("Y-m-d H:i:s");

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_rec = "select ds_data, nr_total_sku, nr_total_nf from tb_fc_rec where fl_empresa = '$cod_cli'";
$res_rec = mysqli_query($link, $sql_rec);

$chart_data = '';
while($row = mysqli_fetch_array($res_rec))
{
   $chart_data .= "{ ds_data:'".$row["ds_data"]."', total_sku:".$row["nr_total_sku"].", total_nf:".$row["nr_total_nf"]."}, ";
}
$chart_data = substr($chart_data, 0, -2);

// AGENDAMENTOS CUMPRIDOS

$sql_ag = "select ds_data, 
(select SUM(nr_total_sts) from tb_fc_ag where ds_status = 'FINALIZADO') as total_fin, 
(select sum(nr_total_sts) as total_sts from tb_fc_ag) as total_sts, 
(select sum(nr_total_sts) as total_sts from tb_fc_ag)-(select SUM(nr_total_sts) from tb_fc_ag where ds_status = 'FINALIZADO') as total_fail 
from tb_fc_ag where fl_empresa = '$cod_cli' GROUP BY ds_data";
$res_ag = mysqli_query($link, $sql_ag);

$chart_ag = '';
while($row_ag = mysqli_fetch_array($res_ag))
{

   $chart_ag .= "{ ds_data_ag:'".$row_ag["ds_data"]."', total_sts:'".$row_ag["total_sts"]."', total_fin:".$row_ag["total_fin"].", total_fail:".$row_ag["total_fail"]."}, ";
}
$chart_ag = substr($chart_ag, 0, -2);

// AGENDAMENTOS EXTRAS

$sql_ex = "select date_format(t1.dt_janela,'%m/%Y') as dt_janela,
count(t1.id) as total_real, 
(select count(id) from tb_janela where date(dt_janela) >= '2020-01-01' and date(dt_janela) <= '2020-01-31' and fl_empresa = '$cod_cli' and fl_tipo = 'E') as total_extra,
(select count(id) from tb_janela where date(dt_janela) >= '2020-01-01' and date(dt_janela) <= '2020-01-31' and fl_empresa = '$cod_cli' and fl_tipo = 'N') as total_janela 
from tb_janela t1 
left join tb_recebimento_ag t2 on t1.cod_rec = t2.cod_recebimento 
where t2.fl_status = 'X' and (date(t1.dt_janela) >= '2020-01-01' and date(t1.dt_janela) <= '2020-01-31') and t1.fl_empresa = '$cod_cli'";
$res_ex = mysqli_query($link, $sql_ex);

$chart_ex = '';
while($row_ex = mysqli_fetch_array($res_ex))
{

   $chart_ex .= "{ dt_janela:'".$row_ex["dt_janela"]."', total_extra:'".$row_ex["total_extra"]."', total_janela:".$row_ex["total_janela"].", total_real:".$row_ex["total_real"]."}, ";
}
$chart_ex = substr($chart_ex, 0, -2);

$link->close();
?>
<br/><br/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<div id="reportPage">
    <article class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"></span>
                <h2>NOTAS FISCAIS POR SKU</h2>
            </header>
            <div>
                <div class="jarviswidget-editbox">
                </div>
                <div class="widget-body no-padding">
                    <div id="nf_sku" class="chart no-padding"></div>
                </div>
            </div>
        </div>
        <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"></span>
                <h2>AGENDAMENTOS EXTRAS</h2>
            </header>
            <div>
                <div class="jarviswidget-editbox">
                </div>
                <div class="widget-body no-padding">
                    <div id="ag_extra" class="chart no-padding"></div>
                </div>
            </div>
        </div>
        <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"></span>
                <h2>VALOR MÉDIO POR PRODUTO</h2>
            </header>
            <div>
                <div class="jarviswidget-editbox">
                </div>
                <div class="widget-body no-padding">
                    <div id="peso_veic" class="chart no-padding"></div>
                </div>
            </div>
        </div>
    </article>  
    <article class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"></span>
                <h2>AGENDAMENTOS CUMPRIDOS</h2>
            </header>
            <div>
                <div class="jarviswidget-editbox">
                </div>
                <div class="widget-body no-padding">
                    <div id="ag_ok" class="chart no-padding"></div>
                </div>
            </div>
        </div>
    </article>
</div>
<!-- meus scripts -->
<script>
    Morris.Bar({
       element : 'ag_ok',
       data:[<?php echo $chart_ag; ?>],
       xkey:'ds_data_ag',
       ykeys:['total_sts', 'total_fin','total_fail'],
       labels:['Total', 'Finalizados', 'Não cumpridos'],
       hideHover:'auto'
   });
    Morris.Bar({
       element : 'nf_sku',
       data:[<?php echo $chart_data; ?>],
       xkey:'ds_data',
       ykeys:['total_nf', 'total_sku'],
       labels:['Notas fiscais', 'Produtos'],
       hideHover:'auto'
   });
    Morris.Bar({
       element : 'ag_extra',
       data:[<?php echo $chart_data; ?>],
       xkey:'dt_janela',
       ykeys:['total_janela', 'total_real', 'total_extra'],
       labels:['', 'Produtos'],
       hideHover:'auto'
   });
</script>
<script>
</script>
<script type="text/javascript">

    $(document).ready(function() {

        pageSetUp();

        var responsiveHelper_dt_basic = undefined;

        var breakpointDefinition = {
            tablet : 1024,
            phone : 480
        };

        $('#dt_basic').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth" : true,
            "oLanguage": {
                "sSearch": '<!--span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span-->'
            },
            "preDrawCallback" : function() {

                if (!responsiveHelper_dt_basic) {
                    responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_dt_basic.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_dt_basic.respond();
            }
        });          
    })

</script>
<!--script type="text/javascript">
    $(document).ready(function() {
        var peso_dia = [];
        var my_chart = new Morris.Bar({
            element: 'peso_dia',
            data: peso_dia,
            xkey: 'mes',
            ykeys: ['vlr_total'],
            labels: ['Total']
        });

        $.ajax 
        ({
            url:"data/dashboard/chart_vlr_2.php",
            method: "GET",
            dataType: "json",
            success: function(peso_dia){
             my_chart.setData(peso_dia);
         }
     });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var peso_veic = [];
        var my_chart = new Morris.Bar({
            element: 'peso_veic',
            data: peso_veic,
            xkey: 'produto',
            ykeys: ['vlr_medio'],
            labels: ['Média']
        });

        $.ajax 
        ({
            url:"data/dashboard/chart_vlr_3.php",
            method: "GET",
            dataType: "json",
            success: function(peso_veic){
             my_chart.setData(peso_veic);
         }
     });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var viagem_data = [];
        var my_chart = new Morris.Bar({
            element: 'viagem_data',
            data: viagem_data,
            xkey: 'produto',
            ykeys: ['vlr_total'],
            labels: ['Valor']
        });

        $.ajax 
        ({
            url:"data/dashboard/chart_vlr_1.php",
            method: "GET",
            dataType: "json",
            success: function(viagem_data){
             my_chart.setData(viagem_data);
         }
     });
    });
</script-->