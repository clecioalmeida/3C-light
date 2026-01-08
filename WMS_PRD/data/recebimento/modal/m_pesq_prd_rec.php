<div class="modal fade" id="updEnd" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Pesquisar produtos</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <fieldset>
          <form method="post" class="form-inline" action="" id="formPesqProdRec">
            <input type="text" class="form-control" id="n_cod_produto" name="new_cod_produto" placeholder="Código" style="width: 200px">
            <input type="text" class="form-control" id="n_cod_prod_cliente" name="new_cod_prod_cliente" placeholder="Código SAP" style="width: 200px">
            <input type="text" class="form-control" id="n_nm_produto" name="new_nm_produto" placeholder="Descrição do produto" style="width: 200px">
            <button type="submit" class="btn btn-success" id="btnFormPesqProdName" style="float: right;width: 80px">Pesquisar</button><br /><br />
          </form>
        </fieldset>
        <fieldset>
          <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
              <tr>
                <th>Código</th>
                <th>Cod. SAP </th>
                <th>Descrição</th>
                <th>#</th>
            </thead>
            <tbody id="retPesProdName">
            </tbody>
          </table>
          <h2 id="retPesqPrd" style="text-align: center;background-color: #A52A2A;color: white"></h2>
        </fieldset>
      </div>
      <div class="modal-footer modal-lg" style="background-color: #2F4F4F;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
  </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#updEnd').modal('show');
    });
</script>