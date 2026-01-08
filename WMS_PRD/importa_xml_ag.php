<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rec = mysqli_real_escape_string($link, $_POST["id_rec"]);

$SQL = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'C'";
$res_inv = mysqli_query($link, $SQL);

$link->close();
?>
<div class="row"><br><br>
    <div class="col-sm-12">
        <article>
            <form  class="form-inline" action="ins_xml_nf.php" id="testeXml" method="post" enctype="multipart/form-data">
                <fieldset>
                    <section>
                        <div class="col-sm-5">
                            <p>Selecione os arquivos a importar.</p>
                            <div class="input-group">
                                <input class="btn btn-default" name="arquivos[]" type="file" multiple />
                                <input class="form-control" type="hidden" name="id_rec" id="id_rec" value="<?php echo $id_rec;?>">
                                <div class="input-group-btn">
                                    <button class="btn btn-default btn-primary" type="submit" style="height: 35px">
                                        <i class="fa fa-check"></i> Enviar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="col-sm-5">
                            <p>Importar pela chave NF-e</p>
                            <div class="input-group">
                                <input class="form-control" type="text" name="chave_nfe" id="chave_nfe" style="width: 350px">
                                <div class="input-group-btn">
                                    <button class="btn btn-default btn-primary" type="button" id="btnXmlNfe" style="height: 32px">
                                        <i class="fa fa-check"></i> Enviar
                                    </button>
                                    <button class="btn btn-default btn-danger" type="button" id="btnClearChave" style="height: 32px">
                                        <i class="fa fa-close"></i> Limpar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </fieldset>
            </form>
            <div id="retXml"></div>
        </article>
    </div>
</div>
<script>
   $(document).ready(function(){
    $('#testeXml').on('submit', function(e){
        event.preventDefault();
        $.ajax
        ({
            url: "ins_xml_nf.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            beforeSend:function(j){
                $("#retXml").html("<img src='css/loading9.gif'>");
            },
            success: function(data)
            {
                $("#retXml").html(data);
            }
        });
        return false;
    });

    $('#btnClearChave').on('click',function(){
        $('#chave_nfe').val('');
    });
});
</script>