<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rec = mysqli_real_escape_string($link, $_POST["upd_rec"]);

  $SQL = "select t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, t1.tp_rec, t1.dt_recebimento_previsto,  t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, t1.dt_recebimento_real, t1.nm_user_criado_por, t1.nm_user_conferido_por, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, t1.nm_user_recebido_por, t1.dt_user_recebido_por, t1.nm_user_autorizado_por, t1.dt_user_autorizado_por, t2.cod_cliente, t2.nm_cliente, t3.nm_tipo, t3.cod_tipo 
  from tb_recebimento t1 
  left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
  left join tb_tipo t3 on t1.tp_rec = t3.cod_tipo
  where t1.fl_status ='A' and cod_recebimento = '$id_rec'";

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
    $cod_tipo=$dados['cod_tipo'];
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

  $sql_cli = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'C' and fl_status = 1" or die(mysqli_error($sql_cli));
  $select_cliente = mysqli_query($link, $sql_cli);

  $sql_conf = "select t1.nm_user_recebido_por, t2.cod_cliente, t2.nm_cliente from tb_cliente t2 left join tb_recebimento t1 on t1.nm_user_recebido_por = t2.cod_cliente where t1.cod_recebimento = '$id_rec'" or die(mysqli_error($sql_conf));
  $res_conf = mysqli_query($link, $sql_conf);

  while ($dados_conf = mysqli_fetch_assoc($res_conf)) {
    $usr_rec=$dados_conf['nm_cliente'];
    $usr_cod=$dados_conf['cod_cliente'];
  }

  $sql_conf_aut = "select t1.nm_user_autorizado_por, t2.cod_cliente, t2.nm_cliente from tb_cliente t2 left join tb_recebimento t1 on t1.nm_user_autorizado_por = t2.cod_cliente where t1.cod_recebimento = '$id_rec'" or die(mysqli_error($sql_conf_aut));
  $res_conf_aut = mysqli_query($link, $sql_conf_aut);

  


  $sql_usr = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'U' and fl_status = 1" or die(mysqli_error($sql_usr));
  $res_usr = mysqli_query($link, $sql_usr); 
  
  $sql_fornecedor = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'D' and fl_status = 1" or die(mysqli_error($sql_fornecedor));
  
  $select_fornecedor = mysqli_query($link, $sql_fornecedor);

  $sql_tp = "select cod_tipo, nm_tipo from tb_tipo where ds_tipo = 1";  
  $res_tp = mysqli_query($link, $sql_tp); 

    $sql_tipo2 = "select t1.* from tb_tipo t1
    left join tb_recebimento t2 on t1.cod_tipo = t2.tp_rec
    where ds_tipo = 1";
    $res_tipo2 = mysqli_query($link, $sql_tipo2);   
