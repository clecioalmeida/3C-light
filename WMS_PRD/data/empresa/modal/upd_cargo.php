<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_cargo = mysqli_real_escape_string($link, $_POST["dtl_cargo"]);

$sql = "select * from tb_cargo where fl_status = 1 and cod_cargo = '$id_cargo'"; 
$res = mysqli_query($link,$sql); 

while ($dados = mysqli_fetch_array($res)) {
   $cod_cargo=$dados['cod_cargo'];
   $nm_cargo=$dados['nm_cargo'];
   $fl_status=$dados['fl_status'];
}
$link->close();
?>

<div class="modal fade" id="alterar_cargo" aria-hidden="true">
    <form method="post" action="../html/includes/forms/empresas/xhr/proc_update_cargo.php">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" id="detalhe_cargo<?php echo $dados['cod_cargo']; ?>" style="color: white"><?php echo $dados['nm_cargo']; ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cod_cargo">Código</label>
                        <input type="text" class="form-control"  value="<?php echo $dados['cod_cargo']; ?>" name="cod_cargo" id="cod_cargo">
                    </div>
                    <div class="form-group">
                        <label for="nm_cargo">Descrição</label>
                        <input type="text" class="form-control"  value="<?php echo $dados['nm_cargo']; ?>" name="nm_cargo" id="nm_cargo">
                    </div>
                    <div class="form-group">
                        <label for="data_inicial">Status</label>
                        <input type="text" class="form-control" id="data_inicial">
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #2F4F4F;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Alterar</button>
                </div>
            </div>
        </div>
    </form>
 </div><!--Fim modal--> 
<script>
    $(document).ready(function () {
        $('#alterar_cargo').modal('show');
    });
</script>