<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_galpao = mysqli_real_escape_string($link, $_POST["upd_galpao"]);

$SQL = "select * from tb_galpao where fl_status = 1 and cod_galpao = '$id_galpao'"; 
$res = mysqli_query($link,$SQL); 
$tr = mysqli_num_rows($res);

while ($dados = mysqli_fetch_array($res)) {
   $galpao=$dados['galpao'];
   $cod_galpao=$dados['cod_galpao'];
   $ds_apelido=$dados['ds_apelido'];
   $g_cidade=$dados['g_cidade'];
   $g_uf=$dados['g_uf'];
}  
                           
$link->close();
?>
<div class="modal fade" id="alterar_galpao" aria-hidden="true">
    <form method="post" action="" role="form" class="form-horizontal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" id="novo_galpao" style="color: white">Alterar Galpão</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="galpao_nome">Nome</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="<?php echo $galpao; ?>" name="galpao" id="galpao_nome" placeholder="Nome">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-md-2 control-label" for="galpao_apelido">Código</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="<?php echo $cod_galpao; ?>" id="galpao_apelido" name="cod_galpao" placeholder="Código" readonly="true">
                                <div class="form-control-focus"> </div>
                             </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="galpao_nome">Apelido</label>
                                <div class="col-md-4">
                                <input type="text" class="form-control" value="<?php echo $ds_apelido; ?>" name="ds_apelido" id="ds_apelido" placeholder="Apelido">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="galpao_cidade">Cidade</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="<?php echo $g_cidade; ?>" name="g_cidade" id="galpao_cidade" placeholder="Cidade">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-md-2 control-label" for="galpao_uf">U.F.</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="<?php echo $g_uf; ?>" name="g_uf" id="galpao_uf" placeholder="U.F.">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer" style="background-color: #2F4F4F;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <span aria-hidden="true"></span>Fechar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                        Salvar</button>
                </div>
            </div>
        </div>
    </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#alterar_galpao').modal('show');
    });
</script>