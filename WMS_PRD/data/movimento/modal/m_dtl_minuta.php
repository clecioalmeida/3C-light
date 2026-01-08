<?php 

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_min = $_POST["cod_min"];

$sql_min = "select cod_minuta, date(dt_minuta) as dt_minuta, ds_tipo, ds_transporte, nr_placa, tp_veiculo, hr_entrada, hr_saida, km_ini, km_fim, nr_averba, fl_comprovante, ds_obs, fl_status
from tb_minuta
where cod_minuta = '$cod_min'";
$res_min = mysqli_query($link,$sql_min);
while ($minuta = mysqli_fetch_assoc($res_min)) {
  $cod_minuta     = $minuta['cod_minuta'];
  $dt_minuta      = $minuta['dt_minuta'];
  $ds_tipo        = $minuta['ds_tipo'];
  $ds_transporte  = $minuta['ds_transporte'];
  $nr_placa       = $minuta['nr_placa'];
  $tp_veiculo     = $minuta['tp_veiculo'];
  $hr_entrada     = $minuta['hr_entrada'];
  $hr_saida       = $minuta['hr_saida'];
  $km_ini         = $minuta['km_ini'];
  $km_fim         = $minuta['km_fim'];
  $nr_averba      = $minuta['nr_averba'];

  if($minuta['fl_comprovante'] == ""){

    $fl_comprovante = "NÃO INFORMADO";

  }else{

    $fl_comprovante = $minuta['fl_comprovante'];

  }
  
  $ds_obs         = $minuta['ds_obs'];
  $fl_status      = $minuta['fl_status'];

}

$link->close();
?>
<div class="modal fade" id="altera_pedido" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E;">
        <h5 class="modal-title" style="color: white">ROMANEIO <?php echo $cod_min;?></h5>
        <input type="hidden" name="nr_pedido" id="nr_pedido" value="">
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <form method="post" action="" id="formFrota">
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="codigo">DATA DE SAÍDA</label>
              <div class="col-sm-4">
                <input type="date" class="form-control" align="center" id="dt_minuta" name="dt_minuta" value="<?php echo $dt_minuta;?>">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="descricao">HORA DE ENTRADA E SAÍDA</label>
              <div class="col-sm-2">
                <input type="time" class="form-control" id="hr_entrada" name="hr_entrada" value="<?php echo $hr_entrada;?>">
                <div class="form-control-focus"> </div>
              </div>
              <div class="col-sm-2">
                <input type="time" class="form-control" id="hr_saida" name="hr_saida" value="<?php echo $hr_saida;?>">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </fieldset><br>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="codigo">PLACA DO VEÍCULO</label>
              <div class="col-sm-2">
                <input type="text" class="form-control"  align="center" id="nr_placa" name="nr_placa" value="<?php echo $nr_placa;?>">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="descricao">TRANSPORTADOR / MOTORISTA</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="ds_transporte" name="ds_transporte" value="<?php echo $ds_transporte;?>">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="codigo">KM INICIAL</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="km_ini" name="km_ini" value="<?php echo $km_ini;?>" style="text-align: right;">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="descricao">KM FINAL</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="km_fim" name="km_fim" value="<?php echo $km_fim;?>" style="text-align: right;">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="descricao">TIPO</label>
              <div class="col-sm-2">
                <select class="form-control" id="ds_tipo" name="ds_tipo">
                  <option value="<?php echo $ds_tipo;?>"><?php echo $ds_tipo;?></option>
                  <option value="NORMAL">NORMAL</option>
                  <option value="SPOT">SPOT</option>
                </select>
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </fieldset><br>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="codigo">AVERBAÇÃO</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="nr_averba" name="nr_averba" value="<?php echo $nr_averba;?>" style="text-align: right;">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-4 control-label" for="fl_comprovante">CANHOTO ASSINADO?</label>
              <div class="col-sm-2">
                <select class="form-control" id="fl_comprovante" name="fl_comprovante">
                  <option value="<?php echo $fl_comprovante;?>"><?php echo $fl_comprovante;?></option>
                  <option value="SIM">SIM</option>
                  <option value="NÃO">NÃO</option>
                </select>
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </fieldset><br>
          <fieldset>
            <div class="form-group" id="">
              <label class="col-sm-2 control-label" for="fl_comprovante">TIPO DE VEÍCULO</label>
              <div class="col-sm-2">
                <select class="form-control" id="tp_veiculo" name="tp_veiculo">
                  <option value="<?php echo $fl_comprovante;?>"><?php echo $tp_veiculo;?></option>
                  <option value="TRUCK">TRUCK</option>
                  <option value="TRUCK MUNK">TRUCK MUNK</option>
                  <option value="TRUCK SIDER">TRUCK SIDER</option>
                  <option value="CARRETA SIMPLES">CARRETA SIMPLES</option>
                  <option value="CARRETA DE 2 EIXOS">CARRETA DE 2 EIXOS</option>
                  <option value="CARRETA DE 3 EIXOS">CARRETA DE 3 EIXOS</option>
                  <option value="TOCO">TOCO</option>
                  <option value="3/4">3/4</option>
                  <option value="UTILITÁRIO">UTILITÁRIO</option>
                  <option value="HR">HR</option>
                </select>
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="qtde">INSTRUÇÕES DE ENTREGA</label>
              <div class="col-sm-6">
                <textarea class="form-control" rows="3" id="ds_obs" name="ds_obs" value="<?php echo $ds_obs;?>"><?php echo $ds_obs;?></textarea>
              </div>
            </div>
          </fieldset><br>
          <fieldset id="retInsMinuta" style="display: none">

          </fieldset><br>
          <fieldset id="listPedRom" data-min="<?php echo $cod_min;?>">
            <table class="table" id="">
              <thead>
                <tr>
                  <th>
                    <div class="form-group">
                      <label class="checkbox-inline">
                        <input type="checkbox" id="checkboxTodosExp" class="checkbox style-0" checked>
                        <span></span>
                      </label>
                    </div>
                  </th>
                  <th> PEDIDO</th>
                  <th> PEDIDO SAP</th>
                  <th> DOC MATERIAL </th>
                  <th> D.E.M </th>
                  <th> VALOR TOTAL </th>
                  <th> COD ALMOX </th>
                  <th> DESTINO  </th>
                  <th> AÇÕES </th>
                </tr>
              </thead>
              <tbody id="retPrdPedido">

              </tbody>
            </table>
          </fieldset>
        </form>   
      </div>
      <div class="modal-footer" style="background-color: #22262E;">
        <button type="button" class="btn btn-primary" id="btnSaveUpdMinuta">SALVAR</button>
        <input type="hidden" id="cod_min" name="cod_min" value="">
        <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
      </div>
    </div>
  </div>
</form>
</div>
<script>
  $(document).ready(function () {
    $('#altera_pedido').modal('show');
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkboxTodos").click(function(){
      $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $("#btnPrintMinuta").prop("disabled", false);

    $('#retPrdPedido').load('data/movimento/tb_ped_rom.php?search=',{cod_min:'<?php echo $cod_minuta;?>'});
  });
</script>