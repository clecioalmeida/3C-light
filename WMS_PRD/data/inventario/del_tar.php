 <?php
//Incluir a conexão com banco de dados
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$id_tar = $_POST['id_tar'];

$upd="update tb_inv_tarefa set fl_status = 'E' where id = '$id_tar'";
$res_upd=mysqli_query($link, $upd);

$link->close();
?>
 <div class="modal" id="mDelTarefaConf" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #98FB98; text-align: center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      	<h5>Atenção</h5>
      </div>
      <div class="modal-body">
      	<p>Tarefa <?php echo $id_tar;?> excluída com sucesso!</p>
      </div>
      <div class="modal-footer" style="background-color: #98FB98;">
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function () {
        $('#mDelTarefaConf').modal('show');
    });