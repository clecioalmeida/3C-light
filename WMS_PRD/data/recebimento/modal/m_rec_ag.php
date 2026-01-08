 <?php 
 require_once('bd_class.php');
 $objDb = new db();
 $link = $objDb->conecta_mysql();

 $upd_rec = $_POST['upd_rec'];

 $query_prod="select t1.nm_fornecedor, t1.cod_recebimento, t2.id as id_janela, t2.dt_janela, t2.ds_janela 
 from tb_recebimento_ag t1
 left join tb_janela t2 on t1.cod_recebimento = t2.cod_rec
  where t1.cod_recebimento = '$upd_rec'";
 $res_prod = mysqli_query($link,$query_prod);
 while ($dados=mysqli_fetch_assoc($res_prod)) {
  $nm_fornecedor    = $dados['nm_fornecedor'];
  $cod_recebimento  = $dados['cod_recebimento'];
  $dt_janela        = $dados['dt_janela'];
  $ds_janela        = $dados['ds_janela'];
  $id_janela        = $dados['id_janela'];
}

$link->close();
?>
<div class="modal fade" id="recAg" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E;">
        <h5 class="modal-title" style="color: white">RECUSAR AGENDAMENTO</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">

        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="produto">COD. AGENDAMENTO</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" value="<?php echo $cod_recebimento;?>" name="cod_recebimento" id="cod_recebimento" readonly="true">
              <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="nm_fornecedor">FORNECEDOR</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" value="<?php echo $nm_fornecedor;?>" name="nm_fornecedor" id="cod_prod_cliente" readonly="true">
              <div class="form-control-focus"> </div>
            </div>
          </fieldset>
          <fieldset>
            <label class="col-sm-2 control-label" for="nm_produto">MOTIVO</label>
            <div class="col-sm-10">
              <textarea type="text" class="form-control" id="ds_motivo" rows="5"></textarea>
              <div class="form-control-focus"> </div>
            </div>
          </div>
          <div class="modal-footer modal-lg" style="background-color: #22262E;">
            <button type="submit" class="btn btn-primary" id="btnSaveRecAg" data-jan="<?php echo $id_janela; ?>" value="<?php echo $upd_rec;?>">RECUSAR</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <script>
    $(document).ready(function () {
      $('#recAg').modal('show');
    });
  </script>