<div class="modal fade" id="novo_cargo" aria-hidden="true">
<form method="POST" action="" id="formCadCargo">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" id="novo_cargo" style="color: white">Incluir cargo</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="nm_cargo">Descrição</label>
            <input type="text" class="form-control" name="nm_cargo" id="nm_cargo">
        </div>
      </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary" id="btnCadCargo">Incluir</button>
      </div>
    </div>
  </div>
  </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#novo_cargo').modal('show');
    });
</script>