<div id="main" role="main">
    <div id="ribbon">
        <div class="col-sm-4">
            <ol class="breadcrumb">
                <li>Home</li><li>Movimento</li><li>Importação de pedidos SAP - CONTINGÊNCIA</li>
            </ol>
        </div>
    </div>
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row"><br><br>
                <div class="col-sm-12">
                    <article>
                        <form  class="form-inline" action="ins_mb_sap_expede.php" id="PedSapCon" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <section>
                                    <div class="col-sm-5">
                                        <p>Selecione os arquivos a importar.</p>
                                        <div class="input-group">
                                            <input class="btn btn-default" name="arquivos[]" type="file" multiple />
                                            <div class="input-group-btn">
                                                <button class="btn btn-default btn-primary" type="submit" style="height: 35px">
                                                    <i class="fa fa-check"></i> ENVIAR
                                                </button>
                                            </div>
                                            <button class="btn btn-default btn-success" id="btnGeraPedSapCon" type="button" style="height: 35px"> GERAR PEDIDOS
                                            </button>
                                        </div>
                                    </div>
                                </section>
                            </fieldset>
                        </form>
                        <div id="retSap"></div>
                    </article>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
 $(document).ready(function(){
    $('#PedSapCon').on('submit', function(e){
        event.preventDefault();
        $.ajax
        ({
            url: "ins_mb_sap_expede_con.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            beforeSend:function(j){
                $("#retSap").html("<img src='css/loading9.gif'>");
            },
            success: function(data)
            {
                $("#retSap").html(data);
            }
        });
        return false;
    });
});
</script>