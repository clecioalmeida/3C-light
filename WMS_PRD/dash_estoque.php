<?php 
require_once('data/inventario/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$link->close();
?>
<div id="main" role="main">
    <div id="ribbon">
        <div class="col-sm-4">
            <ol class="breadcrumb">
            <li>Home</li><li>Dashboard</li><li>Estoque</li>
            </ol>
        </div>
    </div>
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
                        <div>
                            <div class="widget-body">
                                <hr class="simple">
                                <ul id="myTab1" class="nav nav-tabs bordered">
                                    <li class="active">
                                        <a href="#s6" id="btnOcorPend" data-toggle="tab">VALOR DO ESTQOUE <span class="badge bg-color-blue txt-color-white"></span></a>
                                    </li>
                                    <li>
                                        <a href="#s1" id="liOcupaEst" data-toggle="tab">OCUPAÇÃO DO ESTOQUE </a>
                                    </li>
                                    <li>
                                        <a href="#s2" id="liPrdEst" data-toggle="tab">ARMAZENAGEM POR SKU</a>
                                    </li>
                                </ul>
                                <div id="myTabContent1" class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="s6">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="formDashVlrCod">
                                                    <label class="input">CONSULTAR CÓDIGO
                                                        <input type="text" class="input-xs" id="codigo" name="codigo" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnDashVlrCod" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                    <span> | </span>
                                                </form>
                                            </div>
                                        </article>
                                        <article id="loading"><br>
                                            <div id="info_dash_vlr"></div>
                                            <div id="retornoConsultaVlr"></div>
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
                                            <div id="info_dash_Ocup"></div>
                                            <div id="retModal"></div>
                                        </article>
                                    </div>
                                    <div class="tab-pane fade" id="s2">
                                        <article>
                                            <div>
                                                <form class="form-horizontal" method="post" action="" id="">
                                                    <label class="input">PRODUTO
                                                        <input type="text" class="input-xs" id="nmForn" name="nmForn" style="color: black">
                                                    </label>
                                                    <button type="submit" id="btnConsOrConf" class="btn btn-primary btn-xs" style="margin-right: 3px;width: 100px">CONSULTAR</button>
                                                </form>
                                            </div>
                                        </article>
                                        <article>
                                            <div id="retornoConf"></div>
                                            <div id="info_dash_Sku"></div>
                                            <div id="retModal"></div>
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
    $(document).ready(function(){

        $('#info_dash_vlr').load('data/dashboard/dash_valor_estoque.php');

        $( '#liOcupaEst').on('click', function(){
            $('#info_dash_Ocup').load('data/dashboard/dash_ocupa_estoque.php');
        });

        $( '#liPrdEst').on('click', function(){
            $('#info_dash_Sku').load('data/dashboard/dash_sku_estoque.php');
        });
    });
</script>