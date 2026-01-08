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

$query_transp = "select t1.produto, t2.nm_produto
from tb_posicao_pallet t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
where t1.fl_empresa = '$cod_cli' and t1.fl_status <> 'E'
group by t1.produto
order by count(t1.produto)
limit 50";
$res_transp = mysqli_query($link, $query_transp);

$link->close();
?>
<article class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
        <header>
            <span class="widget-icon"></span>
            <h2>TOTAL DE PRODUTOS EM ESTQOUE</h2>
        </header>
        <div>
            <div class="jarviswidget-editbox">
            </div>
            <div class="widget-body no-padding">
                <div id="sku_mes" class="chart no-padding"></div>
            </div>
        </div>
    </div>
    <!--div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
        <header>
            <span class="widget-icon"></span>
            <h2>VALOR TOTAL POR PRODUTO</h2>
        </header>
        <div>
            <div class="jarviswidget-editbox">
            </div>
            <div class="widget-body no-padding">
                <div id="viagem_data" class="chart no-padding"></div>
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
    </div-->
</article>  
<article class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <table id="dt_basic2" class="table table-bordered" width="100%">
        <thead>
            <tr>
                <th style="width:50px">PRODUTO</th>
                <th style="width:150px">DESCRIÇÃO</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($dados = mysqli_fetch_assoc($res_transp)) {?>
                <tr class="odd gradeX">
                    <td style="text-align: right;"><?php echo $dados['produto']; ?></td>
                    <td style="text-align: left;"><?php echo $dados['nm_produto']; ?></td>
                </tr>
            </tbody>
        <?php }?>
    </table>
</article>
<!-- meus scripts -->
<script type="text/javascript">

    $(document).ready(function() {

        pageSetUp();

        var responsiveHelper_dt_basic2 = undefined;

        var breakpointDefinition = {
            tablet : 1024,
            phone : 480
        };

        $('#dt_basic2').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth" : true,
            "oLanguage": {
                "sSearch": '<!--span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span-->'
            },
            "preDrawCallback" : function() {

                if (!responsiveHelper_dt_basic2) {
                    responsiveHelper_dt_basic2 = new ResponsiveDatatablesHelper($('#dt_basic2'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_dt_basic2.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_dt_basic2.respond();
            }
        });          
    })

</script>
<script type="text/javascript">
    $(document).ready(function() {
        var sku_mes = [];
        var my_chart = new Morris.Bar({
            element: 'sku_mes',
            data: sku_mes,
            xkey: 'mes',
            ykeys: ['total_sku'],
            labels: ['Total']
        });

        $.ajax 
        ({
            url:"data/dashboard/chart_sku_1.php",
            method: "GET",
            dataType: "json",
            success: function(sku_mes){
               my_chart.setData(sku_mes);
           }
       });
    });
</script>
<!--script type="text/javascript">
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