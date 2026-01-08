<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$SQL = "select * from tb_grupo"; 
$res = mysqli_query($link,$SQL);
$link->close();
?>
<div class="modal fade" id="novo_subgrupo" aria-hidden="true">
 <form method="post" action="" id="formNovoSgrupo">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" id="novo_subgrupo" style="color: white">Incluir sub-grupos</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="cod_grupo">Grupo</label>
          <div class="col-sm-4">
            <select class="form-group" name="cod_grupo">
              <option>Selecione</option>
              <?php                                                           
              while($row_select_grupo = mysqli_fetch_assoc($res)) {?>
              <option value="<?php echo $row_select_grupo['cod_grupo']; ?>">
                <?php echo $row_select_grupo['nm_grupo']; ?>
              </option> <?php } ?>
            </select>
            <div class="form-control-focus"> </div>
          </div>
          <label class="col-sm-2 control-label" for="nm_sub_grupo">Sub-grupo</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" name="nm_sub_grupo" id="nm_sub_grupo">
            <div class="form-control-focus"> </div>
          </div> 
        </div>
      </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="submit" class="btn btn-primary" id="btnFormNovoSgrupo">Salvar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
  </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#novo_subgrupo').modal('show');
    });
</script>