<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_cliente = mysqli_real_escape_string($link, $_POST["dtl_cliente"]);

$SQL = "select * from tb_cliente where fl_tipo = 'C' and cod_cli is null and fl_status = 1 and cod_cliente = '$id_cliente'"; 
$res = mysqli_query($link,$SQL);


while ($dados = mysqli_fetch_array($res)) {
   $nm_cliente=$dados['nm_cliente'];
   $nm_fantasia=$dados['nm_fantasia'];
   $cod_cliente=$dados['cod_cliente'];
   $nr_cnpj_cpf=$dados['nr_cnpj_cpf'];
   $ds_ie_rg=$dados['ds_ie_rg'];
   $ds_endereco=$dados['ds_endereco'];
   $ds_complemento=$dados['ds_complemento'];
   $ds_bairro=$dados['ds_bairro'];
   $ds_cidade=$dados['ds_cidade'];
   $ds_uf=$dados['ds_uf'];
   $ds_cep=$dados['ds_cep'];
   $nr_telefone=$dados['nr_telefone'];
   $ds_email=$dados['ds_email'];
   $nm_contato=$dados['nm_contato'];
}
$link->close();
?>
<div class="modal fade" id="detalhe_cliente" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2F4F4F;">
                <h5 class="modal-title" id="detalhe_cliente" style="color: white"><?php echo $nm_cliente; ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body modal-lg" style="overflow-y: auto">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="form_control_razao_social">Razão Social</label>
                        <div class="col-md-10">
                            <input type="text"  value="<?php echo $nm_cliente ?>" class="form-control" id="form_control_razao_social" placeholder="Razão Social" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="form_control_apelido">Apelido</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="<?php echo $nm_fantasia; ?>" name="nm_fantasia" id="form_control_apelido" placeholder="Apelido" readonly="true">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-md-2 control-label" for="form_control_apelido" >Código</label>
                            <div class="col-md-4">
                                <input type="text" value="<?php echo $cod_cliente; ?>" class="form-control" name="alt_cod_cliente"  id="form_control_apelido" placeholder="Código" readonly="true">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="form_control_cnpj">CNPJ</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php echo $nr_cnpj_cpf; ?>" name="nr_cnpj_cpf" id="form_control_cnpj" placeholder="CNPJ" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-md-2 control-label" for="form_control_ie">Inscrição Estadual</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php echo $ds_ie_rg; ?>" name="ds_ie_rg" id="form_control_ie" placeholder="Inscrição Estadual" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="form_control_end">Endereço/Número</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" value="<?php echo $ds_endereco; ?>" name="ds_endereco" id="form_control_end" placeholder="Endereço completo" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="form_control_bairro">Complemento</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="ds_complemento" value="<?php echo $ds_complemento; ?>" id="form_control_bairro" placeholder="Complemento" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-md-2 control-label" for="form_control_bairro">Bairro</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php echo $ds_bairro; ?>" name="ds_bairro" id="form_control_bairro" placeholder="Bairro" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="form_control_cidade">Cidade</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php echo $ds_cidade; ?>" name="ds_cidade" id="form_control_cidade" placeholder="Cidade" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-md-2 control-label" for="form_control_uf">CEP</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php echo $ds_cep; ?>" name="ds_cep" id="form_control_uf" placeholder="CEP" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="form_control_cep">UF</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php echo $ds_uf; ?>" name="ds_uf" id="form_control_cep" placeholder="UF" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-md-2 control-label" for="form_control_telefone">Telefone</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php echo $nr_telefone; ?>" name="nr_telefone" id="form_control_telefone" placeholder="Telefone" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="form_control_email">E-mail</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php echo $ds_email; ?>" name="ds_email" id="form_control_email" placeholder="E-mail" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-md-2 control-label" for="form_control_contato">Contato</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="<?php echo $nm_contato; ?>" name="nm_contato" id="form_control_contato" placeholder="Contato" readonly="true">
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-10">
                            <textarea class="form-control" id="form_control_obs" placeholder="Observação"></textarea>
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #2F4F4F;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#detalhe_cliente').modal('show');
    });
</script>