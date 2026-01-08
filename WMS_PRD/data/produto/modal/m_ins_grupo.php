<div class="modal fade" id="novo_grupo" aria-hidden="true">
 <form method="post" action="" id="formNovoGrupo">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" id="novo_grupo" style="color: white">Incluir grupos</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="nm_grupo">Descrição</label>
            <input type="text" class="form-control" name="nm_grupo" id="nm_grupo">
        </div>
       </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="submit" class="btn btn-primary" id="btnFormNovoGrupo">Salvar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
  </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#novo_grupo').modal('show');
    });
</script>