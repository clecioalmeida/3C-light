<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_user = mysqli_real_escape_string($link, $_POST["id_user"]);

$sql = "select * from tb_cliente where cod_cliente = '$id_user'"; 
$res = mysqli_query($link,$sql); 
while ($dados = mysqli_fetch_array($res)) {
   $cod_cliente=$dados['cod_cliente'];
   $nm_cliente=$dados['nm_cliente'];
}
$link->close();
?>
<div class="modal fade" id="upd_senha" aria-hidden="true">
    <form method="post" action="" id="formUpdPass">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" style="color: white">Usuário: <?php echo $nm_cliente; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
	            <div class="modal-body">
	                <div class="form-group">
	                    <label for="cod_dpto">Código</label>
	                    <input type="text" class="form-control"  value="<?php echo $cod_cliente; ?>" name="cod_cliente" id="cod_cliente">
	                </div>
	                <div class="form-group">
	                    <label for="nm_dpto">Usuário</label>
	                    <input type="text" class="form-control"  value="<?php echo $nm_cliente; ?>" name="nm_cliente" id="nm_cliente" readonly="true">
	                </div>
                    <div class="form-group">
                        <label for="nm_dpto">Nova senha</label>
                        <input type="password" class="form-control" name="ds_senha1" id="ds_senha1">
                        <label for="nm_dpto">Repita a senha</label>
                        <input type="password" class="form-control" name="ds_senha2" id="ds_senha2">
                    </div>
	            </div>
	            <div class="modal-footer" style="background-color: #2F4F4F;">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	                <button type="submit" class="btn btn-primary" id="btnFormUpdPass">Alterar</button>
	            </div>
        	</div>
        </div>
    </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#upd_senha').modal('show');
    });
</script>