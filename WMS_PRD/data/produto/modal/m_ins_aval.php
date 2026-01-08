<div class="modal fade" id="nova_avaliacao" aria-hidden="true">
 <form method="post" action="" id="formNovoAval">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Incluir avaliação</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="nm_avaliacao">Descrição</label>
            <input type="text" class="form-control" name="nm_avaliacao" id="nm_avaliacao">
        </div>
        <div class="form-group">
            <label for="nr_valor">Valor</label>
            <input type="text" class="form-control" name="nr_valor" id="nr_valor">
        </div>
       </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="submit" class="btn btn-primary" id="btnFormNovoAval">Salvar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
  </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#nova_avaliacao').modal('show');
    });
</script>