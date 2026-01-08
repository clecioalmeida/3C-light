<?php

require_once 'bd_class_dsv.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_col = $_POST['cod_col'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$select_local = "select t1.*, t2.cod_prod_cliente, t2.nm_produto
from tb_coleta_pedido t1
left join tb_produto t2 on t1.produto = t2.cod_produto
where t1.cod_col = '$cod_col' and t1.fl_status <> 'F' and t1.fl_status <> 'E'";
$res_local = mysqli_query($link, $select_local);
while ($dados_local = mysqli_fetch_assoc($res_local)) {
	$nr_pedido = $dados_local['nr_pedido'];
	$fl_status = $dados_local['fl_status'];
	$cod_col = $dados_local['cod_col'];
	$ds_galpao = $dados_local['ds_galpao'];
	$ds_prateleira = $dados_local['ds_prateleira'];
	$ds_coluna = $dados_local['ds_coluna'];
	$ds_altura = $dados_local['ds_altura'];
	$nr_qtde = $dados_local['nr_qtde_col'];
	$nm_produto = $dados_local['nm_produto'];
	$cod_prod_cliente = $dados_local['cod_prod_cliente'];
	$cod_produto = $dados_local['produto'];
	$cod_estoque = $dados_local['cod_estoque'];
}

$sql_galpao = "SELECT distinct id, nome FROM tb_armazem";
$res_galpao = mysqli_query($link, $sql_galpao);
$link->close();
?>
<div class="modal fade" id="updEnd" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Alterar local de coleta</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <h5>Altere a quantidade do local original</h5>
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="codigo">Pedido</label>
            <div class="col-sm-2">
              <input type="text" class="form-control"  align="center" id="id_pedido" name="id_pedido" value="<?php echo $nr_pedido; ?>" readonly="true">
              <input type="hidden" name="fl_status" id="fl_status" value="<?php echo $fl_status; ?>">
              <input type="hidden" name="cod_col" id="cod_col" value="<?php echo $cod_col; ?>">
              <input type="hidden" name="cod_estoque" id="cod_estoque" value="<?php echo $cod_estoque; ?>">
              <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="qtde">Local atual</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" value="<?php echo $ds_prateleira . $ds_coluna . $ds_altura; ?>" align="center" id="ds_local" name="ds_local" readonly="true">
              <div class="form-control-focus"> </div>
            </div>

            <label class="col-sm-2 control-label" for="qtde">Quantidade original</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" value="<?php echo $nr_qtde; ?>" align="center" id="nr_qtde_old" name="nr_qtde_old" readonly="true">
              <div class="form-control-focus"> </div>
            </div>
          </div>
        </fieldset>
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="cod_prod">Produto</label>
            <div class="col-sm-2">
              <input type="text" class="form-control"
               align="center" id="cod_prod" value="<?php echo $cod_produto; ?>" name="cod_produto" readonly="true">
              <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="nm_produto">Descrição</label>
            <div class="col-sm-2">
              <input type="text" class="form-control"
               align="center" id="nm_produto" name="nm_produto" value="<?php echo $nm_produto; ?>" readonly="true">
              <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="qtde">Nova quantidade</label>
            <div class="col-sm-2">
              <input type="text" class="form-control"
               align="center" id="nr_new_qtde" name="nr_new_qtde" required="true">
              <div class="form-control-focus"> </div>
            </div>
          </div>
        </fieldset>
        <fieldset>
            <form method="psot" action="" id="formLocal">
          <hr>
            <h5> Escolha o novo local de coleta</h5>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="galpao">Galpão</label>
              <div class="col-sm-4" id="armaz">
                <select class="form-control" name="ds_galpao" id="galpao_upd">
                  <option>Galpão</option>
                    <?php
while ($dados_galpao = mysqli_fetch_assoc($res_galpao)) {?>
                  <option value="<?php echo $dados_galpao['id']; ?>">
                    <?php echo $dados_galpao['nome']; ?>
                  </option> <?php }?>
                </select>
              </div>
              <label class="col-sm-2 control-label" for="rua">Rua</label>
              <div class="col-sm-4" id="rua">
                <select class="form-control" name="ds_prateleira" id="rua_upd">
                  <option value=""></option>
                </select><br>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="coluna">Coluna</label>
              <div class="col-sm-4" id="coluna">
                <select class="form-control" name="ds_coluna" id="coluna_upd">
                  <option></option>
                </select>
              </div>
              <label class="col-sm-2 control-label" for="id_altura">Altura</label>
              <div class="col-sm-4" id="altura">
                <select class="form-control" name="ds_altura" id="altura_upd">
                  <option></option>
                </select>
              </div>
            </div>
          </fieldset><br />
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="nr_qtde_new_col">Quantidade da nova coleta</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" align="center" id="nr_qtde_new_col" name="nr_qtde_new_col" required="true">
                <div class="form-control-focus"> </div>
              </div>
          </fieldset>
          <fieldset>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Galpão </th>
                  <th>Rua</th>
                  <th>Coluna</th>
                  <th>Altura</th>
                  <th>Reservado</th>
                  <th>Saldo</th>
              </thead>
              <tbody id="retValNewEnd">
              </tbody>
            </table>
            <h2 id="retValInfo" style="text-align: center;background-color: #A52A2A;color: white"></h2>
          </fieldset>
          </div>
        <div class="modal-footer modal-lg" style="background-color: #2F4F4F;">
        <button type="submit" class="btn btn-primary" id="btnUpdEndPedCons">Consultar</button>
        <button type="submit" class="btn btn-danger" id="btnUpdEndPedSave">Alterar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
 </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#updEnd').modal('show');
    });
</script>