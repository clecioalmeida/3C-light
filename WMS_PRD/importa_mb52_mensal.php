<div id="main" role="main">
    <div class="col-sm-12">
        <article>
            <form  class="form-inline" action="" id="impMb52" method="post" enctype="multipart/form-data">
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
            <div id="retMb52"></div>
        </article>
    </div>
</div>
<script>
 $(document).ready(function(){
    $('#impMb52').on('submit', function(e){
        event.preventDefault();
        $.ajax
        ({
            url: "imp_mb52_mensal.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            beforeSend:function(j){
                $("#retMb52").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
            },
            success: function(data)
            {
                $("#retMb52").html(data);
            }
        });
        return false;
    });
});
</script>