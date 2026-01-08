<div class="modal fade" id="novo_funcionario" aria-hidden="true">
 <form method="post" action="" id="formInsFuncionario">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E;">
        <h5 class="modal-title" style="color: white">NOVO FUNCIONARIO</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">                
        <div class="portlet-body">
          <div class="row">
            <div class="form-group">
              <label class="col-sm-2 control-label" for="ds_nome">NOME</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="ds_nome" name="ds_nome">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </div><br />
          <div class="row">
            <div class="form-group">
              <label class="col-sm-2 control-label" for="nr_matricula">MATRÍCULA</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="nr_matricula" name="nr_matricula" value="">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="cod_depto">CR</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="cod_depto" name="cod_depto" value="">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </div><br />
        </div>
      </div>
      <div class="modal-footer" style="background-color: #22262E;">
        <button type="submit" class="btn btn-primary" id="btnSaveFuncionario">Salvar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseRegPrt">Fechar</button>
      </div>
    </div>
  </div>
</form>
</div><!--Fim modal-->
<script>
  $(document).ready(function () {
    $('#novo_funcionario').modal('show');
  });
</script>