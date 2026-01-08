 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $link->close();
 ?>
 <div class="modal fade" id="recInsTran" aria-hidden="true">
   <form method="post" action="" id="forminsIindTransito">
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
                  <input type="date" class="form-control" name="ds_data" id="ds_data" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nr_prazo">NO PRAZO</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" name="nr_prazo" id="nr_prazo" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nr_atraso">EM ATRASO</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" name="nr_atraso" id="nr_atraso" style="text-align: right;">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>            
          </fieldset>
        </div>
        <div class="modal-footer modal-lg" style="background-color: #22262E;">
          <button type="submit" class="btn btn-primary" id="btnSaveTran" value="">SALVAR</button>
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
<script>
  $(document).ready(function () {

    $(document).on('change','#nr_prazo', function(){

        var nr_prazo = parseFloat($('#nr_prazo').val().replace(',','.'));
        var nr_atraso = parseFloat(100 - nr_prazo).toFixed(2);
        console.log(nr_atraso);

        $('#nr_atraso').val(nr_atraso);


    });

  });
</script>