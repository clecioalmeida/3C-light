<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rec = mysqli_real_escape_string($link, $_POST["dtl_rec"]);

  $SQL = "select t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, t1.tp_rec, t1.dt_recebimento_previsto,  t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, t1.dt_recebimento_real, t1.nm_user_criado_por, t1.nm_user_conferido_por, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, t1.nm_user_recebido_por, t1.dt_user_recebido_por, t1.nm_user_autorizado_por, t1.dt_user_autorizado_por, t2.cod_cliente, t2.nm_cliente, t3.nm_tipo, t3.cod_tipo 
  from tb_recebimento t1 
  left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
  left join tb_tipo t3 on t1.tp_rec = t3.cod_tipo
  where t1.cod_recebimento = '$id_rec'";

  $res = mysqli_query($link,$SQL);

while ($dados = mysqli_fetch_assoc($res)) {
    $cod_recebimento=$dados['cod_recebimento'];
    $nm_user_recebido_por=$dados['nm_user_recebido_por'];
    $dt_user_recebido_por=$dados['dt_user_recebido_por'];
    $nm_user_autorizado_por=$dados['nm_user_autorizado_por'];
    $dt_user_autorizado_por=$dados['dt_user_autorizado_por'];
    $nm_cliente=$dados['nm_cliente'];
    $cod_recebimento=$dados['cod_recebimento'];
    $nm_fornecedor=$dados['nm_fornecedor'];
    $nm_tipo=$dados['nm_tipo'];
    $nr_peso_previsto=$dados['nr_peso_previsto'];
    $dt_recebimento_previsto=$dados['dt_recebimento_previsto'];
    $nr_volume_previsto=$dados['nr_volume_previsto'];
    $nm_transportadora=$dados['nm_transportadora'];
    $nm_motorista=$dados['nm_motorista'];
    $nm_placa=$dados['nm_placa'];
    $dt_recebimento_real=$dados['dt_recebimento_real'];
    $ds_obs=$dados['ds_obs'];
}

$link->close();
?>
<div class="modal fade" id="detalhe_recebimento" aria-hidden="true">
	<form method="post" action="">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header" style="background-color: #2F4F4F;">
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
					<h5 class="modal-title" style="color: white">Ordem de recebimento <?php echo $cod_recebimento; ?>, <?php echo $nm_cliente; ?> </h5>
				</div>
				<div class="modal-body modal-lg">
          <fieldset>
            <div class="col-xs-3">
              <div class="form-group">
                <label class="control-label" for="or">Primeiro conferente</label>
                <input type="text" class="form-control" value="<?php echo $nm_user_recebido_por; ?>" name="" placeholder="Conferente 1" readonly="true">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-xs-3">
              <div class="form-group">
                <label class="control-label" for="or">Data</label>
                <input type="text" class="form-control data" name="" value="<?php
                  if($dt_user_recebido_por < 1){
                    echo '';
                   }else{
                    echo date('d/m/Y', strtotime($dt_user_recebido_por));
                   } ?>" readonly="true">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-xs-3">
              <div class="form-group">
                <label class="control-label" for="or">Segundo conferente</label>
                <input type="text" class="form-control" value="<?php echo $nm_user_autorizado_por; ?>" name="" placeholder="Conferente 2" readonly="true">
               </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-xs-3">
              <div class="form-group">
                <label class="control-label data" for="or">Data</label>
                <input type="text" class="form-control data" name="dt_user_autorizado_por" value="<?php
                  if($dt_user_autorizado_por < 1){
                    echo '';
                  }else{
                    echo date('d/m/Y', strtotime($dt_user_autorizado_por));
                  } ?>" readonly="true">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          </fieldset>
          <hr>
          <fieldset>
            <div class="col-xs-6">
               <div class="input-group">
                          <label class="control-label" for="or">Cliente</label>
                          <input type="text" class="form-control" value="<?php echo $nm_cliente; ?>" name="nm_cliente" placeholder="Cliente" readonly="true">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label class="control-label" for="or">Código</label>
                          <input type="text" class="form-control" value="<?php echo $cod_recebimento; ?>" name="cod_recebimento" placeholder="Código" readonly="true">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->
                      <div class="col-xs-6">
                        <div class="input-group">
                          <label class="control-label" for="or">Fornecedor</label>
                          <input type="text" class="form-control" value="<?php echo $nm_fornecedor; ?>" name="nm_fornecedor" placeholder="Fornecedor" readonly="true">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->
                      <hr>
                      </fieldset>
                      <hr>
                      <fieldset>
                      <div class="col-xs-6">
                            <label class="col-xs-4 control-label" for="or">Tipo de recebimento</label>
                            <input type="text" class="form-control" value="<?php echo $nm_tipo; ?>" name="" placeholder="" readonly="true">
                        </div><!-- /.col-lg-6 -->
                      </fieldset>
                      <fieldset>
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label class="control-label" for="or">Peso previsto</label>
                          <input type="text" class="form-control" value="<?php echo $nr_peso_previsto; ?>" name="nr_peso_previsto" placeholder="Peso previsto" readonly="true">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label class="control-label" for="or">Data prevista</label>
                          <input type="text" class="form-control data" value="<?php
                          													if($dt_recebimento_previsto < 1){
                          														echo '';
                          													}else{
                          														echo date('d/m/Y', strtotime($dt_recebimento_previsto));
                          													} ?>" name="dt_recebimento_previsto" placeholder="Data prevista" readonly="true">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label class="control-label" for="or">Volume previsto</label>
                          <input type="text" class="form-control" value="<?php echo $nr_volume_previsto; ?>" name="nr_volume_previsto" placeholder="Volume previsto" readonly="true">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label class="control-label" value="<?php echo $nm_transportadora; ?>" for="or">Transportador</label>
                          <input type="text" class="form-control" name="nm_transportadora" placeholder="Transportador" readonly="true">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label class="control-label" for="or">Motorista</label>
                          <input type="text" class="form-control" value="<?php echo $nm_motorista; ?>" name="nm_motorista" placeholder="Motorista" readonly="true">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label class="control-label" for="or">Placa</label>
                          <input type="text" class="form-control" value="<?php echo $nm_placa; ?>" name="nm_placa" placeholder="Placa" readonly="true">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->
                    </fieldset>
                    <fieldset>
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label class="control-label" for="or">Data real</label>
                          <input type="text" class="form-control data" value="<?php
                          													if($dt_recebimento_real < 1){
                          														echo '';
                          													}else{
                          														echo date('d/m/Y', strtotime($dt_recebimento_real));
                          													} ?>"
                             name="dt_recebimento_real" placeholder="Data real" readonly="true">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->
                      <div class="col-xs-10">
                        <div class="form-group">
                          <label class="control-label" for="or">Observações</label>
                          <input type="textarea" class="form-control" value="<?php echo $ds_obs; ?>" name="ds_obs" placeholder="Observações" readonly="true">
                        </div><!-- /input-group -->
                      </div><!-- /.col-lg-6 -->
                    </fieldset>
                    </div>
                    <div class="modal-footer" style="background-color: #2F4F4F;">
											<!--button type="submit" class="btn btn-primary" id="">Salvar</button-->
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
									</div>
								</div>
							</form>
            </div><!--Fim modal-->
<script>
  $(document).ready(function () {
    $('#detalhe_recebimento').modal('show');
  });
</script>