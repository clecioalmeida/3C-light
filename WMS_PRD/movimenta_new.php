<?php
require_once 'data/movimento/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_galpao = "select * from tb_armazem";
$galpao = mysqli_query($link, $sql_galpao);
$tr = mysqli_num_rows($galpao);

$sql_rua = "select distinct ds_prateleira from tb_posicao_pallet";
$rua = mysqli_query($link, $sql_rua);

$link->close();
?>
<div id="main" role="main">
    <div id="ribbon">
        <div class="col-sm-4">
            <ol class="breadcrumb">
                <li>Home</li><li>Movimentação</li><li>movimentação de produtos</li>
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
                                        <a href="#s6" id="liTransEnd" data-toggle="tab">MOVIMENTAÇÃO <span class="badge bg-color-blue txt-color-white"></span></a>
                                    </li>
                                    <!--li>
                                        <a href="#s1" id="liRecPend" data-toggle="tab">OR ABERTA </a>
                                    </li>
                                    <li>
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
                                                <form method="POST" class="form-inline" id="formMovPrd" action=""><br><br>
                                                    <fieldset>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <input type="text" id="cod_movimenta" name="cod_movimenta" class="form-control" aria-describedby="basic-addon2" placeholder="Digite o código SAP do produto">
                                                                <input type="text" id="nm_movimenta" name="nm_movimenta" class="form-control" aria-describedby="basic-addon2" placeholder="Digite a descrição do produto">
                                                                <select class="form-control" id="local" name="local">
                                                                    <option>Selecione o local</option>
                                                                    <?php
                                                                    while ($linha = mysqli_fetch_assoc($galpao)) {?>
                                                                        <option value="<?php echo $linha['id']; ?>"><?php echo $linha['nome']; ?></option>
                                                                    <?php }?>
                                                                </select>
                                                                <input type="submit" class="btn-info form-control" id="btnFormMovPrd" value="Pesquisar">
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="info_produtos"></div>
                                            <div id="retModalInfo"></div>
                                        </article>
                                    </div>
                                    <!--div class="tab-pane fade" id="s1">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="button" class="btn btn-info btn-xs" id="btnNovoRec" style="margin-right: 3px;width: 100px">NOVA OR</button>
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
                                                    <input type="text" class="input-xs" id="nmForn" name="nmForn" style="color: black">
                                                </label>
                                                <label class="input">PRODUTO
                                                    <input type="text" class="input-xs" id="cod_produto" name="nrOr" style="color: black">
                                                </label>
                                                <button type="submit" id="btnConsPrdOr" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>

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

        $( '#liTransEnd').on('click', function(){
            $('#info_produtos').load('data/movimento/mov_list_sql.php');
        });

        $( '#btnConsOrAb').on('click', function(){
            $('#retorno').load('data/recebimento/list_recebimento.php');
        });

        $( '#liRecConf').on('click', function(){
            $('#retornoConf').load('data/recebimento/list_recebimento_conf.php');
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