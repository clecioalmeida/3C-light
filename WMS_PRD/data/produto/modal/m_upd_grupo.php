<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_grupo = mysqli_real_escape_string($link, $_POST["upd_grupo"]);

$sql_grupo = "select * from tb_grupo where cod_grupo = '$id_grupo'"; 
$res_grupo = mysqli_query($link,$sql_grupo); 

while ($dados = mysqli_fetch_assoc($res_grupo)) {
   $cod_grupo=$dados['cod_grupo'];
   $nm_grupo=$dados['nm_grupo'];
}  

$link->close();
?>
<div class="modal fade" id="alterar_grupo" aria-hidden="true">
    <form method="post" action="" id="formUpdGrupo">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" style="color: white">Alterar grupos</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cod_grupo">Código do grupo</label>
                        <input type="text" class="form-control" name="cod_grupo" value="<?php echo $cod_grupo; ?>" id="cod_grupo">
                    </div>
                    <div class="form-group">
                        <label for="nm_grupo">Descrição</label>
                        <input type="text" class="form-control" name="nm_grupo" value="<?php echo $nm_grupo; ?>" id="nm_grupo">
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #2F4F4F;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                     <button type="submit" class="btn btn-primary" id="btnFormUpdGrupo">
                        <span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span>
                            Salvar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $('#alterar_grupo').modal('show');
    });
</script>