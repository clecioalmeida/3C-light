<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_task = mysqli_real_escape_string($link, $_POST["id_task"]);

$sql = "select * from tb_task_user where id = '$id_task'"; 
$res = mysqli_query($link,$sql); 
while ($dados = mysqli_fetch_array($res)) {
   $ds_task=$dados['ds_task'];
   $ds_acao=$dados['ds_acao'];
   $dt_limite=$dados['dt_limite'];
}
$link->close();
?>
<div class="modal fade" id="upd_task" aria-hidden="true">
    <form method="post" action="" id="formUpdTask">
        <input type="hidden" name="id_task" name="id_task" value="<?php echo $id_task; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: #2F4F4F;">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: white">Tarefa: <?php echo $id_task; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
	            <div class="modal-body">
	                <div class="form-group">
	                    <label for="cod_dpto">Tarefa</label>
	                    <textarea rows="5" type="text" class="form-control" name="ds_task" id="ds_task"><?php echo $ds_task; ?></textarea>
	                </div>
	                <div class="form-group">
	                    <label for="nm_dpto">Ação</label>
                        <textarea rows="5" type="text" class="form-control" name="ds_acao" id="ds_acao"><?php echo $ds_acao; ?></textarea>
	                </div>
                    <div class="form-group">
                        <label for="nm_dpto">Data de conclusão</label>
                        <input type="date" class="form-control" value="<?php echo $dt_limite; ?>" name="dt_limite" id="dt_limite">
                    </div>
	            </div>
	            <div class="modal-footer" style="background-color: #2F4F4F;">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	                <button type="submit" class="btn btn-primary" id="btnFormUpdTask">Alterar</button>
	            </div>
        	</div>
        </div>
    </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#upd_task').modal('show');
    });
</script>