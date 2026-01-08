 <?php 

 $id_ind = $_POST['id_ind'];

 ?>
 <div class="modal fade" id="recListIndRec" aria-hidden="true">
   <form method="post" action="" id="formNovoRec">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #22262E;">
          <h5 class="modal-title" style="color: white"></h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body modal-lg" style="overflow-y: auto">
          <fieldset>
            <section>
              <div class="table-responsive-sm">
                <table id="RepIndCronExcel" class="table" width="100%">
                  <thead>
                    <tr>
                      <th>DATA</th>
                      <th>TOTAL SKU'S ARMAZENADOS</th>
                      <th>TOTAL OCUPADAS</th>
                      <th>% OCUPAÇÃO</th>
                      <th>AÇÕES</th>
                    </tr>
                  </thead>
                  <tbody id="listTbOcpInt">
                  </tbody>
                </table>
              </div>
            </section>
          </fieldset>
        </div>
        <div class="modal-footer modal-lg" style="background-color: #22262E;">
          <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function () {
    $('#recListIndRec').modal('show');
    var id_ind = '<?php echo $id_ind;?>';
    $('#listTbOcpInt').load('data/dashboard/modal/list_tb_ocupa_int.php?search=',{id_ind:id_ind});
  });
</script>