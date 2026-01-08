<div id="main" role="main">
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12">
                    <div>
                        <div>
                            <div class="widget-body">
                                <hr class="simple">
                                <ul id="myTab1" class="nav nav-tabs bordered">
                                    <li class="active">
                                        <a href="#s6" id="liIndRec" data-toggle="tab">RECEBIMENTO <span class="badge bg-color-blue txt-color-white"></span></a>
                                    </li>
                                    <li>
                                        <a href="#s1" id="liIndAt" data-toggle="tab">ATENDIMENTO </a>
                                    </li>
                                    <li>
                                        <a href="#s9" id="liIndTrp" data-toggle="tab">TRANSPORTE </a>
                                    </li>
                                    <li>
                                        <a href="#s3" id="liIndInv" data-toggle="tab">INVENTÁRIOS</a>
                                    </li>
                                    <li>
                                        <a href="#s2" id="liIndPrd" data-toggle="tab">PRODUÇÃO</a>
                                    </li>
                                    <li>
                                        <a href="#s4" id="liIndSeg" data-toggle="tab">SEGURANÇA</a>
                                    </li>
                                    <li>
                                        <a href="#s8" id="liIndQld" data-toggle="tab">QUALIDADE</a>
                                    </li>
                                    <li>
                                        <a href="#s5" id="liIndSeg" data-toggle="tab">OUTROS</a>
                                    </li>
                                    <li>
                                        <a href="#s7" id="liIndFec" data-toggle="tab">FECHAMENTO</a>
                                    </li>
                                </ul>
                                <div id="myTabContent1" class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="s6">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="buttom" id="CadPrcNfSap" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #D96123;color: white">RECEBIMENTO CL</button>
                                                    <button type="buttom" id="CadDemRecSap" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #D96123;color: white">RECEBIMENTO CSD's</button>
                                                    <button type="buttom" id="CadConsNfSku" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">NF E SKU RECEBIDOS</button>
                                                    <button type="buttom" id="CadConsAgFor" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">AGENDA FORNECEDOR</button>
                                                    <button type="buttom" id="CadConsAgEx" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">NÃO AGENDADOS</button>
                                                    <button type="buttom" id="btnConsPedParc" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">$ RECEBIDOS X EXPEDIDOS</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="retornoPrcNF"></div>
                                            <div id="retModalPrcNf"></div>
                                            <div id="retModalUpdRec"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s1">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="buttom" id="dashQtdIten" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">ATENDIMENTOS DE PEDIDOS</button>
                                                    <button type="buttom" id="dashPedEmerg" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">PEDIDOS EMERGENCIAIS</button>
                                                    <button type="buttom" id="dashTempoMedio" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">TEMPO MÉDIO DE EXPEDIÇÃO</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retTempoMedio"></div>
                                            <div id="retCronEnt"></div>
                                            <div id="retModalCron"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s9">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="buttom" id="dashCronEnt" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #D96123;color: white">CRONOGRAMA DE ENTREGAS</button>
                                                    <button type="buttom" id="dashVeicNr" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">VEÍCULOS</button>
                                                    <button type="buttom" id="dashTran" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">TRÂNSITO</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retransporte"></div>
                                            <div id="retCronEnt"></div>
                                            <div id="retModalTransp"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s3">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="buttom" id="dashInvDep" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #D96123;color: white">ESTOQUE DEPÓSITOS</button>
                                                    <button type="buttom" id="dashInvCl" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #D96123;color: white">ESTOQUE CL</button>
                                                    <!--button type="buttom" id="dashInvAc" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">ACURACIDADE DE INVENTÁRIO</button-->
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retInvDep"></div>
                                            <div id="retRomaneioExp"></div>
                                            <div id="retModalInv"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s2">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="buttom" id="dashOcupInt" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">OCUPAÇÃO INTERNA</button>
                                                    <button type="buttom" id="dashOcupExt" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">OCUPAÇÃO EXTERNA</button>
                                                    <button type="buttom" id="dashVlrEst" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">VALOR DO ESTOQUE</button>
                                                    <button type="buttom" id="dashGiroEst" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">GIRO DE ESTOQUE</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retDashOcupa"></div>
                                            <div id="retRomaneioEnd"></div>
                                            <div id="retModalOcpInt"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s4">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="buttom" id="dashSeg" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #D96123;color: white">SEGURANÇA</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>                                            
                                            <div id="retorno_seg">
                                                <div id="loading" style="display: none">
                                                    <img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>
                                                </div>
                                            </div>
                                            <div id="retModalSeg"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s8">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="buttom" id="dashQld" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">QUALIDADE</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>                                            
                                            <div id="retorno_qld">
                                                <div id="loading" style="display: none">
                                                    <img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>
                                                </div>
                                            </div>
                                            <div id="retModalSQld"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s5">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="buttom" id="dashAvMat" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #D96123;color: white">AVARIA DE MATERIAIS</button>
                                                    <button type="buttom" id="dashLogRev" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #D96123;color: white">LOGÍSTICA REVERSA</button>
                                                    <button type="buttom" id="dashSucata" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #D96123;color: white">VENDA DE SUCATAS</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>                                            
                                            <div id="retorno_outros"></div>                                            
                                            <div id="modalOutros"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s7">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <button type="buttom" id="dashImpMb52" class="btn btn-xs" style="margin-right: 3px;width: 200px;background-color: #009933;color: white">IMPORTAR MB52</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>                                            
                                            <div id="retorno_fec"></div>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </div>
</div>
<script src="js/indicadores.js"></script>