<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_empresa = mysqli_real_escape_string($link, $_POST["upd_empresa"]);

$sql = "select * from tb_empresa where fl_status = 1 and cod_empresa = '$id_empresa'"; 
$res = mysqli_query($link,$sql); 

while ($dados = mysqli_fetch_array($res)) {
   $nm_empresa=$dados['nm_empresa'];
   $cod_empresa=$dados['cod_empresa'];
   $nr_cnpj=$dados['nr_cnpj'];
   $ds_ie=$dados['ds_ie'];
   $ds_endereco=$dados['ds_endereco'];
   $ds_numero=$dados['ds_numero'];
   $ds_bairro=$dados['ds_bairro'];
   $ds_cidade=$dados['ds_cidade'];
   $ds_cep=$dados['ds_cep'];
   $ds_uf=$dados['ds_uf'];
   $ds_telefone=$dados['ds_telefone'];
   $email=$dados['email'];
}
$link->close();
?>
<div class="modal fade" id="inativar_empresa<?php echo $dados['cod_empresa']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" style="color: white">Inativar registro</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto">
                    <form method="post" action="../html/includes/forms/empresas/xhr/int_empresa.php" id="formCadastrarse">
                        <div class="form-body">
                            <div class="form-group">
                                <h5 class="modal-title">Você está inativando o registro <?php echo $dados['cod_empresa']; ?>?</h5>
                                <input type="text" class="form-control" name="cod_empresa" value="<?php echo $dados['cod_empresa']; ?>" id="form_control_contato">
                            </div>
                            <div>
                                <div class="modal-footer" style="background-color: #2F4F4F;">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                                    <button type="submit" class="btn btn-primary">Sim</button>
                                </div>        
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!--Fim modal-->