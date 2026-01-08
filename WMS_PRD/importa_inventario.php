<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:index.php");
  exit;

} else {

  $id = $_SESSION["id"];
  $cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();


?>
<section id="" class="">
    <div class="row"><br><br>
        <div class="col-sm-12">
            <article>
                <form  class="form-inline" action="imp_inv_geral.php" id="ImpInv" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <section>
                            <div class="col-sm-4" style="float: left;">
                                <button class="btn" id="btnProcInvProg">Baixar procedimento&nbsp;<img src="data/inventario/relatorio/modelo/pdf.jpeg"style="width: 50px; height: 50px"></button>
                                <button class="btn" id="btnListInvProg">Gerar lista de inventário&nbsp;<img src="data/inventario/relatorio/modelo/excel-logo.jpg" style="width: 50px; height: 50px"></button>
                            </div>
                        </section>
                        <section>
                            <div class="col-sm-4" style="float: right;">
                                <p>Selecione os arquivos a importar.</p>
                                <div class="input-group">
                                    <input class="btn btn-default" name="arquivos[]" type="file" multiple />
                                    <div class="input-group-btn">
                                        <button class="btn btn-default btn-primary" type="submit" style="height: 35px">
                                            <i class="fa fa-check"></i> Enviar
                                        </button>
                                    </div>
                                </div>
                                <p><h6 style="width: 400px">O arquivo excel deve ser salvo em formato texto separado por tabulação. Deve ser usado o modelo enviado para que a carga seja realizada corretamente.</h6></p>
                                <select class="form-control" name="id_inv_prg" id="id_inv_prg">
                                  <option value="">Selecione o inventário</option>
                                  <?php

                                  $local="select id, 
                                  dt_inicio, 
                                  dt_fim, 
                                  concat(id_galpao,'-',id_rua_inicio,'-',id_coluna_inicio,'-',id_altura_inicio) as end_inicio,
                                  concat(id_galpao,'-',id_rua_fim,'-',id_coluna_fim,'-',id_altura_fim) as end_fim,
                                  id_grupo,
                                  id_sub_grupo,
                                  id_produto
                                  from tb_inv_prog where fl_status = 'P' and fl_empresa = '$cod_cli'";
                                  $res_local = mysqli_query($link, $local);
                                  while ($dados_local=mysqli_fetch_assoc($res_local)) {?>
                                    <option value="<?php echo $dados_local['id']; ?>"><?php echo $dados_local['id'].'|'.$dados_local['dt_inicio'].'-'.$dados_local['dt_fim'].'|'.$dados_local['end_inicio'].'|'.$dados_local['end_fim']; ?></option>
                                <?php } $link->close();?>
                            </select>
                        </div>
                    </section>
                </fieldset>
            </form>
            <div id="retInv" style="text-align: center;"></div>
        </article>
        <article>
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

        var id_inv = $('#id_inv_prg').find(":selected").val();

        if(id_inv.length == 0){

            alert("Selecione o inventário!");

        }else{

            $.ajax
            ({
                url: "imp_inv_geral.php",
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

        }
        return false;
    });

    $('#btnListInvProg').on('click',function(){
        event.preventDefault();
        $("#info").html("<img src='css/loading9.gif' style='left:50%;top:50%;position: relative;margin-left:-40px;margin-top:-40px'>");
        $('#info').load("data/inventario/relatorio/list_inv_geral.php");
        return false;
    });
    $('#btnProcInvProg').on('click',function(){
        event.preventDefault();
        var proc_inv = "data/inventario/relatorio/procedimento.pdf";
        window.open(proc_inv, "_blank");
        return false;
    });
});
</script>