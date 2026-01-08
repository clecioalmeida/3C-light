 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $link->close();
 ?>
 <div class="modal fade" id="recIndAv" aria-hidden="true">
   <form method="post" action="" id="forminsIindAvaria">
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
                <div class="col-sm-4">
                  <input type="date" class="form-control" id="ds_data" name="ds_data" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
          </fieldset>
          <hr>
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">3C SERVICES (SKU)</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="sku_int" name="sku_int" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">3C SERVICES (VALOR)</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="vlr_int" name="vlr_int" style="text-align: right;"  required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">FORNECEDOR (SKU)</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="sku_for" name="sku_for" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
          </fieldset>
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">FORNECEDOR (VALOR)</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="vlr_for" name="vlr_for" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section> 
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">EDP (SKU)</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="sku_cli" name="sku_cli" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">EDP (VALOR)</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="vlr_cli" name="vlr_cli" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>           
          </fieldset>
          <hr>
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">TOTAL (SKU)</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="sku_total" name="sku_total" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">TOTAL (VALOR)</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="vlr_total" name="vlr_total" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
          </fieldset>
        </div>
        <div class="modal-footer modal-lg" style="background-color: #22262E;">
          <button type="submit" class="btn btn-primary" id="btnSaveIndAv" value="">SALVAR</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function () {

    $('#recIndAv').modal('show');

  });
</script>