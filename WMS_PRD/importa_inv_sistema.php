<div id="main" role="main">
    <div id="ribbon">
        <div class="col-sm-4">
            <ol class="breadcrumb">
                <li>Home</li><li>Movimento</li><li>Importação planilha de inventário</li>
            </ol>
        </div>
    </div>
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row"><br><br>
                <div class="col-sm-12">
                    <article>
                        <form  class="form-inline" action="imp_inv_med" id="ImpInv" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <section>
                                    <div class="col-sm-5">
                                        <p>Selecione os arquivos a importar.</p>
                                        <div class="input-group">
                                            <input class="btn btn-default" name="arquivos[]" type="file" multiple />
                                            <div class="input-group-btn">
                                                <button class="btn btn-default btn-primary" type="submit" style="height: 35px">
                                                    <i class="fa fa-check"></i> Enviar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </fieldset>
                        </form>
                        <div id="retInv"></div>
                    </article>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
   $(document).ready(function(){
    $('#ImpInv').on('submit', function(e){
        event.preventDefault();
        $.ajax
        ({
            url: "imp_inv_med.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            beforeSend:function(j){
                $("#retInv").html("<img src='css/loading9.gif'>");
            },
            success: function(data)
            {
                $("#retInv").html(data);
            }
        });
        return false;
    });
});
</script>