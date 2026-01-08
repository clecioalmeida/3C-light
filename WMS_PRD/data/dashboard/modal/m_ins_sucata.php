 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $link->close();
 ?>
 <div class="modal fade" id="recIndARev" aria-hidden="true">
   <form method="post" action="" id="forminsIindSucata">
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
                <label class="col-sm-1 control-label" for="produto">DATA</label>
                <div class="col-sm-3">
                  <input type="date" class="form-control" id="ds_data" name="ds_data" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-1 control-label" for="nm_produto">TOTAL DE VENDAS</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="nr_total_sct" name="nr_total_sct" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-1 control-label" for="nm_produto">VENDAS COM DIVERGÊNCIA</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="nr_sct_div" name="nr_sct_div" style="text-align: right;"  required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
          </fieldset>
        </div>
        <div class="modal-footer modal-lg" style="background-color: #22262E;">
          <button type="submit" class="btn btn-primary" id="btnSaveIndSct" value="">SALVAR</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function () {

    $('#recIndARev').modal('show');

  });
</script>