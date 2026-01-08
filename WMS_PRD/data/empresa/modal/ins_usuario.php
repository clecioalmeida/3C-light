<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_cargo = "select * from tb_cargo";
$select_cargo = mysqli_query($link, $sql_cargo);

$sql_dpto = "select * from tb_dpto";
$select_dpto = mysqli_query($link, $sql_dpto);

$link->close();
?>
<div class="modal fade" id="novo_usuario" aria-hidden="true">
<form class="form-horizontal" method="post" action="" id="formCadUsuario">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" id="novo_usuario" style="color: white">Incluir usuario</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
       
        <div class="form-group">
            <label class="col-sm-2" for="u_nome">Nome completo</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="u_nome" name="nm_cliente">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="cpf">CPF</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="form_mask_cpf" name="nr_cnpj_cpf">
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="rg">RG</label>
            <div class="col-sm-4">
                 <input type="text" class="form-control" id="rg" name="ds_ie_rg">
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="login">Login</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="login" name="nm_usuario">
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="departamento">Departamento</label>
            <div class="col-sm-4">
                <select class="form-control" id="nm_dpto" name="nm_dpto">
                 <?php 
                    while($row_select_dpto = mysqli_fetch_assoc($select_dpto)) {?>
                    <option value="<?php echo $row_select_dpto['cod_dpto']; ?>">
                            <?php echo $row_select_dpto['nm_dpto']; ?>
                    </option> <?php 
                    } ?>
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="cargo">Cargo</label>
            <div class="col-sm-4">
                 <select class="form-control" id="nm_cargo" name="nm_cargo">
                    <option>Selecione o cargo</option>
                    <?php 
                    while($row_select_cargo = mysqli_fetch_assoc($select_cargo)) {?>
                    <option value="<?php echo $row_select_cargo['cod_cargo']; ?>">
                            <?php echo $row_select_cargo['nm_cargo']; ?>
                    </option> <?php 
                    } ?>
                </select>
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="email">E-mail</label>
            <div class="col-sm-4">
                 <input type="E-mail" class="form-control" id="email" name="ds_email">
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2" for="endereco">Rua / número</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="endereco" name="ds_endereco">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="bairro">Bairro</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="bairro" name="ds_bairro">
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="cep">CEP</label>
            <div class="col-sm-4">
                 <input type="text" class="form-control" id="form_mask_cep" name="ds_cep">
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="cidade">Cidade</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="cidade" name="ds_cidade">
                <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="uf">UF</label>
            <div class="col-sm-4">
                 <input type="text" class="form-control" id="uf" name="ds_uf">
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="telefone">Telefone</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="form_mask_fone" name="nr_telefone">
                <div class="form-control-focus"> </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="nivel">Nível</label>
            <div class="col-sm-4">
                <select class="form-control" id="fl_nivel" name="fl_nivel">
                    <option value="1">Consulta</option>
                    <option value="2">Operação</option>
                    <option value="3">Supervisão</option>
                    <option value="4">Coordenação</option>
                    <option value="5">Gerência</option>
                </select>
                <div class="form-control-focus"> </div>
            </div>
        </div>
       </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary" id="btnCadUsuario">Incluir</button>
      </div>
  </div>
  </div>
  </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#novo_usuario').modal('show');
    });
</script>