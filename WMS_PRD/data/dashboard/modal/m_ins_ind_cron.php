 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $link->close();
 ?>
 <div class="modal fade" id="recIndCron" aria-hidden="true">
   <form method="post" action="" id="formNovoRec">
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
                <div class="col-sm-2">
                  <input type="date" class="form-control" id="ds_data" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">ENTREGAS PROGRAMADAS</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="nr_ped" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">ENTREGAS REALIZADAS</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="nr_at" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </section>
            </div>
          </fieldset>
        </div>
        <div class="modal-footer modal-lg" style="background-color: #22262E;">
          <button type="submit" class="btn btn-primary" id="btnSaveIndCron" value="<?php echo $upd_rec;?>">SALVAR</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function () {
    $('#recIndCron').modal('show');
  });
</script>