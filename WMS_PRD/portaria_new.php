<div id="main" role="main">
    <div id="ribbon">
        <div class="col-sm-4">
            <ol class="breadcrumb">
            <li>Home</li><li>Portaria</li><li>Registros</li>
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
                                        <a href="#s6" id="liRegPr" data-toggle="tab">REGISTROS <span class="badge bg-color-blue txt-color-white"></span></a>
                                    </li>
                                    <li>
                                        <a href="#s1" id="liRegAg" data-toggle="tab">AGENDAMENTOS </a>
                                    </li>
                                    <!--li>
                                        <a href="#s2" id="liRecConf" data-toggle="tab">OR EM CONFERÊNCIA</a>
                                    </li>
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
                                        <a href="#s7" id="liAg" data-toggle="tab">JANELAS</a>
                                    </li-->
                                </ul>
                                <div id="myTabContent1" class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="s6">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="button" class="btn btn-success btn-xs" id="insRegPtr" style="margin-right: 3px">NOVO REGISTRO</button>
                                                    <button type="button" class="btn btn-success btn-xs" id="btnPesqPrt" style="margin-right: 3px">ATUALIZAR</button>
                                                    <button type="button" class="btn btn-success btn-xs" id="consDoca" style="margin-right: 3px">DOCAS</button>
                                                    <span> | </span>
                                                    <label class="input">VEÍCULO
                                                        <input type="text" class="input-xs" id="nr_veiculo" name="nr_veiculo" style="color: black">
                                                    </label>
                                                    <label class="input">CONSULTA POR NOME
                                                        <input type="text" class="input-xs" id="nm_registro" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnPesqNmPort" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="info_produtos"></div>
                                            <div id="retornoReg"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s1">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
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
                                            <div id="retornoAg"></div>
                                            <div id="retRomaneio"></div>
                                            <div id="retModal"></div>
                                        </article>
                                    </div>
                                    <!--div class="tab-pane fade" id="s2">
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

        $('#info_produtos').load('data/portaria/list_portaria.php');

        $( '#liRegPr').on('click', function(){
            $('#info_produtos').load('data/portaria/list_portaria.php');
        });

        $( '#liRegAg').on('click', function(){
            $('#retornoAg').load('data/portaria/list_recebimento_pt.php');
        });
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