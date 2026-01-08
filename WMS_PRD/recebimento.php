<?php

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "SELECT distinct c.nm_fornecedor, c.id, c.fl_status
FROM tb_nserie_col c
WHERE c.nm_fornecedor <> '' and (c.fl_status = 'A' or c.fl_status = 'P')
ORDER BY c.nm_fornecedor asc";
$res = mysqli_query($link, $sql);

$link->close();
?>

<script src="js/recebimento.js"></script>
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
                                        <a href="#s6" id="liRecPend" data-toggle="tab">ENTRADAS <span class="badge bg-color-blue txt-color-white"></span></a>
                                    </li>
                                    <!--li>
                                        <a href="#s1" id="liRecPend" data-toggle="tab">OR ABERTA </a>
                                    </li>
                                    <li>
                                        <a href="#s2" id="liRecConf" data-toggle="tab">OR EM CONFERÊNCIA</a>
                                    </li-->
                                    <li>
                                        <a href="#s3" id="liRecEnc" data-toggle="tab">OR FINALIZADA</a>
                                    </li>
                                    <li>
                                        <a href="#s4" id="liNf" data-toggle="tab">NOTAS FISCAIS</a>
                                    </li>
                                    <li>
                                        <a href="#s5" id="liPrd" data-toggle="tab">PRODUTOS</a>
                                    </li>
                                    <li>
                                        <a href="#s9" id="liPrdSer" data-toggle="tab">SERIAIS</a>
                                    </li>
                                    <li>
                                        <a href="#s7" id="liAg" data-toggle="tab">JANELAS</a>
                                    </li>
                                    <li>
                                        <a href="#s8" id="lirep" data-toggle="tab">RELATÓRIOS</a>
                                    </li>
                                </ul>
                                <div id="myTabContent1" class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="s6">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="button" class="btn btn-info btn-xs" id="btnNovoRec" style="margin-right: 3px;width: 100px">NOVA OR</button>
                                                    <button type="button" class="btn btn-success btn-xs" id="btnImpSap" style="margin-right: 3px;width: 150px">IMPORTAR ENTRADAS</button>
                                                    <button type="button" class="btn btn-primary btn-xs" id="btnNfPend" style="margin-right: 3px;width: 150px">DIVERGÊNCIA NF</button>
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
                                        <article>
                                            <div id="retorno"></div>
                                            <div id="retRomaneio"></div>
                                            <div id="retModal"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s1">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="button" class="btn btn-success btn-xs" id="btnNovoAgRec" style="margin-right: 3px">NOVO AGENDAMENTO</button>
                                                    <span> | </span>
                                                    <button type="button" class="btn btn-primary btn-xs" id="btnNewRecAll" style="margin-right: 3px;width: 150px">CRIAR OR</button>
                                                    <span> | </span>
                                                    <label class="input">FORNECEDOR
                                                        <input type="text" class="input-xs" id="nmForn" name="nmForn" style="color: black">
                                                    </label>
                                                    <label class="input">O.R.
                                                        <input type="text" class="input-xs" id="nrOr" name="nrOr" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnConsOrAb" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <button type="button" id="btnConsOrFin" class="btn btn-success btn-xs" style="margin-right: 3px;width: 100px">FINALIZADAS</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="retornoAg"></div>
                                            <div id="retModalAg"></div>
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
                                    <div class="tab-pane fade" id="s4">
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
                                                    <button type="button" class="btn btn-success btn-xs" id="btnNovaJanela" style="margin-right: 3px">JANELA EXTRA</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="retornoJan"></div>
                                            <div id="retModalJan"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s8">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="button" class="btn btn-primary btn-xs" id="btnRepRec" style="margin-right: 3px">AGENDAMENTOS</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="retornoRep"></div>
                                            <div id="retModalRep"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s9">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">PRODUTO
                                                        <input type="text" class="input-xs" id="codPrd" name="codPrd" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnConsSerialPrd" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <label class="input">SERIAL
                                                        <input type="text" class="input-xs" id="nrSerial" name="nrSerial" style="color: black; width: 100px">
                                                    </label>
                                                    <button type="submit" id="btnConsSerial" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <label class="input">FORNECEDOR
                                                        <select class="input-xs" name="nmFornecedor" id="nmFornecedor" style="color: black; width: 100px">
                                                            <?php while ($dados = mysqli_fetch_assoc($res)) { ?>
                                                                <option value="<?= $dados['nm_fornecedor'] ?>"><?= $dados['nm_fornecedor']."-".$dados['id'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </label>
                                                    <button type="submit" id="btnConsForn" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <label class="input">DATA
                                                        <input type="date" class="input-xs" id="dt_inicio" name="dt_inicio" style="color: black">
                                                        <input type="date" class="input-xs" id="dt_fim" name="dt_fim" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnConsData" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <button type="submit" class="btn btn-success btn-xs" id="btnImportSapSeriaisRec" style="float:right;width: 120px">RETORNO SAP</button>
                                                    <span> | </span>
                                                    <button type="button" class="btn btn-primary btn-xs" id="btnExportSapSeriaisRec" style="float:right;width: 120px">EXPORTAR SERIAIS</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="retornoNs"></div>
                                            <div id="retModalNs"></div>
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

        $('#retorno').load('data/recebimento/list_recebimento.php');

        $('#liRecPend').on('click', function() {
            $('#retorno').load('data/recebimento/list_recebimento.php');
        });

        $('#btnConsOrAb').on('click', function() {
            $('#retorno').load('data/recebimento/list_recebimento.php');
        });

        $('#liRecConf').on('click', function() {
            $('#retornoConf').load('data/recebimento/list_recebimento_conf.php');
        });

        $('#liRecEnc').on('click', function() {
            $('#retornoEnc').load('data/recebimento/list_recebimento_enc.php');
        });

        $('#liPrdSer').on('click', function() {
            $('#retornoNs').load('data/produto/list_ns.php');
        });

        $('#btnImportSapSeriaisRec').on('click', function() {
            event.preventDefault();
            $('#retornoNs').load('importa_sap_seriais.php');
        });

        $('#liRecAg').on('click', function() {
            $('#retornoAg').load('data/recebimento/list_recebimento_ag.php');
        });

        $('#liAg').on('click', function() {
            $('#retornoJan').load('data/recebimento/list_agenda.php');
        });

        $('#btnExportSapSeriaisRec').on('click', function() {
            $('#retornoNs').load('data/recebimento/down_seriais.php');
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