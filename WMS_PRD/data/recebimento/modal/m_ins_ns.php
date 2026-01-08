<?php 

  require_once('bd_class.php');
  $objDb = new db();
  $link = $objDb->conecta_mysql();

  $id_nf_item = mysqli_real_escape_string($link, $_POST["id_nfItem"]);

    
$link->close();
?>
    <div class="modal fade" id="sem_registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #A52A2A;">
                    <h4 class="modal-title" id="myModalLabel" style="color: white">Números de série da nota <?php echo $id_nf_item;?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="n_serie">Números de série:</label>
                        <form method="post" action="" id="formCadNs">
                          <div class="col-sm-12">
                            <input type="hidden" name="produto" value="<?php echo $produto; ?>">
                            <input type="hidden" name="cod_rec" value="<?php echo $cod_rec; ?>">
                            <input type="hidden" name="cod_estoque" value="<?php echo $cod_estoque; ?>">
                            <div class="row">
                              <div class="form-group">
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" name="n_serie" id="n_serie" align="right">
                                  <input type="text" class="form-control" name="n_serie1" id="n_serie1" align="right">
                                  <input type="text" class="form-control" name="n_serie2" id="n_serie2" align="right">
                                  <input type="text" class="form-control" name="n_serie3" id="n_serie3" align="right">
                                  <input type="text" class="form-control" name="n_serie4" id="n_serie4" align="right">
                                </div>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" name="n_serie5" id="n_serie5" align="right">
                                  <input type="text" class="form-control" name="n_serie6" id="n_serie6" align="right">
                                  <input type="text" class="form-control" name="n_serie7" id="n_serie7" align="right">
                                  <input type="text" class="form-control" name="n_serie8" id="n_serie8" align="right">
                                  <input type="text" class="form-control" name="n_serie9" id="n_serie9" align="right">
                                </div>
                              </div>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-primary" id="btnFormCadNs">Salvar</button>
                        </form>
                      </div>
                </div>
                <div class="modal-footer" style="background-color: #A52A2A;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function () {
        $('#sem_registro').modal('show');
    });
</script>