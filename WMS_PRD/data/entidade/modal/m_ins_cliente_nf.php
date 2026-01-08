<div class="modal fade" id="novo_cliente_nf" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
   <form class="form-horizontal" method="post" action="" id="formCadClienteNf">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E;">
        <h5 class="modal-title" id="novo" style="color: white">Incluir Clientes</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <div class="form-body">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="form_control_cnpj">CNPJ</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="nr_cnpj_cpf_emit" id="nr_cnpj_cpf_emit" placeholder="CNPJ">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-md-1 control-label" for="form_control_cnpj">IE</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="ds_ie_rg" id="ds_ie_rg" placeholder="ID">
                        <div class="form-control-focus"> </div>
                    </div>
                    <label class="col-md-1 control-label" for="form_control_ie">UF</label>
                    <div class="col-md-2">
                        <div class="input-group input-group-md">
                            <input type="text" class="form-control" name="ds_uf_emit" id="ds_uf_emit" placeholder="UF">
                            <span class="input-group-btn">
                                <button class="btn btn-info" type="button" id="btnConsEmitNfCnpj"><span class="fa fa-search"></span></button>
                            </span>
                        </div>
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_razao_social">Razão Social</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="nm_cliente" id="nm_cliente" placeholder="Razão Social" required>
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_apelido">Apelido</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nm_fantasia" id="nm_fantasia" placeholder="Apelido">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_end">Endereço</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="ds_endereco" id="ds_endereco" placeholder="Endereço">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-1 control-label" for="form_control_end">Número</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="nr_numero" id="nr_numero" placeholder="Número">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_bairro">Complemento</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_complemento" id="ds_complemento" placeholder="Complemento">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2 control-label" for="form_control_bairro">Bairro</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_bairro" id="ds_bairro" placeholder="Bairro">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_cidade">Cidade</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_cidade" id="ds_cidade" placeholder="Cidade">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2 control-label" for="form_control_uf">CEP</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_cep" id="ds_cep" placeholder="CEP">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_cep">UF</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_uf" id="ds_uf" placeholder="UF">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2 control-label" for="form_control_telefone">Telefone</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nr_telefone" id="nr_telefone" placeholder="Telefone">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_email">E-mail</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="ds_email" id="ds_email" placeholder="E-mail">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2 control-label" for="form_control_contato">Contato</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="nm_contato" id="nm_contato" placeholder="Contato">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="form_control_obs">Observação</label>
                <div class="col-md-10">
                    <textarea class="form-control" id="ds_obs" name="ds_obs" placeholder="Observação"></textarea>
                    <div class="form-control-focus"> </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer" style="background-color: #22262E;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary" id="btnCadClienteNf">Incluir</button>
      </div>
     </div>
    </form>
  </div>
 </div><!--Fim modal-->
 <script>
    $(document).ready(function () {
        $('#novo_cliente_nf').modal('show');
        $("#nr_cnpj_cpf").mask("99.999.999/9999-99");
        //$("#ds_ie_rg").mask("999.999.999.999");
        $("#nr_telefone").mask("(99)9999-9999");
    });
</script>