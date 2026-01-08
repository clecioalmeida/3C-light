 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

  $id_ind = $_POST['id_ind'];

  $query_prod="select * from tb_fc_cron where id = '$id_ind'";
  $res_prod = mysqli_query($link,$query_prod);
  while ($dados=mysqli_fetch_assoc($res_prod)) {
    $ds_data  = $dados['ds_data'];
    $nr_ped   = $dados['nr_ped'];
    $nr_at    = $dados['nr_at'];
  }

  $pieces = explode("-", $ds_data);
  $ds_mes = $pieces[0];
  $ds_ano = $pieces[1];

 $link->close();
 ?>
 <div class="modal fade" id="recUpdIndCron" aria-hidden="true">
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
                <label class="col-sm-3 control-label" for="produto">PERÍODO</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="ds_mes" placeholder="Mês (mm)" value="<?php echo $ds_mes;?>" required="true" style="text-align: right;">
                </div>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="ds_ano" placeholder="Ano (aaaa)" value="<?php echo $ds_ano;?>" required="true" style="text-align: right;">
                </div>
              </div>
            </section>
          </fieldset>
          <fieldset>
            <section>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="nm_produto">ENTREGAS PROGRAMADAS</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="nr_ped" value="<?php echo $nr_ped;?>" required="true" style="text-align: right;">
                  <div class="form-control-focus"> </div>
                </div>
              </section>
            <section>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="nm_produto">ENTREGAS REALIZADAS</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="nr_at" value="<?php echo $nr_at;?>" required="true" style="text-align: right;">
                  <div class="form-control-focus"> </div>
                </div>
              </section>
            </div>
          </fieldset>
        </div>
        <div class="modal-footer modal-lg" style="background-color: #22262E;">
          <button type="submit" class="btn btn-primary" id="btnSaveUpdIndCron" value="<?php echo $id_ind;?>">SALVAR</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function () {
    $('#recUpdIndCron').modal('show');
  });
</script>