<div id="content">
    <section id="widget-grid" class="">
        <div class="row"><br><br>
            <article>
                <form  class="form-inline" action="ins_mb_sap_expede.php" id="PedComp" method="post" enctype="multipart/form-data">
                    <fieldset class="col-sm-12">
                        <section class="col-sm-6">
                            <p>Código SAP</p>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="cod_prod_comp" name="cod_prod_comp">
                                    <div class="form-control-focus"> </div>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nm_prod_comp" name="nm_prod_comp" disabled>
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </section>
                        <section class="col-sm-6">
                            <p>Selecione os arquivos a importar.</p>
                            <div class="input-group">
                                <input class="btn btn-default" name="arquivos[]" type="file" multiple />
                                <div class="input-group-btn">
                                    <button class="btn btn-default btn-primary" type="submit" style="height: 35px">
                                        <i class="fa fa-check"></i> ENVIAR
                                    </button>
                                </div>
                            </div>
                        </section>
                    </fieldset>
                </form>
                <div id="retComp"></div>
            </article>
        </div>
    </section>
</div>