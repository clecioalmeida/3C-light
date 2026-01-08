<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:../../../index.php");
    exit;

} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION['cod_cli'];
}
?>
<?php
require_once "bd_class.php";

$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_tp = "select cod_galpao, galpao from tb_galpao where fl_empresa = '$cod_cli'";
$res_tp = mysqli_query($link, $sql_tp);

$link->close();
?>
<div id="main" role="main">
    <div id="ribbon">
        <div class="col-sm-4">
            <ol class="breadcrumb">
                <li>Home</li><li>Operacional</li><li>Janelas de recebimento</li>
            </ol>
        </div>
    </div>
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget well" id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
                        <div>
                            <div class="jarviswidget-editbox">

                            </div>
                            <div class="widget-body">
                                <hr class="simple">
                                <ul id="myTab1" class="nav nav-tabs bordered">
                                    <li class="active">
                                        <a href="#s6" id="liRecAg" data-toggle="tab">JANELAS <span class="badge bg-color-blue txt-color-white"></span></a>
                                    </li>
                                    <!--li>
                                        <a href="#s1" id="liRecPend" data-toggle="tab">ENDEREÇOS </a>
                                    </li-->
                                </ul>
                                <div id="myTabContent1" class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="s6">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">PERÍODO DE:
                                                        <input type="date" class="input-xs" id="dt_ini" name="dt_ini" style="color: black">
                                                    </label>
                                                    <label class="input">ATÉ:
                                                        <input type="date" class="input-xs" id="dt_fim" name="dt_fim" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnSaveGal" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">GERAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="retornoGal"></div>
                                            <div id="retModalGal"></div>
                                        </article>
                                    </div>
                                    <!--div class="tab-pane fade" id="s1">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">GALPÃO:
                                                        <select class="form-control" name="cod_galpao" id="cod_galpao">
                                                          <option>Selecione</option>
                                                          <?php
                                                          while ($row_select_tipo = mysqli_fetch_assoc($res_tp)) {?>
                                                            <option value="<?php echo $row_select_tipo['cod_galpao']; ?>">
                                                              <?php echo $row_select_tipo['galpao']; ?>
                                                              </option> <?php }?>
                                                          </select>
                                                    </label>
                                                    <label class="input">RUA DE:
                                                        <input type="text" class="input-xs" id="rua_ini" name="rua_ini" style="color: black">
                                                        <span> ATÉ: </span>
                                                        <input type="text" class="input-xs" id="rua_fim" name="rua_fim" style="color: black">
                                                    </label>
                                                    <label class="input">COLUNA DE:
                                                        <input type="text" class="input-xs" id="col_ini" name="col_ini" style="color: black">
                                                        <span> ATÉ: </span>
                                                        <input type="text" class="input-xs" id="col_fin" name="col_fin" style="color: black">
                                                    </label>
                                                    <label class="input">PREFIXO:
                                                        <input type="text" class="input-xs" id="ds_pre" name="ds_pre" style="color: black">
                                                        <span>POSFIXO: </span>
                                                        <input type="text" class="input-xs" id="ds_pos" name="ds_pos" style="color: black">
                                                    </label>
                                                    <label class="input">NÍVEIS:
                                                        <input type="text" class="input-xs" id="nr_nivel" name="nr_nivel" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnInsEnd" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">GERAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retornoEnd"></div>
                                            <div id="retEnd"></div>
                                            <div id="retModalEnd"></div>
                                        </article>
                                    </div-->
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <div class="row">
                <div id="retModalEntrega">
                </div>
            </div>
        </section>
    </div>
    <div id="retNfTransp"></div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        $('#retorno').load('data/recebimento/list_recebimento.php');

        $( '#liRecPend').on('click', function(){
            $('#retorno').load('data/recebimento/list_recebimento.php');
        });

        $( '#btnConsOrAb').on('click', function(){
            $('#retorno').load('data/recebimento/list_recebimento.php');
        });

        $( '#btnConsOrConf').on('click', function(){
            $('#retornoConf').load('data/recebimento/list_recebimento.php');
        });

        $( '#liRecConf').on('click', function(){
            $('#retornoConf').load('data/recebimento/list_recebimento_conf.php');
        });

        $( '#btnConsOrEnc').on('click', function(){
            $('#retornoEnc').load('data/recebimento/list_recebimento_enc.php');
        });

        $( '#liRecEnc').on('click', function(){
            $('#retornoEnc').load('data/recebimento/list_recebimento_enc.php');
        });

        $( '#liRecAg').on('click', function(){
            $('#retornoAg').load('data/recebimento/list_recebimento_ag.php');
        });

        $( '#liAg').on('click', function(){
            $('#retornoJan').load('data/recebimento/list_agenda.php');
        });

        $("#CnpjDestCte").mask("99.999.999/9999-99");
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#btnConsCte').on('click',function(){
            var nr_cte  = $('#nrCte').val();
            var dt_ini  = $('#dt_ini').val();
            var dt_fim  = $('#dt_fim').val();
            var nr_nf   = $('#NrNfCte').val();
            var nr_cnpj = $('#CnpjDestCte').val();

            if(nr_cte == '' && dt_ini == '' && dt_fim == '' && nr_nf == '' && nr_cnpj == ''){

                alert("Digite pelo menos uma das informações.");

            }else{

                $.ajax
                ({
                    url:"data/expedicao/list_cte_emitido_dtl.php",
                    method:"POST",
                    data:{
                        nr_cte:nr_cte,
                        dt_ini:dt_ini,
                        dt_fim:dt_fim,
                        nr_nf:nr_nf,
                        nr_cnpj:nr_cnpj
                    },
                    success:function(data)
                    {
                        $('#CteEmitido').html(data);
                    }
                });

            }

        });

    });
</script>
<script type="text/javascript"> 
    $(document).ready(function() {

        pageSetUp();
        var responsiveHelper_dt_basic = undefined;
        var responsiveHelper_datatable_fixed_column = undefined;
        var responsiveHelper_datatable_col_reorder = undefined;
        var responsiveHelper_datatable_tabletools = undefined;
        
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
        var otable = $('#datatable_fixed_column').DataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth" : true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback" : function() {
                if (!responsiveHelper_datatable_fixed_column) {
                    responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_datatable_fixed_column.respond();
            }       
            
        });
        $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {

            otable
            .column( $(this).parent().index()+':visible' )
            .search( this.value )
            .draw();
            
        } );
    });

</script>