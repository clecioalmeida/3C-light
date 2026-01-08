<div class="row"><br><br>
    <div class="col-sm-12">
        <article>
            <form  class="form-inline" action="ins_ns_sap.php" id="testeSapNs" method="post" enctype="multipart/form-data">
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
            <div id="retNsSap"></div>
        </article>
    </div>
</div>
<script>
   $(document).ready(function(){
    $('#testeSapNs').on('submit', function(e){
        event.preventDefault();
        $.ajax
        ({
            url: "ins_ns_sap.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            beforeSend:function(j){
                $("#retSap").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
            },
            success: function(data)
            {
                $("#retNsSap").html(data);
            }
        });
        return false;
    });
});
</script>