 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $link->close();
 ?>
 <div class="modal fade" id="recIndCron" aria-hidden="true">
   <form method="post" action="" id="formInsVlrEst">
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
                <label class="col-sm-2 control-label" for="nm_produto">VALOR TOTAL DO ESTOQUE</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="vlr_total" name="vlr_total" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">VALOR MÉDIO DO ESTOQUE</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="vlr_medio" name="vlr_medio" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
          </fieldset>
        </div>
        <div class="modal-footer modal-lg" style="background-color: #22262E;">
          <button type="submit" class="btn btn-primary" id="btnSaveVlrEst" value="<?php echo $upd_rec;?>">SALVAR</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function () {
    $('#recIndCron').modal('show');

    $('#vlr_total').on('change', function(){

      vlr_total = parseFloat($('#vlr_total').val().replace('.','').replace(',','.'));
      var vlr_total2 = vlr_total.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
      $('#vlr_total').val(vlr_total2);

    });

    $('#vlr_medio').on('change',function(){

      vlr_medio =  parseFloat($('#vlr_medio').val().replace('.','').replace(',','.'));
      var vlr_medio2 = vlr_medio.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
      $('#vlr_medio').val(vlr_medio2);

    });

  });
</script>