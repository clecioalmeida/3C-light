<?php

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = mysqli_real_escape_string($link, $_POST["nr_pedido"]);
$produto = mysqli_real_escape_string($link, $_POST["produto"]);
$nr_qtde = mysqli_real_escape_string($link, $_POST["nr_qtde"]);

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$select_emb = "select t1.nr_pedido, t1.id_contrato, t2.id, t2.ds_tipo, t2.id_contrato
from tb_pedido_coleta t1
left join tb_embalagem t2 on t2.id_contrato = t1.id_contrato
where t1.nr_pedido = '$nr_pedido'";
$res_emb = mysqli_query($link, $select_emb);

$link->close();
?>
<div class="modal fade" id="iniciaManuseio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #8B1A1A">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          &times;
        </button>
        <h4 class="modal-title" id="myModalLabel" style="color:white">Iniciar manuseio</h4>
      </div>
      <div class="modal-body modal-lg">
        <form class="form-horizontal">
          <fieldset>
            <div class="form-group">
              <label class="col-md-1 control-label">Embalagem</label>
              <div class="col-md-5">
                <select class="form-control" id="id_embalagem" name="id_embalagem" required="true">
                  <option></option>
                  <?php
while ($dados = mysqli_fetch_assoc($res_emb)) {?>
                    <option value="<?php echo $dados['id']; ?>"><?php echo $dados['ds_tipo']; ?></option>
                  <?php }?>
                </select>
              </div>
              <label class="col-md-4 control-label">Quantidade por embalagem</label>
              <div class="col-md-2">
                  <input class="form-control" type="text" id="nr_qtde_emb" name="nr_qtde_emb" required="true">
                  <input type="hidden" id="nr_pedido" name="nr_pedido" value="<?php echo $nr_pedido; ?>">
                  <input type="hidden" id="produto" name="produto" value="<?php echo $produto; ?>">
                  <input type="hidden" id="nr_qtde" name="nr_qtde" value="<?php echo $nr_qtde; ?>">
              </div>
            </div>
          </fieldset>
          <fieldset>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
              <thead>
                <tr>
                  <th> ID</th>
                  <th> Pedido</th>
                  <th> Produto </th>
                  <th> Embalagem </th>
                  <th> Qtde emb.  </th>
                  <th> Volumes  </th>
                </tr>
              </thead>
              <tbody class="manuseio" id="retInsManuseio">

              </tbody>
            </table>
          </fieldset>
        </form>
        <div id=""></div>
      </div>
      <div class="modal-footer modal-lg" style="background-color: #8B1A1A">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          Cancelar
        </button>
        <button type="button" class="btn btn-primary" id="btnInitManuseio">
          Salvar
        </button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    $(document).ready(function () {
        $('#iniciaManuseio').modal('show');
    });
</script>