 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $link->close();
 ?>
 <div class="modal fade" id="recInsSeg" aria-hidden="true">
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
                <label class="col-sm-2 control-label" for="produto">PERÍODO</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="ds_mes" placeholder="Mês (mm)" required="true">
                </div>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="ds_ano" placeholder="Ano (aaaa)" required="true">
                </div>
              </div>
            </section>
          </fieldset>
          <hr>
          <!--fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">QTDE IPAL PREVISTA</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="qtd_ipal_prev" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">QTDE IPAL EXECUTADAS</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="qtd_ipal_exe" style="text-align: right;"  required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
          </fieldset-->
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">QTDE OCORRÊNCIAS</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="nr_irreg_seg" style="text-align: right;" required="true">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>
            <section>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="nm_produto">QTDE ACIDENTES FATAIS</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="nr_acd_fat" style="text-align: right;">
                  <div class="form-control-focus"> </div>
                </div>
              </div>
            </section>            
          </fieldset>
        </div>
        <div class="modal-footer modal-lg" style="background-color: #22262E;">
          <button type="submit" class="btn btn-primary" id="btnSaveSeg" value="">SALVAR</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function () {
    $('#recInsSeg').modal('show');
  });
</script>