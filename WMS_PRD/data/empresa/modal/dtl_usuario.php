<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_usuario = mysqli_real_escape_string($link, $_POST["dtl_usuario"]);

$sql = "select * from tb_cliente where fl_tipo = 'U' and cod_cli is null and cod_cliente = '$id_usuario'"; 
$res = mysqli_query($link,$sql); 

while ($dados = mysqli_fetch_array($res)) {
   $nm_cliente=$dados['nm_cliente'];
   $nr_cnpj_cpf=$dados['nr_cnpj_cpf'];
   $ds_ie_rg=$dados['ds_ie_rg'];
   $ds_endereco=$dados['ds_endereco'];
   $ds_bairro=$dados['ds_bairro'];
   $ds_cidade=$dados['ds_cidade'];
   $ds_uf=$dados['ds_uf'];
   $nr_telefone=$dados['nr_telefone'];
   $ds_cep=$dados['ds_cep'];
   $fl_status=$dados['fl_status'];
   $ds_numero=$dados['ds_numero'];
   $ds_complemento=$dados['ds_complemento'];
   $ds_email=$dados['ds_email'];
   $fl_status=$dados['fl_status'];
   $fl_nivel=$dados['fl_nivel'];
   $nm_dpto=$dados['nm_dpto'];
   $nm_cargo=$dados['nm_cargo'];
   $nm_usuario=$dados['nm_usuario'];

}
$link->close();
?>

<div class="modal fade" id="detalhe_usuario" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" id="" style="color: white"><?php echo $dados['nm_cliente']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-lg" style="overflow-y: auto">
                    <div class="form-group">
                        <label class="col-sm-2" for="u_nome">Nome completo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control"  value="<?php echo $nm_cliente; ?>" id="u_nome" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="cpf">CPF</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  value="<?php echo $nr_cnpj_cpf; ?>" id="cpf" readonly>
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-2 control-label" for="rg">RG</label>
                        <div class="col-sm-4">
                           <input type="text" class="form-control"  value="<?php echo $ds_ie_rg; ?>" id="rg" readonly>
                           <div class="form-control-focus"> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="login">Login</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  value="<?php echo $nm_usuario; ?>" id="login" readonly>
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-2 control-label" for="departamento">Departamento</label>
                        <div class="col-sm-4">
                           <input type="text" class="form-control"  value="<?php echo $nm_dpto; ?>" id="departamento" readonly>
                           <div class="form-control-focus"> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="cargo">Cargo</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  value="<?php echo $nm_cargo; ?>" id="cargo" readonly>
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-2 control-label" for="email">E-mail</label>
                        <div class="col-sm-4">
                           <input type="text" class="form-control"  value="<?php echo $ds_email; ?>" id="email" readonly>
                           <div class="form-control-focus"> </div>
                       </div>
                     </div>
                   <div class="form-group">
                        <label class="col-sm-2" for="endereco">Rua / número</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control"  value="<?php echo $ds_endereco; ?>" id="endereco" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="bairro">Bairro</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  value="<?php echo $ds_bairro; ?>" id="bairro" readonly>
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-2 control-label" for="cep">CEP</label>
                        <div class="col-sm-4">
                           <input type="text" class="form-control"  value="<?php echo $ds_cep; ?>" id="cep" readonly
                           <div class="form-control-focus"> </div>
                       </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="cidade">Cidade</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  value="<?php echo $ds_cidade; ?>" id="cidade" readonly>
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-2 control-label" for="uf">UF</label>
                        <div class="col-sm-4">
                           <input type="text" class="form-control"  value="<?php echo $ds_uf; ?>" id="uf" readonly>
                           <div class="form-control-focus"> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="telefone">Telefone</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  value="<?php echo $nr_telefone; ?>" id="telefone" readonly>
                            <div class="form-control-focus"> </div>
                        </div>
                        <label class="col-sm-2 control-label" for="armazem">Armazém</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="armazem" readonly>
                            <div class="form-control-focus"> </div>
                        </div>
                    </div>
                    <div class="form-group">
            <label class="col-sm-2 control-label" for="status">Ativo</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $fl_status; ?>" id="fl-status" readonly="true">
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="status">Nível</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $fl_nivel; ?>" id="fl_nivel" readonly="true">
                <div class="form-control-focus"> </div>
            </div>
        </div>
       </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Alterar</button>
      </div>
  </div>
  </div>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#detalhe_usuario').modal('show');
    });
</script>