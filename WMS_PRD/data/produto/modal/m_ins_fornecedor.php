<?php

$cod_prd     = $_POST['cod_prd'];

?>
<div class="modal fade" id="novo_destinatario" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
   <form class="form-horizontal"  method="post" action="" id="formCadDestinatario">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E;">
        <h5 class="modal-title" id="novo" style="color: white">CADASTRAR FORNECEDOR</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
            <div class="form-group">
                <label class="col-md-2" for="form_control_razao_social">Razão Social</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="nm_cliente" id="form_control_razao_social" placeholder="Razão Social" required>
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_cnpj">Código SAP</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="cod_sap" id="cod_sap" placeholder="Código SAP">
                    <input type="hidden" class="form-control" name="cod_prd" id="cod_prd" value="<?php echo $cod_prd;?>">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2" for="form_control_apelido">Apelido</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nm_fantasia" id="form_control_apelido" placeholder="Apelido">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group" style="display: none">
                <label class="col-md-2 control-label" for="form_control_cnpj">Login</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_login" id="ds_login" placeholder="Login">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2 control-label" for="form_control_ie">Senha</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_senha" id="ds_senha" placeholder="Senha">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_cnpj">CNPJ</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nr_cnpj_cpf" id="form_control_cnpj" placeholder="CNPJ">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2 control-label" for="form_control_ie">Inscrição Estadual</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_ie_rg" id="form_control_ie" placeholder="Inscrição Estadual">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_end">Endereço/Número</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="ds_endereco" id="form_control_end" placeholder="Endereço completo">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_bairro">Complemento</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_complemento" id="form_control_bairro" placeholder="Complemento">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2 control-label" for="form_control_bairro">Bairro</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_bairro" id="form_control_bairro" placeholder="Bairro">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_cidade">Cidade</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_cidade" id="form_control_cidade" placeholder="Cidade">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2 control-label" for="form_control_uf">CEP</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_cep" id="form_control_uf" placeholder="CEP">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_cep">UF</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_uf" id="form_control_cep" placeholder="UF">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2 control-label" for="form_control_telefone">Telefone</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nr_telefone" id="form_control_telefone" placeholder="Telefone">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_email">E-mail</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_email" id="form_control_email" placeholder="E-mail">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2 control-label" for="form_control_contato">Contato</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nm_contato" id="form_control_contato" placeholder="Contato">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <!--div class="form-group form-md-line-input">
                <label class="col-md-2 control-label" for="form_control_status">Status</label>
                <div class="col-md-10">
                    <input type="checkbox" value="1" id="form_control_status">Ativo
                    <div class="form-control-focus"> </div>
                </div>
            </div-->
            <div class="form-group">
                <!--label class="col-md-2 control-label" for="form_control_obs">Observação</label-->
                <div class="col-md-10">
                    <textarea class="form-control" id="form_control_obs" placeholder="Observação"></textarea>
                    <div class="form-control-focus"> </div>
                </div>
            </div>
      </div>
      <div class="modal-footer" style="background-color: #22262E;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
        <button type="submit" class="btn btn-primary" id="btnCadFornecedorReq">SALVAR</button>
      </div>
     </div>
    </form>
  </div>
 </div><!--Fim modal-->
 <script>
    $(document).ready(function () {
        $('#novo_destinatario').modal('show');
    });
</script>