$link->close();
?>
<div class="modal fade" id="alterar_recebimento" aria-hidden="true">
             <form method="post" action="" id="formUpdRec">
             <input type="hidden" name="cod_recebimento" value="<?php echo $cod_recebimento; ?>">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" style="color: white">Alterar ordem de recebimento <?php echo $cod_recebimento; ?>, <?php echo $dados['nm_cliente']; ?> </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                  </div>
                  <div class="modal-body modal-lg" style="overflow-y: auto">
                  	  <fieldset>
                        <div class="col-xs-3">
                          <div class="form-group">
                            <label class="control-label" for="or">Primeiro conferente</label>
                            <select class="form-control" name="nm_user_recebido_por" id="nm_user_recebido_por">
                              <option value="<?php echo $usr_cod; ?>"><?php echo $usr_rec; ?></option>
                              <?php 
                              include('xhr/select_cliente_recebimento.php');
                              while($usr = mysqli_fetch_assoc($res_usr)) {?>
                              <option value="<?php echo $usr['cod_cliente']; ?>">
                                <?php echo $usr['nm_cliente']; ?>
                              </option> <?php } ?>
                            </select>
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-xs-3">
                          <div class="form-group">
                            <label class="control-label" for="or">Data</label>
                            <input type="date" class="form-control" name="dt_user_recebido_por" value="<?php
                                                    if($dt_user_recebido_por < 1){
                                                      echo '';
                                                    }else{
                                                      echo date('Y-m-d', strtotime($dt_user_recebido_por));
                                                    } ?>">
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-xs-3">
                          <div class="form-group">
                            <label class="control-label" for="or">Segundo conferente</label>
                            <select class="form-control" name="nm_user_autorizado_por" id="nm_user_autorizado_por">
                              <option value="<?php echo $usr_cod_aut; ?>"><?php
                                                    if($usr_rec_aut == ""){
                                                      echo "";
                                                    }else{
                                                      echo $usr_rec_aut;
                                                    } ?>"></option>
                              <option value=""></option>
                            </select>
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-xs-3">
                          <div class="form-group">
                            <label class="control-label data" for="or">Data</label>
                            <input type="date" class="form-control data" name="dt_user_autorizado_por" value="<?php
                                                    if($dt_user_autorizado_por < 1){
                                                      echo '';
                                                    }else{
                                                      echo date('Y/m/d', strtotime($dt_user_autorizado_por));
                                                    } ?>">
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                      </fieldset>
                      <hr>
                      <fieldset>
                        <div class="col-xs-6">
                            <label class="col-xs-2 control-label" for="or">Cliente</label>
                            <input type="text" class="form-control" placeholder="Cliente" value="<?php echo $nm_cliente; ?>" readonly="true">
                        </div><!-- /.col-lg-6 -->
                      </fieldset>
                      <fieldset>
                        <div class="col-xs-6">
                          <div class="form-group">
                            <label class="control-label" for="or">Fornecedor</label>
                            <input type="text" class="form-control" name="nm_fornecedor" value="<?php echo $nm_fornecedor; ?>" placeholder="Fornecedor">
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                      </fieldset>
                      <hr>
                      <fieldset>
                      <div class="col-xs-6">
                            <label class="col-xs-4 control-label" for="or">Tipo de recebimento</label>
                            <select class="form-control" name="tp_rec">
                              <option value="<?php echo $cod_tipo; ?>"><?php echo $nm_tipo; ?></option>
                              <?php 
                              include('xhr/select_cliente_recebimento.php');
                              while($tipo = mysqli_fetch_assoc($res_tp)) {?>
                              <option value="<?php echo $tipo['cod_tipo']; ?>">
                                <?php echo $tipo['nm_tipo']; ?>
                              </option> <?php } ?>
                            </select>
                        </div><!-- /.col-lg-6 -->
                      </fieldset>
                      <fieldset>
                        <div class="col-xs-4">
                          <div class="form-group">
                            <label class="control-label" for="or">Peso previsto</label>
                            <input type="text" class="form-control" name="nr_peso_previsto" value="<?php echo $nr_peso_previsto; ?> " placeholder="Peso previsto">
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-xs-4">
                          <div class="form-group">
                            <label class="control-label" for="or">Data prevista</label>
                            <input type="date" class="data form-control" name="dt_recebimento_previsto" value="<?php
                          													if($dt_recebimento_previsto < 1){
                          														echo '';
                          													}else{
                          														echo date('Y/m/d', strtotime($dt_recebimento_previsto));
                          													} ?>" placeholder="Data prevista">
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-xs-4">
                          <div class="form-group">
                            <label class="control-label" for="or">Volume previsto</label>
                            <input type="text" class="form-control" name="nr_volume_previsto" value="<?php echo $nr_volume_previsto; ?> " placeholder="Volume previsto">
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                      </fieldset>
                      <fieldset>
                        <div class="col-xs-6">
                          <div class="form-group">
                            <label class="control-label" for="or">Transportador</label>
                            <input type="text" class="form-control" name="nm_transportadora" value="<?php echo $nm_transportadora; ?> " placeholder="Transportador">
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-xs-6">
                          <div class="form-group">
                            <label class="control-label" for="or">Motorista</label>
                            <input type="text" class="form-control" name="nm_motorista" value="<?php echo $nm_motorista; ?> " placeholder="Motorista">
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                      </fieldset>
                      <fieldset>
                        <div class="col-xs-6">
                          <div class="form-group">
                            <label class="control-label" for="or">Placa</label>
                            <input type="text" class="form-control" name="nm_placa" value="<?php echo $nm_placa; ?> " placeholder="Placa">
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <div class="col-xs-6">
                          <div class="form-group">
                            <label class="control-label" for="or">Data real</label>
                            <input type="date" class="form-control" name="dt_recebimento_real" value="<?php
                          													if($dt_recebimento_real < 1){
                          														echo '';
                          													}else{
                          														echo date('Y/m/d', strtotime($dt_recebimento_real));
                          													} ?>" placeholder="Data real">
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                      </fieldset>
                      <fieldset>
                        <div class="col-xs-10">
                          <div class="form-group">
                            <label class="control-label" for="or">Observações</label>
                            <input type="textare" class="form-control" name="ds_obs" value="<?php echo $ds_obs; ?> " placeholder="Observações">
                          </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                      </fieldset>
                    </div>
                    <div class="modal-footer" style="background-color: #2F4F4F;">
                    <button type="submit" class="btn btn-primary" id="btnFormUpdRec">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
              </div>
             </form>
            </div><!--Fim modal-->
<script>
  $(document).ready(function () {
    $('#alterar_recebimento').modal('show');
  });
</script>