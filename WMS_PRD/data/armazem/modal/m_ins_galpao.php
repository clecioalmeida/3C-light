<div class="modal fade" id="novo_galpao" aria-hidden="true">
<form method="post" action="" role="form" id="formCadGalpao" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" id="novo_galpao" style="color: white">Incluir Galpão</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="portlet-body form">
          <div class="modal-body">
           <fieldset>
            <div class="form-group">
              <label class="col-md-2 control-label" for="galpao_nome">Nome</label>
              <div class="col-md-4">
                <input type="text" class="form-control" name="galpao" id="galpao_nome" placeholder="Nome">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-md-2 control-label" for="galpao_apelido">Apelido</label>
              <div class="col-md-4">
                <input type="text" class="form-control" id="galpao_apelido" placeholder="Apelido">
                <div class="form-control-focus"> </div>
              </div>
            </div>
           </fieldset>
           <fieldset>
            <div class="form-group">
              <label class="col-md-2 control-label" for="galpao_cidade">Cidade</label>
              <div class="col-md-4">
                <input type="text" class="form-control" name="g_cidade" id="galpao_cidade" placeholder="Cidade">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-md-2 control-label" for="galpao_uf">U.F.</label>
              <div class="col-md-4">
                <input type="text" class="form-control" name="g_uf" id="galpao_uf" placeholder="U.F.">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </fieldset>
          </div>
          <div class="modal-footer" style="background-color: #2F4F4F;">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <span aria-hidden="true"></span>Fechar
            </button>
            <button type="submit" class="btn btn-primary">
            <span class="glyphicon glyphicon glyphicon-floppy-disk" id="btnCadGalpao" aria-hidden="true"></span>
            Salvar</button>
          </div>
    </div>
    </div>
  </div>
  </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#novo_galpao').modal('show');
    });
</script>