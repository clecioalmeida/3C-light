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
              <table id="RepIndCronExcel" class="table table-bordered" width="100%">
               <tr>
                <th>DATA</th>
                <th>SOLICITADOS</th>
                <th>ATENDIDOS</th>
                <th>%</th>
                <th>AÇÕES</th>
              </tr>
              <tbody id="listTbQtdAt">
              </tbody>
            </table>
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
    $('#listTbQtdAt').load('data/dashboard/modal/list_tb_qtd_at.php?search=',{id_ind:id_ind});
  });
</script>