<?php 

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST["nr_ped"];

$table = "";

foreach($nr_pedido as $cod){

  $sql_ped="select nr_pedido, nr_ped_sap, doc_material, cod_almox, ds_destino, nr_dem, vlr_dem
  from tb_pedido_coleta
  where nr_pedido = '$cod'";
  $res_ped = mysqli_query($link,$sql_ped);
  $dados = mysqli_fetch_assoc($res_ped);
  $table .= '
  <tr>
  <td>
  <div class="form-group">
  <label class="checkbox-inline">
  <input type="checkbox" class="checkbox style-0 checkPedRom" id="checkPedRom" value="'.$dados['nr_pedido'].'" data-vol="" checked>
  <span></span>
  </label>
  </div>
  </td>
  <td style="text-align: right">'.$dados['nr_pedido'].'</td>
  <td style="text-align: right">'.$dados['nr_ped_sap'].'</td>
  <td style="text-align: right">'.$dados['doc_material'].'</td>
  <td style="text-align: right">'.$dados['nr_dem'].'</td>
  <td style="text-align: right">'.$dados['vlr_dem'].'</td>
  <td style="text-align: right">'.$dados['cod_almox'].'</td>
  <td>'.$dados['ds_destino'].'</td>
  <td style="text-align: center">
  <button type="submit" id="btnDelPedRomaneio" class="btn btn-danger btn-xs" value="">Excluir</button>
  </td>
  </tr>';
}

$link->close();
?>
<div class="modal fade" id="altera_pedido" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E;">
        <h5 class="modal-title" style="color: white">EMITIR ROMANEIO</h5>
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
                <input type="date" class="form-control" align="center" id="dt_minuta" name="dt_minuta">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="descricao">HORA DE ENTRADA E SAÍDA</label>
              <div class="col-sm-2">
                <input type="time" class="form-control" id="hr_entrada" name="hr_entrada">
                <div class="form-control-focus"> </div>
              </div>
              <div class="col-sm-2">
                <input type="time" class="form-control" id="hr_saida" name="hr_saida">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </fieldset><br>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="codigo">PLACA DO VEÍCULO</label>
              <div class="col-sm-2">
                <input type="text" class="form-control"  align="center" id="nr_placa" name="nr_placa">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="descricao">TRANSPORTADOR / MOTORISTA</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="ds_transporte" name="ds_transporte">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="codigo">KM INICIAL</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="km_ini" name="km_ini">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="descricao">KM FINAL</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="km_fim" name="km_fim">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="descricao">TIPO</label>
              <div class="col-sm-2">
                <select class="form-control" id="ds_tipo" name="ds_tipo">
                  <option value="NORMAL">NORMAL</option>
                  <option value="SPOT">SPOT</option>
                </select>
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </fieldset><br>
          <fieldset>
            <div class="form-group" id="">
              <label class="col-sm-2 control-label" for="qtde">INSTRUÇÕES DE ENTREGA</label>
              <div class="col-sm-10">
                <textarea class="form-control" rows="3" id="ds_obs" name="ds_obs"></textarea>
              </div>
            </div>
          </fieldset><br>
          <fieldset id="retInsMinuta" style="display: none">

          </fieldset><br>
          <fieldset id="listPedRom" data-ped="<?php echo $nr_pedido;?>">
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
                  <?php echo $table;?>
              </tbody>
            </table>
          </fieldset>
        </form>   
      </div>
      <div class="modal-footer" style="background-color: #22262E;">
        <form class="form-horizontal" method="post" action="data/movimento/relatorio/minuta_list.php" target="_blank">
          <button type="button" class="btn btn-primary" id="btnSaveMinuta">SALVAR</button>
          <input type="hidden" id="cod_min" name="cod_min" value="">
          <button type="submit" class="btn btn-success" id="btnPrintMinuta">IMPRIMIR</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
        </form>
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
    $("#btnPrintMinuta").prop("disabled", true);
  });
</script>