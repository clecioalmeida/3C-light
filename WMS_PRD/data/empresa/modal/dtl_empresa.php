<?php 
/*
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_empresa = mysqli_real_escape_string($link, $_POST["dtl_empresa"]);

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
*/
?>

<div class="modal fade" id="detalhe_empresa" aria-hidden="true">                  
    <form id="formCadastrarse">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" style="color: white"><?php echo $nm_empresa; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-lg" style="overflow-y: auto">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label" for="form_control_razao_social">Razão Social</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="nm_empresa" value="" id="form_control_razao_social" placeholder="Razão Social" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                            <label class="col-md-2 control-label" for="form_control_apelido">Código</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="cod_empresa" value="<?php echo $cod_empresa; ?>" id="form_control_apelido" placeholder="Código" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="form_control_cnpj">CNPJ</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="nr_cnpj" value="<?php echo $nr_cnpj; ?>" id="form_control_cnpj" placeholder="CNPJ" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-md-2 control-label" for="form_control_ie">Inscrição Estadual</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="ds_ie" value="<?php echo $ds_ie; ?>" id="form_control_ie" placeholder="Inscrição Estadual" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="form_control_end">Endereço</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="ds_endereco" value="<?php echo $ds_endereco; ?>" id="form_control_end" placeholder="Endereço completo" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-md-2 control-label" for="form_control_end">Número</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="ds_numero" value="<?php echo $ds_numero; ?>" id="form_control_end" placeholder="Endereço completo" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="form_control_bairro">Complemento</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="" value="#" id="form_control_bairro" placeholder="Complemento" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-md-2 control-label" for="form_control_bairro">Bairro</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="ds_bairro" value="<?php echo $ds_bairro; ?>" id="form_control_bairro" placeholder="Bairro" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="form_control_cidade">Cidade</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="ds_cidade" value="<?php echo $ds_cidade; ?>" id="form_control_cidade" placeholder="Cidade" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-md-2 control-label" for="form_control_uf">CEP</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="ds_cep" value="<?php echo $ds_cep; ?>" id="form_control_uf" placeholder="CEP" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="form_control_cep">UF</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="ds_uf" value="<?php echo $ds_uf; ?>" id="form_control_cep" placeholder="UF" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                                <label class="col-md-2 control-label" for="form_control_telefone">Telefone</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="ds_telefone" value="<?php echo $ds_telefone; ?>" id="form_control_telefone" placeholder="Telefone" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="form_control_email">E-mail</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>" id="form_control_email" placeholder="E-mail" readonly>
                                    <div class="form-control-focus"> </div>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="form_control_status">Status</label>
                                <div class="col-md-10">
                                    <input type="checkbox" value="1" id="form_control_status">Ativo
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </div>
                        <dir class="row">
                            <div class="form-group">
                                <!--label class="col-md-2 control-label" for="form_control_obs">Observação</label-->
                                <div class="col-md-10">
                                    <textarea class="form-control" id="form_control_obs" placeholder="Observação"></textarea>
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>
                        </dir>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #2F4F4F;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>            
        </div>
    </form>
</div><!--Fim modal-->
<!--script>
    $(document).ready(function () {
        $('#detalhe_empresa').modal('show');
    });
</script-->
<!--script>
    $(document).ready(function () {
        $('#detalhe_empresa').modal('show');
    });
</script-->