<?php 
require_once('data/inventario/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select t1.id, t1.id_galpao, t1.dt_inicio, t2.nome 
from tb_inv_prog t1
left join tb_armazem t2 on t1.id_galpao = t2.id
where t1.fl_status = 'P'";
$res_inv = mysqli_query($link,$SQL); 

$SQL_torre = "select * from tb_tipo_torre";
$res_torre = mysqli_query($link,$SQL_torre); 

$SQL_conf = "select t1.nm_cliente, t1.cod_cliente, t2.nm_cargo 
            from tb_cliente t1 left join tb_cargo t2 on t1.nm_cargo = t2.cod_cargo
            where t1.nm_cargo = 20";
$res_conf = mysqli_query($link,$SQL_conf); 

$SQL_conf2 = "select t1.nm_cliente, t1.cod_cliente, t2.nm_cargo 
            from tb_cliente t1 left join tb_cargo t2 on t1.nm_cargo = t2.cod_cargo
            where t1.nm_cargo = 20";
$res_conf2 = mysqli_query($link,$SQL_conf2); 

$link->close();
?>
<div id="main" role="main">
    <div id="ribbon">
        <div class="col-sm-4">
            <ol class="breadcrumb">
            <li>Home</li><li>Movimentação</li><li>Alocação de produtos</li>
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
                                        <a href="#s6" id="btnOcorPend" data-toggle="tab">PEDIDOS ABERTOS <span class="badge bg-color-blue txt-color-white"></span></a>
                                    </li>
                                    <li>
                                        <a href="#s1" id="btnOCorFin" data-toggle="tab">PICKING </a>
                                    </li>
                                    <li>
                                        <a href="#s2" id="liRecConf" data-toggle="tab">PEDIDOS FINALIZADOS</a>
                                    </li>
                                    <li>
                                        <a href="#s3" id="liRecEnc" data-toggle="tab">EXPEDIÇÃO</a>
                                    </li>
                                    <!--li>
                                        <a href="#s4" id="liNf" data-toggle="tab">NOTAS FISCAIS</a>
                                    </li>
                                    <li>
                                        <a href="#s5" id="liPrd" data-toggle="tab">PRODUTOS</a>
                                    </li>
                                    <li>
                                        <a href="#s7" id="liAg" data-toggle="tab">JANELAS</a>
                                    </li-->
                                </ul>
                                <div id="myTabContent1" class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="s6">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="formAlocCod">
                                                    <label class="input">CONSULTA CÓDIGO
                                                        <input type="text" class="input-xs" id="codigo" name="codigo" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnFormalocarCod" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <span> | </span>
                                                    <label class="input">CONSULTA DESCRIÇÃO
                                                        <input type="text" class="input-xs" id="alocar" name="alocar" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnFormalocarNome" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="info_produtos"></div>
                                            <div id="retornoOcorrencia"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s1">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retornoAg"></div>
                                            <div id="retRomaneio"></div>
                                            <div id="retModal"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s2">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">FORNECEDOR
                                                        <input type="text" class="input-xs" id="nmForn" name="nmForn" style="color: black">
                                                    </label>
                                                    <label class="input">OR
                                                        <input type="text" class="input-xs" id="nrOr" name="nrOr" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnConsOrConf" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retornoConf"></div>
                                            <div id="retRomaneio"></div>
                                            <div id="retModal"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s3">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">FORNECEDOR
                                                        <input type="text" class="input-xs" id="nmForn" name="nmForn" style="color: black">
                                                    </label>
                                                    <label class="input">OR
                                                        <input type="text" class="input-xs" id="nrOr" name="nrOr" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnConsOrEnc" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>                                            
                                            <div id="retornoEnc"></div>
                                        </article>
                                    </div>
                                    <!--div class="tab-pane fade" id="s4">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    
                                                </form>
                                            </div>
                                        </article>
                                        <article>                                            
                                            <div id="retorno_pend"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s5">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    
                                                </form>
                                            </div>
                                        </article>
                                        <article>                                            
                                            <div id="retorno_pend"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s7">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="button" class="btn btn-success btn-xs" id="btnNovoAgRec" style="margin-right: 3px">NOVO AGENDAMENTO</button>
                                                    <span> | </span>
                                                    <label class="input">FORNECEDOR
                                                        <input type="text" class="input-xs" id="nmForn" name="nmForn" style="color: black">
                                                    </label>
                                                    <label class="input">O.R.
                                                        <input type="text" class="input-xs" id="nrOr" name="nrOr" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnConsOrAb" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="retornoJan"></div>
                                            <div id="retModalJan"></div>
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

        $('#infoOcorrencia').load('data/qualidade/list_ocor_aberta.php');

        $( '#btnOcorPend').on('click', function(){
            $('#infoOcorrencia').load('data/qualidade/list_ocor_aberta.php');
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