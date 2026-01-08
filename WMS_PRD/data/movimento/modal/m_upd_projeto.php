<?php
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
 
$cod_estoque = mysqli_real_escape_string($link, $_POST["cod_estoque"]);

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$select_projeto = "select t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.ds_projeto, t2.ds_apelido
from tb_posicao_pallet t1
left join tb_armazem t2 on t1.ds_galpao = t2.id
where t1.cod_estoque = '$cod_estoque'";
$res_projeto = mysqli_query($link,$select_projeto);
while ($dados=mysqli_fetch_assoc($res_projeto)) {
  $ds_projeto=$dados['ds_projeto'];
  $ds_apelido=$dados['ds_apelido'];
  $ds_prateleira=$dados['ds_prateleira'];
  $ds_coluna=$dados['ds_coluna'];
  $ds_altura=$dados['ds_altura'];
}
$link->close();
?>
<div class="modal fade" id="upd_projeto" aria-hidden="true">
 <form method="post" action="" id="">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Alterar projeto alocado</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="codigo">Projeto</label>
            <div class="col-sm-6">
              <input type="text" class="form-control"  align="center" id="ds_projeto" name="ds_projeto" value="<?php echo $ds_apelido.$ds_prateleira.$ds_coluna.$ds_altura.' - '.$ds_projeto; ?>" readonly="true">
              <div class="form-control-focus"> </div>
            </div>
          </div>
        </fieldset><hr>
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="codigo">Novo projeto</label>
            <div class="col-sm-6">
              <input type="text" class="form-control"  align="center" id="new_project" name="new_project" required="true">
              <input type="hidden" class="form-control"  align="center" id="cod_estoque_proj" name="cod_estoque_proj" value="<?php echo $cod_estoque;?>">
              <div class="form-control-focus"> </div>
            </div>
          </div>
        </fieldset>
          </div>
        <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="submit" class="btn btn-primary" id="btnSaveNewProject">Salvar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
 </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#upd_projeto').modal('show');
    });
</script>