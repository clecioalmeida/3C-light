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
                                        <a href="#s6" id="liConsEsPr" data-toggle="tab">ESTOQUE POR PRODUTO <span class="badge bg-color-blue txt-color-white"></span></a>
                                    </li>
                                    <!--li>
                                        <a href="#s1" id="liConsEsEn" data-toggle="tab">ESTOQUE POR ENDEREÇO </a>
                                    </li>
                                    <li>
                                        <a href="#s2" id="liConsEsGr" data-toggle="tab">ESTOQUE POR GRUPO</a>
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
                                                    <label class="input">CÓDIGO SAP
                                                        <input type="text" class="input-xs" id="cod_sap" name="cod_sap" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnConsPrdAloc" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div id="retornoPrdAloc"></div>
                                            <div id="retModalAg"></div>
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
                                    </div-->
                                    <!--div class="tab-pane fade" id="s3">
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
                                </div>
                            </div-->
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

        //$('#retorno').load('data/recebimento/list_recebimento.php');

        $(document).on('click', '#btnConsPrdAloc',function(){
            event.preventDefault();
            var cod_sap = $('#cod_sap').val();
            $('#retornoPrdAloc').load('data/movimento/list_prd_alocado.php?search=',{cod_sap:cod_sap});
        });

        /*$( '#liConsEsEn').on('click', function(){
            $('#retorno').load('data/recebimento/list_recebimento.php');
        });

        $( '#liConsEsGr').on('click', function(){
            $('#retornoConf').load('data/recebimento/list_recebimento_conf.php');
        });*/

        /*$( '#liRecEnc').on('click', function(){
            $('#retornoEnc').load('data/recebimento/list_recebimento_enc.php');
        });

        $( '#liRecAg').on('click', function(){
            $('#retornoAg').load('data/recebimento/list_recebimento_ag.php');
        });

        $( '#liAg').on('click', function(){
            $('#retornoJan').load('data/recebimento/list_agenda.php');
        });*/
    });
</script>