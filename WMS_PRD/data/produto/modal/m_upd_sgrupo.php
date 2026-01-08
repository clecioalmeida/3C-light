<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_sgrupo = mysqli_real_escape_string($link, $_POST["upd_sgrupo"]);

$sql_grupo = "select * from tb_sub_grupo where cod_sub_grupo = '$id_sgrupo'"; 
$res_grupo = mysqli_query($link,$sql_grupo); 

$SQL = "select * from tb_grupo"; 
$res = mysqli_query($link,$SQL);

while ($dados = mysqli_fetch_assoc($res_grupo)) {
   $cod_sub_grupo=$dados['cod_sub_grupo'];
   $nm_sub_grupo=$dados['nm_sub_grupo'];
}  

$link->close();
?>
<div class="modal fade" id="alterar_subgrupo" aria-hidden="true">
  <form method="post" action="" id="formUpdSgrupo">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #2F4F4F;">
          <h5 class="modal-title" id="alterar_subgrupo" style="color: white">Alterar sub-grupo</h5>
            <button type="button" class="close" data-dismiss="modal">
              <span>&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="subgrupo">Código do sub-grupo</label>
            <input type="text" class="form-control" name="cod_sub_grupo" value="<?php echo $cod_sub_grupo; ?>" id="cod_sub_grupo" readonly="true">
          </div>
          <div class="form-group">
            <label for="desc">Grupo</label>
            <select class="form-group" name="cod_grupo">
              <option>Selecione</option>
                <?php                                                           
                while($row_select_grupo = mysqli_fetch_assoc($res)) {?>
              <option value="<?php echo $row_select_grupo['cod_grupo']; ?>">
                <?php echo $row_select_grupo['nm_grupo']; ?>
              </option> <?php } ?>
            </select>
            <div class="form-control-focus"> </div>
          <div class="form-group">
            <label for="desc">Descrição</label>
            <input type="text" class="form-control" name="nm_sub_grupo" value="<?php echo $nm_sub_grupo; ?>" id="nm_sub_grupo">
          </div>
        </div>
        <div class="modal-footer" style="background-color: #2F4F4F;">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary" id="btnFormUpdSgrupo">Salvar</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function () {
    $('#alterar_subgrupo').modal('show');
  });
</script>