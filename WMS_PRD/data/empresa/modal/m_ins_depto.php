<div class="modal fade" id="novo_departamento" aria-hidden="true">
 <form method="POST" action="" id="formCadDepto">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" id="novo_departamento" style="color: white">Incluir departamento</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="or">Descrição</label>
            <input type="text" class="form-control" name="nm_dpto" id="or">
        </div>
      </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary" id="btnCadDepto">Salvar</button>
      </div>
    </div>
  </div>
  </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#novo_departamento').modal('show');
    });
</script>