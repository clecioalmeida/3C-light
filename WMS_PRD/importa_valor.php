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
<html>
        <head>
               <title></title>
               <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        </head>
<body>
<div id="main" role="main">
    <div id="ribbon">
        <ol class="breadcrumb">
            <li>Home</li><li>Integração</li><li>Importação de valores médios</li>
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
                                            <form  class="form-inline" action="" id="at_entradas" method="post" enctype="multipart/form-data">
                                                <article>
                                                    <div class="form form-inline">
                                                        <p>ENTRADAS - Selecione os arquivos a importar.</p>
                                                        <div class="input-group">
                                                            <input class="btn btn-default" name="arquivos[]" type="file"/>
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-default btn-primary" type="submit" style="height: 35px">
                                                                    <i class="fa fa-check"></i> Enviar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="retImportRepom"></div>
                                                    <div id="retPedidoSAP"></div>
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
                <article class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="jarviswidget" id="wid-id-0">
                        <div>
                            <div class="widget-body">
                                <section id="widget-grid" class="">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!--article>
                                                <h3>Úlitmos arquivos importados</h3>
                                                <hr>
                                                <?php
                                                while ($dados=mysqli_fetch_assoc($res_log)) {?>
                                                    <p><strong>Arquivo: <?php echo $dados['ds_arquivo'];?></strong> - Data:  <?php echo $dados['dt_import'];?> - Pedido gerado:  <?php echo $dados['nr_pedido'];?> </p>
                                                <?php }?>
                                            </article-->
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
</body>
</html>
<script>
   $(document).ready(function(){
    $('#at_entradas').on('submit', function(e){
        event.preventDefault();
        $.ajax
        ({
            url: "ins_vlr_estoque.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            processData:false,
            beforeSend:function(j){
                $('.aguarde').show();
            },
            success: function(data)
            {
                $('.aguarde').hide();
                $("#retImportRepom").html(data);
            }
        });
        return false;
    });
});
</script>