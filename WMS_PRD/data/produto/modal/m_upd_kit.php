<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_kit = mysqli_real_escape_string($link, $_POST["upd_kit"]);

$SQL = "select * from tb_kit where id = '$id_kit'";

$res_kit = mysqli_query($link,$SQL); 

while ($dados = mysqli_fetch_assoc($res_kit)) {
    $descricao=$dados['descricao'];
    $id=$dados['id'];
    $cod_cliente=$dados['cod_cliente'];
    $alerta_rep=$dados['alerta_rep'];
    $ean=$dados['ean'];
    $detalhe_kit=$dados['detalhe_kit'];
    $estoque_minimo=$dados['estoque_minimo'];
}

$link->close();
?>
<div class="modal fade" id="alterar_kit" aria-hidden="true">
                 <form method="post" action="" id="formUpdKit">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header" style="background-color: #2F4F4F;">
                        <h5 class="modal-title" id="novo_produto" style="color: white">Alterar kit</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="overflow-y: auto">
                     <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="id">Kit</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $dados['id']; ?>" id="id" placeholder="Código" readonly="true">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-sm-2 control-label" for="descricao">Descrição</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="descricao" value="<?php echo $dados['descricao']; ?>" name="descricao" placeholder="Descrição">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="ean">Ean</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="ean" value="<?php echo $dados['ean']; ?>" name="ean" placeholder="Ean">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-md-2 control-label" for="controle_lote">Controle de lote</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="<?php 
                                                                                    if ($dados['controle_lote'] == '1') {
                                                                                        echo 'Sim';
                                                                                    }else{
                                                                                        echo 'Não';
                                                                                    }
                                     ?>" name="controle_lote" id="controle_lote" placeholder="Controle de lote" readonly="true">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </fieldset> 
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="estoque_minimo">Estoque mínimo</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="estoque_minimo" value="<?php echo $dados['estoque_minimo']; ?>" name="estoque_minimo" placeholder="Estoque minimo">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-sm-2 control-label" for="detalhe_kit">Detalhes</label>
                            <div class="col-sm-4 form-md">
                                <input type="text" class="form-control" id="detalhe_kit" value="<?php echo $dados['detalhe_kit']; ?>" name="detalhe_kit" placeholder="Detalhes">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="volume_padrao">Volume padrão</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="volume_padrao" value="<?php echo $dados['volume_padrao']; ?>" name="volume_padrao" placeholder="Volume padrão">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-sm-2 control-label" for="cod_identificacao">Alerta de reposição?</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="alerta_rep" value="<?php 
                                                                                    if ($dados['alerta_rep'] == '1') {
                                                                                        echo 'Sim';
                                                                                    }else{
                                                                                        echo 'Não';
                                                                                    } ?>"
                                         placeholder="Alerta de reposição" readonly="true">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Grupo</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="nm_grupo" value="" placeholder="Grupo" readonly="true">
                              <div class="form-control-focus"> </div>
                          </div>
                          <label class="col-sm-2 control-label">Sub-grupo</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control" id="nm_sub_grupo" value="" placeholder="Sub-grupo" readonly="true">
                          <div class="form-control-focus"> </div>
                      </div>
                  </div>
              </fieldset>
              <fieldset>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="cod_identificacao">Identificação</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="cod_identificacao" value="<?php echo $dados['cod_identificacao']; ?>" name="cod_identificacao" placeholder="Identificação">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label">Local preferencial</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="local_preferencial" value="" placeholder="Local preferencial" readonly="true">
                  <div class="form-control-focus"> </div>
              </div>
          </div>
          </fieldset>
      </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
          <button type="submit" class="btn blue" id="btnFormUpdKit">Salvar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
  </div>
</div>
</form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#alterar_kit').modal('show');
    });
</script>