<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_aval = mysqli_real_escape_string($link, $_POST["upd_aval"]);

$sql_aval = "select * from tb_avaliacao where id = '$id_aval'"; 
$res_aval = mysqli_query($link,$sql_aval); 

while ($dados = mysqli_fetch_assoc($res_aval)) {
   $id=$dados['id'];
   $nm_avaliacao=$dados['nm_avaliacao'];
   $nr_valor=$dados['nr_valor'];
}  

$link->close();
?>
<div class="modal fade" id="alterar_aval" aria-hidden="true">
    <form method="post" action="" id="formUpdAval">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" id="alterar_grupo" style="color: white">Alterar avaliação</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id">Código da avaliação</label>
                        <input type="text" class="form-control" name="id" value="<?php echo $id; ?>" id="id">
                    </div>
                    <div class="form-group">
                        <label for="nm_avaliacao">Descrição</label>
                        <input type="text" class="form-control" name="nm_avaliacao" value="<?php echo $nm_avaliacao; ?>" id="nm_avaliacao">
                    </div>
                    <div class="form-group">
                        <label for="nm_avaliacao">Valor</label>
                        <input type="text" class="form-control" name="nr_valor" value="<?php echo $nr_valor; ?>" id="nr_valor">
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #2F4F4F;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" id="btnFormUpdAval">
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
        $('#alterar_aval').modal('show');
    });
</script>