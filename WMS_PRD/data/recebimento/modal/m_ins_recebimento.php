<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php
require_once "bd_class.php";

$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'C' and fl_status = 1" or die(mysqli_error($sql));

$sql_usr = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'U' and fl_status = 1" or die(mysqli_error($sql));
$res_usr = mysqli_query($link, $sql_usr);

$select_cliente = mysqli_query($link, $sql);

$sql_fornecedor = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'D' and fl_status = 1" or die(mysqli_error($sql));

$select_fornecedor = mysqli_query($link, $sql_fornecedor);

$sql_tp = "select cod_tipo, nm_tipo from tb_tipo where ds_tipo = 1";
$res_tp = mysqli_query($link, $sql_tp);

$sql_tipo2 = "select t1.* from tb_tipo t1
left join tb_recebimento t2 on t1.cod_tipo = t2.tp_rec
where ds_tipo = 1";
$res_tipo2 = mysqli_query($link, $sql_tipo2);

$link->close();
?>
<div class="modal fade" id="novo_recebimento" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Incluir ordem de recebimento</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <fieldset>
          <div class="col-xs-6">
            <label class="col-xs-2 control-label" for="cod_cli">Cliente</label>
            <select class="form-control" name="cod_cli" id="cod_cli">
              <?php
              while ($row_select_cliente = mysqli_fetch_assoc($select_cliente)) {?>
                <option value="<?php echo $row_select_cliente['cod_cliente']; ?>"><?php echo $row_select_cliente['nm_cliente']; ?>
                </option> <?php }?>
              </select>
            <input type="hidden" name="nm_user_criado_por" id="nm_user_criado_por" value="<?php echo $id; ?>">
          </div><!-- /.col-lg-6 -->
        </fieldset>
        <fieldset>
          <div class="col-xs-6">
            <div class="form-group">
              <label class="control-label" for="nm_fornecedor">Fornecedor</label>
              <input type="text" class="form-control" name="nm_fornecedor" placeholder="Fornecedor" id="nm_fornecedor" required="true">
            </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->
        </fieldset>
        <fieldset>
          <div class="col-xs-6">
            <label class="col-xs-4 control-label" for="tp_rec">Tipo</label>
            <select class="form-control" name="tp_rec" id="tp_rec">
              <option>Selecione</option>
              <?php
              while ($row_select_tipo = mysqli_fetch_assoc($res_tp)) {?>
                <option value="<?php echo $row_select_tipo['cod_tipo']; ?>">
                  <?php echo $row_select_tipo['nm_tipo']; ?>
                  </option> <?php }?>
                </select>
              </div><!-- /.col-lg-6 -->
              <div class="col-xs-4">
                <div class="insumo">
                  <div class="form-group">
                    <label class="control-label" for="nr_insumo">Pedido de compra</label>
                    <input type="text" class="form-control" name="nr_insumo" placeholder="Pedido de compra" id="nr_insumo">
                  </div><!-- /input-group -->
                </div>
              </div><!-- /.col-lg-6 -->
            </fieldset>
            <fieldset>
              <div class="col-xs-4">
                <div class="form-group">
                  <label class="control-label" for="nr_peso_previsto">Peso previsto</label>
                  <input type="text" class="form-control" name="nr_peso_previsto" placeholder="Peso previsto" id="nr_peso_previsto">
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
              <div class="col-xs-4">
                <div class="form-group">
                  <label class="control-label" for="dt_recebimento_previsto">Data prevista</label>
                  <input type="date" class="form-control" name="dt_recebimento_previsto" placeholder="Data prevista" id="dt_recebimento_previsto">
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
              <div class="col-xs-4">
                <div class="form-group">
                  <label class="control-label" for="nr_volume_previsto">Volume previsto</label>
                  <input type="text" class="form-control" name="nr_volume_previsto" placeholder="Volume previsto" id="nr_volume_previsto">
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
            </fieldset>
            <fieldset>
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label" for="nm_transportadora">Transportador</label>
                  <input type="text" class="form-control" name="nm_transportadora" placeholder="Transportador" id="nm_transportadora">
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label" for="nm_motorista">Motorista</label>
                  <input type="text" class="form-control" name="nm_motorista" placeholder="Motorista" id="nm_motorista">
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
            </fieldset>
            <fieldset>
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label" for="nm_placa">Placa</label>
                  <input type="text" class="form-control" name="nm_placa" placeholder="Placa" id="nm_placa">
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label" for="dt_recebimento_real">Data real</label>
                  <input type="date" class="form-control" name="dt_recebimento_real" placeholder="Data real" id="dt_recebimento_real">
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
            </fieldset>
            <fieldset>
              <div class="col-xs-10">
                <div class="form-group">
                  <label class="control-label" for="ds_obs">Observações</label>
                  <input type="textare" class="form-control" name="ds_obs" placeholder="Observações" id="ds_obs">
                </div><!-- /input-group -->
              </div><!-- /.col-lg-6 -->
            </fieldset>
          </div>
          <div class="modal-footer" style="background-color: #2F4F4F;">
            <button type="submit" class="btn btn-primary" id="btnFormNovoRec">Salvar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </form>
  </div><!--Fim modal-->
  <script>
    $(document).ready(function () {
      $('#novo_recebimento').modal('show');
      $('.insumo').hide();
    });

    $(document).on('change', '#tp_rec', function () {
      if($('#tp_rec').val()==10){

        $('.insumo').show();

      }else{
        $('.insumo').hide();
      }
    });
  </script>