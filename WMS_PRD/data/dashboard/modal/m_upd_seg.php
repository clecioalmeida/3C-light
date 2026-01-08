 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $id_ind = $_POST['id_ind'];

 $query_prod="select id, ds_data, qtd_ipal_prev, qtd_ipal_exe, nr_irreg_seg, nr_acd_fat 
 from tb_fc_seg 
 where id  = '$id_ind'";
 $res_prod = mysqli_query($link,$query_prod);
 while ($dados=mysqli_fetch_assoc($res_prod)) {
  $ds_data        = $dados['ds_data'];
  $qtd_ipal_prev  = $dados['qtd_ipal_prev'];
  $qtd_ipal_exe   = $dados['qtd_ipal_exe'];
  $nr_irreg_seg   = $dados['nr_irreg_seg'];
  $nr_acd_fat     = $dados['nr_acd_fat'];
}

$pieces = explode("-", $ds_data);
$ds_mes = $pieces[0];
$ds_ano = $pieces[1];

$link->close();
?>
<div class="modal fade" id="recUpdSeg" aria-hidden="true">
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
                <input type="text" class="form-control" id="ds_mes" placeholder="Mês (mm)" value="<?php echo $ds_mes;?>" required="true">
              </div>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="ds_ano" placeholder="Ano (aaaa)" value="<?php echo $ds_ano;?>" required="true">
              </div>
            </div>
          </section>
        </fieldset>
        <hr>
        <fieldset>
          <section>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="nm_produto">QTDE IPAL PREVISTO</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="qtd_ipal_prev" value="<?php echo $qtd_ipal_prev;?>" style="text-align: right;" required="true">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </section>
          <section>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="nm_produto">QTDE IPAL EXECUTADAS</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="qtd_ipal_exe" value="<?php echo $qtd_ipal_exe;?>" style="text-align: right;"  required="true">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </section>
        </fieldset>
        <fieldset>
          <section>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="nm_produto">QTDE IRREGULARIDADES</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="nr_irreg_seg" value="<?php echo $nr_irreg_seg;?>" style="text-align: right;"  required="true">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </section>
          <section>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="nm_produto">QTDE ACIDENTES FATAIS</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="nr_acd_fat" value="<?php echo $nr_acd_fat;?>" style="text-align: right;">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </section>            
        </fieldset>
      </div>
      <div class="modal-footer modal-lg" style="background-color: #22262E;">
        <button type="submit" class="btn btn-primary" id="btnSaveUpdSeg" value="<?php echo $id_ind;?>">SALVAR</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
      </div>
    </div>
  </div>
</form>
</div>
<script>
  $(document).ready(function () {
    $('#recUpdSeg').modal('show');
  });
</script>