 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $link->close();
 ?>
 <div class="modal fade" id="recInsTran" aria-hidden="true">
   <form method="post" action="" id="forminsIindQualidade">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #22262E;">
          <h5 class="modal-title" style="color: white"></h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body modal-lg" style="overflow-y: auto">
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="produto">DATA</label>
                <div class="col-sm-3">
                  <input type="date" class="form-control" name="ds_data" id="ds_data" name="ds_data" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
          </fieldset>
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nr_sku_blq">QTDE SKU BLOQUEADAS</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="nr_sku_blq" id="nr_sku_blq" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="vlr_sku_blq">VALOR BLOQUEADO</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="vlr_sku_blq" id="vlr_sku_blq" style="text-align: right;">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>            
          </fieldset>
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nr_est_qld">QTDE SKU EM QUALIDADE</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="nr_est_qld" id="nr_est_qld" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="vlr_est_qld">VALOR ESTOQUE QUALIDADE</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="vlr_est_qld" id="vlr_est_qld" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>        
          </fieldset>
        </div>
        <div class="modal-footer modal-lg" style="background-color: #22262E;">
          <button type="submit" class="btn btn-primary" id="btnSaveQld" value="">SALVAR</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function () {
    $('#recInsTran').modal('show');
  });
</script>