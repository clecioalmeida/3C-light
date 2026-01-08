 <?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$id_tar = $_POST['id_tar'];

$link->close();
?>
 <div class="modal" id="mDelTarefa" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #FFA07A">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      	<h5>Confirma exclusão da tarefa <?php echo $id_tar ;?>?</h5>
      </div>
      <div class="modal-body">
      	<button type="submit" id="btnDelTarefaConf" class="btn btn-primary" value="<?php echo $id_tar ;?>">Sim</button>
      	<button type="submit" class="btn btn-default" data-dismiss="modal" value="">Não</button>
      </div>
      <div class="modal-footer" style="background-color: #FFA07A">
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function () {
        $('#mDelTarefa').modal('show');
    });
</script>