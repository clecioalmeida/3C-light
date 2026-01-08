<script src="js/controle_pedido.js"></script>
<script src="js/me2w.js"></script>
<div id="main" role="main">
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
                                        <a href="#s6" id="liPed" data-toggle="tab">PEDIDOS <span class="badge bg-color-blue txt-color-white"></span></a>
                                    </li>
                                    <li>
                                        <a href="#s1" id="liColPend" data-toggle="tab">SEPARAÇÃO </a>
                                    </li>
                                    <li>
                                        <a href="#s3" id="liPedConfExp" data-toggle="tab">EXPEDIÇÃO</a>
                                    </li>
                                    <li>
                                        <a href="#s2" id="liPedConfEnd" data-toggle="tab">PEDIDOS FINALIZADOS</a>
                                    </li>
                                    <li>
                                        <a href="#s4" id="liPrd" data-toggle="tab">PRODUTOS</a>
                                    </li>
                                    <li>
                                        <a href="#s5" id="liNs" data-toggle="tab">SERIALIZADOS</a>
                                    </li>
                                    <li>
                                        <a href="#s7" id="liConvUmb" data-toggle="tab">CONVERSOR UMB</a>
                                    </li>
                                    <li class="pull-right">
                                        <div>
                                            <ul id="sparks" class="">
                                                <li class="sparks-info">
                                                    <h5>ABERTOS <span class="txt-color-blue" id="tot_aberto" style="text-align: right;"></span>
                                                    </h5>
                                                </li>
                                                <li class="sparks-info">
                                                    <h5>COLETA LIBERADA <span class="txt-color-blue" id="tot_lib" style="text-align: right;"></span>
                                                    </h5>
                                                </li>
                                                <li class="sparks-info">
                                                    <h5>COLETA INICIADA <span class="txt-color-purple" id="tot_ini" style="text-align: right;"></span>
                                                    </h5>
                                                <li class="sparks-info">
                                                    <h5>AG. CONFERÊNCIA <span class="txt-color-purple" id="tot_exp" style="text-align: right;"></span>
                                                    </h5>
                                                </li>
                                                <li class="sparks-info">
                                                    <h5>AG. SAÍDA <span class="txt-color-purple" id="tot_ent" style="text-align: right;"></span>
                                                    </h5>
                                                </li>
                                                <li class="sparks-info">
                                                    <h5> TEMPO MÉDIO DE SEPARAÇÃO <span class="txt-color-blue" id="med_tempo"></span></h5>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                                <div id="myTabContent1" class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="s6">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">PEDIDO
                                                        <input type="text" class="input-xs" id="nr_pedido" name="nr_pedido" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaPedido" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <label class="input">CR
                                                        <input type="text" class="input-xs" id="nr_cr" name="nr_cr" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaNrCr" class="btn btn-info btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <label class="input">MATRÍCULA
                                                        <input type="text" class="input-xs" id="nr_matr" name="nr_matr" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaNrMatricula" class="btn btn-info btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <label class="input">STATUS
                                                        <select class="input-xs" name="ds_status" id="ds_status">
                                                            <option value="A">ABERTO</option>
                                                            <option value="X">COLETADO</option>
                                                        </select>
                                                    </label>
                                                    <button type="submit" id="btnPesquisaStatusPed" class="btn btn-info btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <button type="buttom" id="CadPedido" class="btn btn-success btn-xs" style="margin-right: 3px;width: 100px">NOVO PEDIDO</button>
                                                    <button type="buttom" id="BtnImpPedSap" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">IMPORTAR SAP</button>
                                                    <button type="buttom" id="BtnImpPedSapLp" class="btn btn-danger btn-xs" style="margin-right: 3px;width: 150px">IMPORTAR POR LP</button>
                                                    <!--button type="buttom" id="btnConsPedParc" class="btn btn-info btn-xs" style="margin-right: 3px;width: 150px">PEDIDOS PARCIAIS</button-->
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="retornoPed"></div>
                                            <div id="retModalAg"></div>
                                            <div id="retModalPedDtl"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s1">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">PEDIDO
                                                        <input type="text" class="input-xs" id="nr_pedido_sep" name="nr_pedido" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaPedidoSep" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <label class="input">DOC MATERIAL
                                                        <input type="text" class="input-xs" id="doc_material_Sep" name="doc_material" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaDocmaterialSep" class="btn btn-info btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <button type="submit" id="btnPedDist" class="btn btn-success btn-xs" style="margin-right: 3px;width: 180px">PEDIDOS SEM SEPARADOR</button>
                                                    <!-- <button type="submit" class="btn btn-success btn-xs" id="RepEstoqGenExcel" style="float:right;width: 100px">Excel</button> -->
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="infoSepara">
                                                <div id="loading_sep" style="display: none">
                                                    <img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>
                                                </div>
                                            </div>
                                            <div id="retRomaneio"></div>
                                            <div id="retModal"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s3">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">PEDIDO
                                                        <input type="text" class="input-xs" id="nr_pedido" name="nr_pedido" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaPedidoExp" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <label class="input">DOC MATERIAL
                                                        <input type="text" class="input-xs" id="doc_material_Exp" name="doc_material" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaDocmaterialExp" class="btn btn-info btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <button type="submit" id="btnGeraRomaneio" class="btn btn-success btn-xs" style="margin-right: 3px;width: 150px"> GERAR ROMANEIO</button>
                                                    <button type="buttom" id="btnListRomaneio" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px">ROMANEIO</button>
                                                    <button type="buttom" id="btnListExpedidos" class="btn btn-info btn-xs" style="margin-right: 3px;width: 150px">EXPEDIDOS</button>
                                                    <button type="buttom" id="btnCtrlTransp" class="btn btn-success btn-xs" style="margin-right: 3px;width: 200px">CONTROLE DE TRANSPORTE</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retornoConfExp"></div>
                                            <div id="retRomaneioExp"></div>
                                            <div id="retModalExp"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s2">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">PEDIDO
                                                        <input type="text" class="input-xs" id="nr_pedido_fin" name="nr_pedido" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaPedidoFin" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <span> | </span>
                                                    <label class="input">DOC MATERIAL
                                                        <input type="text" class="input-xs" id="doc_material_fin" name="doc_material" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaDocmaterialFin" class="btn btn-info btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <span> | </span>
                                                    <label class="input">DATA INICIAL
                                                        <input type="date" class="input-xs" id="dt_ini" name="dt_ini" style="color: black">
                                                    </label>
                                                    <label class="input">DATA FINAL
                                                        <input type="date" class="input-xs" id="dt_fim" name="dt_fim" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaDtFin" class="btn btn-info btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retornoConfEnd"></div>
                                            <div id="retRomaneioEnd"></div>
                                            <div id="retModalEnd"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s4">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">MATRÍCULA
                                                        <input type="text" class="input-xs" id="nr_matricula_prd" name="nr_matricula_prd" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaPedidoPrd" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <span> | </span>
                                                    <label class="input">FUNCIONÁRIO
                                                        <input type="text" class="input-xs" id="ds_nome_prd" name="ds_nome_prd" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaNomePrd" class="btn btn-info btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <span> | </span>
                                                    <label class="input">PRODUTO
                                                        <input type="text" class="input-xs" id="produto_prd" name="produto_prd" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaProdutoPrd" class="btn btn-info btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <button type="buttom" id="BtnPrdExcel" class="btn btn-success btn-xs" style="margin-right: 3px;width: 100px;float: right;">EXCEL</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retorno_prd">
                                                <div id="loading" style="display: none">
                                                    <img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s5">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">PEDIDO
                                                        <input type="text" class="input-xs" id="nr_pedido_ns" name="nr_pedido_ns" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaPedidoNs" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <span> | </span>
                                                    <label class="input">NÚMERO DE SÉRIE
                                                        <input type="text" class="input-xs" id="n_serie" name="n_serie" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaDocmaterialNs" class="btn btn-info btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <span> | </span>
                                                    <label class="input">PRODUTO
                                                        <input type="text" class="input-xs" id="produto_ns" name="produto_ns" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesquisaProdutoNs" class="btn btn-info btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <button type="buttom" id="BtnPrdExcel" class="btn btn-success btn-xs" style="margin-right: 3px;width: 150px;float: right;">EXCEL</button>
                                                    <button type="buttom" id="btnUpdNsSap" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 150px;float: right;">ATUALIZA IQ09</button>
                                                    <button type="buttom" id="btnImpMe2w" class="btn btn-info btn-xs" style="margin-right: 3px;width: 150px;float: right;">IMPORTAR ME2W</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retorno_ns"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s7">
                                        <article>

                                        </article>
                                        <article>
                                            <div id="infoSepara">
                                                <div id="loading_sep" style="display: none">
                                                    <img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>
                                                </div>
                                            </div>
                                            <div id="retornoConvUmb"></div>
                                            <div id="retModalConvUmb"></div>
                                        </article>
                                    </div>
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
    $(document).ready(function() {

        $('#retornoPed').load('data/movimento/pedido_sql_geral.php');

        $('#liPed').on('click', function() {
            $("#retornoPed").html("<br><br><br><img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
            $('#retornoPed').load('data/movimento/pedido_sql_geral.php');
        });

        //$(document).on('click', '#liPedConfEnd', function(){
        //   $('#retornoConfEnd').load('data/movimento/pedido_sql_geral_fin.php');
        //});

        $(document).on('click', '#liPedConfExp', function() {
            event.preventDefault();
            $('#retornoConfExp').load('data/movimento/pedido_sql_geral_exp.php');
        });

        $(document).on('click', '#btnConsPedParc', function(e) {
            event.preventDefault();
            $('#retornoPed').load('data/movimento/pedido_sql_parcial.php');
        });

        $(document).on('click', '#btnListRomaneio', function(e) {
            event.preventDefault();
            $('#retornoConfExp').load('data/movimento/pedido_sql_romaneio.php');
        });

        /*$(document).on('click','#liPrd',function(e){  
            event.preventDefault();
            $('#loading').show();          
            $('#retorno_prd').load('data/movimento/pedido_sql_produto.php');
            $('#loading').hide();
        });*/

        $(document).on('click', '#liColPend', function() {
            event.preventDefault();
            $('#loading_sep').show();
            $('#infoSepara').load('data/movimento/list_coleta.php');
            $('#loading_sep').hide();
        });

        $(document).on('click', '#liConvUmb', function() {
            event.preventDefault();
            $('#loading_sep').show();
            $('#retornoConvUmb').load('data/movimento/pedido_sql_umb.php');
            $('#loading_sep').hide();
        });

        $(document).on('click', '#btnPedDist', function(e) {
            event.preventDefault();
            $('#loading_sep').show();
            $('#infoSepara').load('data/movimento/list_coleta_sep.php');
            $('#loading_sep').hide();
        });

        $(document).on('click', '#btnUpdNsSap', function(e) {
            event.preventDefault();
            $('#loading').show();
            $('#retorno_ns').load('atualiza_ns_sap.php');
            $('#loading').hide();
        });

        $(document).on('click', '#btnRetPed', function() {
            $("#retornoPed").html("<br><br><br><img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
            $('#retornoPed').load('data/movimento/pedido_sql_geral.php');
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            url: "data/movimento/resumo_pedido.php",
            dataType: 'json',
            method: "POST",
            success: function(j) {
                for (var i = 0; i < j.length; i++) {

                    $('#tot_aberto').text(j[i].tot_aberto);
                    $('#tot_lib').text(j[i].tot_lib);
                    $('#tot_ini').text(j[i].tot_ini);
                    $('#tot_exp').text(j[i].tot_exp);
                    $('#tot_ent').text(j[i].tot_ent);
                }
            }
        });
    });
</script>
<!-- <script type="text/javascript">
    $('#RepEstoqGenExcel').on('click', function(){
        event.preventDefault();
        $('#RepEstoqGenExcel').prop("disabled", true);
        var today = new Date();
        $("#table_excel").table2excel({
            //exclude: ".noExl",
            name: "Relatório de separação - Analítico",
            filename: "Relatório de separação detalhado"});
        $('#RepEstoqGenExcel').prop("disabled", false);

    });
</script> -->
<script type="text/javascript">
    $(document).ready(function() {

        pageSetUp();
        var responsiveHelper_dt_basic = undefined;
        var responsiveHelper_datatable_fixed_column = undefined;
        var responsiveHelper_datatable_col_reorder = undefined;
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        $('#dt_basic').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<!--span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span-->'
            },
            "preDrawCallback": function() {
                if (!responsiveHelper_dt_basic) {
                    responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                }
            },
            "rowCallback": function(nRow) {
                responsiveHelper_dt_basic.createExpandIcon(nRow);
            },
            "drawCallback": function(oSettings) {
                responsiveHelper_dt_basic.respond();
            }
        });
        var otable = $('#datatable_fixed_column').DataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function() {
                if (!responsiveHelper_datatable_fixed_column) {
                    responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
                }
            },
            "rowCallback": function(nRow) {
                responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
            },
            "drawCallback": function(oSettings) {
                responsiveHelper_datatable_fixed_column.respond();
            }

        });
        $("#datatable_fixed_column thead th input[type=text]").on('keyup change', function() {

            otable
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();

        });
    });
</script>