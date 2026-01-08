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

$query_transp = "select t3.produto, date_format(t3.dt_rec,'%d/%m/%Y') as dt_rec, format(t3.vl_unit,2,'de_DE') as vl_unit,t3.nr_qtde, format((t3.vl_unit/t3.nr_qtde),2,'de_DE') as vlr_unitario
from tb_posicao_pallet t1
left join tb_nf_entrada t2 on t1.nr_or = t2.cod_rec
left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
where t1.fl_empresa = '$cod_cli' and t1.nr_or is not null and t1.fl_status <> 'E' and MONTH(t3.dt_rec)=(MONTH(NOW())) and t3.vl_unit >= 0
group by t3.vl_unit desc";
$res_transp = mysqli_query($link, $query_transp);

$link->close();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<a href="#" id="downloadPdf">Download Report Page as PDF</a>
<br/><br/>
<div id="reportPage">
    <article class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"></span>
                <h2>VALOR TOTAL DO ESTOQUE POR MÊS</h2>
            </header>
            <div>
                <div class="jarviswidget-editbox">
                </div>
                <div class="widget-body no-padding">
                    <canvas id="peso_dia" class="chart no-padding"></canvas>
                </div>
            </div>
        </div>
        <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"></span>
                <h2>VALOR TOTAL POR PRODUTO</h2>
            </header>
            <div>
                <div class="jarviswidget-editbox">
                </div>
                <div class="widget-body no-padding">
                    <canvas id="viagem_data" class="chart no-padding"></canvas>
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
                    <canvas id="peso_veic" class="chart no-padding"></canvas>
                </div>
            </div>
        </div>
    </article>  
    <article class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <table id="dt_basic" class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th style="width:30px">PRODUTO</th>
                    <th style="width:50px">VALOR TOTAL DA ENTRADA</th>
                    <th style="width:75px">QUANTIDADE</th>
                    <th style="width:300px">VALOR UNITÁRIO</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($dados = mysqli_fetch_assoc($res_transp)) {?>
                    <tr class="odd gradeX">
                        <td style="text-align: right;"><?php echo $dados['produto']; ?></td>
                        <td style="text-align: right;"><?php echo $dados['vl_unit']; ?></td>
                        <td style="text-align: right;"><?php echo $dados['nr_qtde']; ?></td>
                        <td style="text-align: right;"><?php echo $dados['vlr_unitario']; ?></td>
                    </tr>
                </tbody>
            <?php }?>
        </table>
    </article>
</div>
<!-- meus scripts -->
<script type="text/javascript">


    $('#downloadPdf').click(function(event) {
  // get size of report page
  var reportPageHeight = $('#reportPage').innerHeight();
  var reportPageWidth = $('#reportPage').innerWidth();
  
  // create a new canvas object that we will populate with all other canvas objects
  var pdfCanvas = $('<canvas />').attr({
    id: "canvaspdf",
    width: reportPageWidth,
    height: reportPageHeight
});
  
  // keep track canvas position
  var pdfctx = $(pdfCanvas)[0].getContext('2d');
  var pdfctxX = 0;
  var pdfctxY = 0;
  var buffer = 100;
  
  // for each chart.js chart
  $("canvas").each(function(index) {
    // get the chart height/width
    var canvasHeight = $(this).innerHeight();
    var canvasWidth = $(this).innerWidth();
    
    // draw the chart into the new canvas
    pdfctx.drawImage($(this)[0], pdfctxX, pdfctxY, canvasWidth, canvasHeight);
    pdfctxX += canvasWidth + buffer;
    
    // our report page is in a grid pattern so replicate that in the new canvas
    if (index % 2 === 1) {
      pdfctxX = 0;
      pdfctxY += canvasHeight + buffer;
  }
});
  
  // create new pdf and add our new canvas as an image
  var pdf = new jsPDF('l', 'pt', [reportPageWidth, reportPageHeight]);
  pdf.addImage($(pdfCanvas)[0], 'PNG', 0, 0);
  
  // download the pdf
  pdf.save('filename.pdf');
});
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
<script type="text/javascript">
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
</script>