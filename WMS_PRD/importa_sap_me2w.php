<div id="main" role="main">
    <div id="ribbon">
        <div class="col-sm-4">
            <ol class="breadcrumb">
                <li>Home</li><li>Movimento</li><li>Importação de pedidos SAP - Serializados</li>
            </ol>
        </div>
    </div>
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row"><br><br>
                <div class="col-sm-12">
                    <article>
                        <form  class="form-inline" action="ins_mb_sap_expede_me2w.php" id="PedSapSerial" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <section class="col-sm-4">
                                    <p>Data de entrega</p>
                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <input type="date" class="form-control" id="dt_entrega" name="dt_entrega">
                                            <div class="form-control-focus"> </div>
                                        </div>
                                    </div>
                                </section>
                                <section class="col-sm-4">
                                    <p>Almox</p>
                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="cod_almox" name="cod_almox">
                                            <div class="form-control-focus"> </div>
                                        </div>
                                    </div>
                                </section>
                                <section class="col-sm-4">
                                    <p>Selecione os arquivos a importar.</p>
                                    <div class="input-group">
                                        <input class="btn btn-default" name="arquivos[]" type="file" multiple />
                                        <div class="input-group-btn">
                                            <button class="btn btn-default btn-primary" type="submit" style="height: 35px">
                                                <i class="fa fa-check"></i> GERAR PEDIDOS
                                            </button>
                                        </div>
                                    </div>
                                </section>
                            </fieldset>
                        </form>
                        <div id="retSapSerial"></div>
                    </article>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
   $(document).ready(function(){
    $('#PedSapSerial').on('submit', function(e){
        event.preventDefault();
        $.ajax
        ({
            url: "ins_mb_sap_expede_me2w.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            beforeSend:function(j){
                $("#retSap").html("<img src='css/loading9.gif'>");
            },
            success: function(data)
            {
                $("#retSapSerial").html(data);
            }
        });
        return false;
    });
});
</script>