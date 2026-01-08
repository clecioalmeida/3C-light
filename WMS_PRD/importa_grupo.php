<?php
require_once 'bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_log = "SELECT nr_pedido, dt_import, ds_msg, ds_arquivo 
FROM tb_log_imp_sap
group by nr_pedido
order by nr_pedido desc
LIMIT 0 , 10";
$res_log = mysqli_query($link, $sql_log);
?>
<div id="main" role="main">
    <div id="ribbon">
        <ol class="breadcrumb">
            <li>Home</li><li>Integração</li><li>Importação de produtos</li>
        </ol>
    </div>
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <div class="jarviswidget" id="wid-id-0">
                        <div>
                            <div class="widget-body">
                                <section id="widget-grid" class="">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form  class="form-inline" action="ins_grupo.php" id="formImpGrp" method="post" enctype="multipart/form-data">
                                                <article>
                                                    <div class="form form-inline">
                                                        <p>Selecione os arquivos a importar.</p>
                                                        <div class="input-group">
                                                            <input class="btn btn-default" name="arquivos[]" type="file"/>
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-default btn-primary" type="submit" style="height: 35px">
                                                                    <i class="fa fa-check"></i> Enviar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="retImportGrp"></div>
                                                    <div class="aguarde" style="display: none">
                                                        <h1>
                                                            Aguarde...
                                                        </h1>
                                                    </div>
                                                </article>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </div>
</div>