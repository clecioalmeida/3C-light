<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

    header("Location:index.php");
    exit;

}else{

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php 

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_cat = "select * from tb_cat_prd where fl_empresa = '$cod_cli'";
$res_cat = mysqli_query($link,$sql_cat);

$link->close();
?>
<div id="main" role="main">
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row"><br><br>
                <div class="col-sm-12">
                    <article>
                        <form  class="form-inline" action="" id="PedSap" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <section class="col-sm-3">
                                    <div class="form-group">
                                        <p>Data de entrega</p>
                                        <div class="col-sm-2">
                                            <input type="date" class="form-control" id="dt_entrega" name="dt_entrega">
                                            <div class="form-control-focus"> </div>
                                        </div>
                                    </div>
                                </section>
                                <section class="col-sm-5">
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
                        <div id="retSap"></div>
                    </article>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
 $(document).ready(function(){
    $('#PedSap').on('submit', function(e){
        event.preventDefault();
        $.ajax
        ({
            url: "ins_mb_sap_seriais.php",
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