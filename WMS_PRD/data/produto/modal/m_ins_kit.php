<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_local = "select * from tb_armazem";
$select_local = mysqli_query($link, $sql_local);

$sql_grupo = "select * from tb_grupo";
$select_grupo = mysqli_query($link, $sql_grupo);

$sql_sub_grupo = "select * from tb_sub_grupo";
$select_sub_grupo = mysqli_query($link, $sql_sub_grupo);

$link->close();
?>
<div class="modal fade" id="novo_kit" aria-hidden="true">
 <form method="post" action="" id="formNovoKit">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" id="novo_produto" style="color: white">Incluir kit</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body" style="overflow-y: auto">
        <fieldset>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="produto">Kit</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="produto" placeholder="Código" readonly="true">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="cod_cliente">Código do cliente</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="cod_cliente" name="cod_cliente" placeholder="Código do cliente">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="descricao">Descrição</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="ean">Ean</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="ean" name="ean" placeholder="Ean">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <div class="form-group">
                <label class="col-md-2 control-label" for="controle_lote">Controle de lote</label>
                <div class="col-md-4">
                    <input type="checkbox" value="1" id="controle_lote" name="controle_lote">Sim
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2 control-label" for="estoque_minimo">Estoque minimo</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="estoque_minimo" name="estoque_minimo" placeholder="Estoque minimo">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="detalhe_kit">Detalhes</label>
                <div class="col-sm-4 form-md">
                    <input type="text" class="form-control" id="detalhe_kit" name="detalhe_kit" placeholder="Detalhes">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="volume_padrao">Volume padrão</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="volume_padrao" name="volume_padrao" placeholder="Volume padrão">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <div class="form-group">
                <label class="col-sm-2 control-label">Grupo</label>
                <div class="col-sm-4">
                    <select class="form-control" name="cod_grupo">
                      <option>Selecione</option>
                      <?php
while ($row_select_grupo = mysqli_fetch_assoc($select_grupo)) {?>
                      <option value="<?php echo $row_select_grupo['cod_grupo']; ?>">
                          <?php echo $row_select_grupo['nm_grupo']; ?>
                      </option> <?php }?>
                  </select>
                  <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label">Sub-grupo</label>
                <div class="col-sm-4">
                    <select class="form-control" name="cod_sub_grupo">
                      <option>Selecione</option>
                      <?php
while ($row_select_subgrupo = mysqli_fetch_assoc($select_subgrupo)) {?>
                      <option value="<?php echo $row_select_subgrupo['cod_sub_grupo']; ?>">
                          <?php echo $row_select_subgrupo['nm_sub_grupo']; ?>
                      </option> <?php }?>
                  </select>
                    <div class="form-control-focus"> </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="cod_identificacao">Identificação</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="cod_identificacao" name="cod_identificacao" placeholder="Identificação">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="cod_identificacao">Alerta de reposição?</label>
                <div class="col-sm-4">
                    <input type="checkbox" aria-label="alerta_rep" value="1" name="alerta_rep">Sim
                    <div class="form-control-focus"> </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <div class="form-group">
                <label class="col-sm-2 control-label">Local preferencial</label>
                <div class="col-sm-4">
                    <select class="form-control" name="local_preferencial">
                      <option>Selecione</option>
                      <?php
while ($row_select_local = mysqli_fetch_assoc($select_local)) {?>
                      <option value="<?php echo $row_select_local['id']; ?>">
                          <?php echo $row_select_local['nome']; ?>
                      </option> <?php }?>
                  </select>
                    <div class="form-control-focus"> </div>
                </div>
            </div>
        </fieldset>
      </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
          <button type="submit" class="btn btn-primary" id="btnFormNovoKit">Salvar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
    </div>
  </div>
 </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#novo_kit').modal('show');
    });
</script>