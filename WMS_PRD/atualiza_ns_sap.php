<div class="row"><br><br>
    <div class="col-sm-12">
        <article>
            <form  class="form-inline" action="ins_ns_sap.php" id="UpdSapNs" method="post" enctype="multipart/form-data">
                <fieldset>
                    <section>
                        <div class="col-sm-5">
                            <p>Selecione os arquivos a importar.</p>
                            <div class="input-group">
                                <input class="btn btn-default" name="arquivos[]" type="file" multiple />
                                <input class="form-control" type="hidden" name="id_ns_sap" id="id_ns_sap" value="<?php echo $id_rec;?>">
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
    $('#UpdSapNs').on('submit', function(e){
        event.preventDefault();
        $.ajax
        ({
            url: "upd_ns_sap.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            beforeSend:function(j){
                $("#retNsSap").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
            },
            success: function(data)
            {
                for (var i = 0; i < data.length; i++) {

                    $("#retNsSap").html(data);

                }
            }
        });
        return false;
    });
});
</script>