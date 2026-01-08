<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_depto = mysqli_real_escape_string($link, $_POST["upd_depto"]);

$sql = "select * from tb_dpto where fl_status = 1 and cod_dpto = '$id_depto'"; 
$res = mysqli_query($link,$sql); 
while ($dados = mysqli_fetch_array($res)) {
   $cod_dpto=$dados['cod_dpto'];
   $nm_dpto=$dados['nm_dpto'];
}
$link->close();
?>
<div class="modal fade" id="alterar_departamento" aria-hidden="true">
    <form method="post" action="" id="formUpdDepto">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" id="detalhe_departamento<?php echo $cod_dpto; ?>" style="color: white"><?php echo $nm_dpto; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
	            <div class="modal-body">
	                <div class="form-group">
	                    <label for="cod_dpto">Código</label>
	                    <input type="text" class="form-control"  value="<?php echo $cod_dpto; ?>" name="cod_dpto" id="cod_dpto">
	                </div>
	                <div class="form-group">
	                    <label for="nm_dpto">Descrição</label>
	                    <input type="text" class="form-control"  value="<?php echo $nm_dpto; ?>" name="nm_dpto" id="nm_dpto">
	                </div>
	            </div>
	            <div class="modal-footer" style="background-color: #2F4F4F;">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	                <button type="submit" class="btn btn-primary" id="SubUpdDepto">Alterar</button>
	            </div>
        	</div>
        </div>
    </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#alterar_departamento').modal('show');
    });
</script>