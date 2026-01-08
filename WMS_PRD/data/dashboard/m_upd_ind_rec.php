 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

  $id_ind = $_POST['id_ind'];

  $sql_estado = "select id, estado from tb_estado_produto";
  $res_estado = mysqli_query($link,$sql_estado);

  $query_prod="select * from tb_fc_rec_sap where id = '$id_ind'";
  $res_prod = mysqli_query($link,$query_prod);
  while ($dados=mysqli_fetch_assoc($res_prod)) {
    $ds_data    = $dados['ds_data'];
    $nf_rec     = $dados['nf_rec'];
    $nf_rec_div = $dados['nf_rec_div'];
  }

  $pieces = explode("-", $ds_data);
  $ds_mes = $pieces[0];
  $ds_ano = $pieces[1];

 $link->close();
 ?>
 <div class="modal fade" id="recUpdIndDem" aria-hidden="true">
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
                <label class="col-sm-3 control-label" for="nm_produto">NOTAS FISCAIS RECEBIDAS</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="nf_rec" value="<?php echo $nf_rec;?>" required="true" style="text-align: right;">
                  <div class="form-control-focus"> </div>
                </div>
              </section>
            <section>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="nm_produto">NOTAS FISCAIS RECEBIDAS ACIMA DO PRAZO</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="nf_rec_div" value="<?php echo $nf_rec_div;?>" required="true" style="text-align: right;">
                  <div class="form-control-focus"> </div>
                </div>
              </section>
            </div>
          </fieldset>
        </div>
        <div class="modal-footer modal-lg" style="background-color: #22262E;">
          <button type="submit" class="btn btn-primary" id="btnSaveUpdIndRec" value="<?php echo $id_ind;?>">SALVAR</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function () {
    $('#recUpdIndDem').modal('show');
  });
</script>