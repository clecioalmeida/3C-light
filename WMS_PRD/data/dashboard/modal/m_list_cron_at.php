<?php 

$ds_ind = $_POST['ds_ind'];

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
              <th>PEDIDOS ATENDIDOS</th>
              <th>PEDIDOS EMERGENCIAIS</th>
              <th>%</th>
              <th>AÇÕES</th>
            </tr>
            <tbody id="listTbCronAt">
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
    var ds_ind = '<?php echo $ds_ind;?>';
    $('#listTbCronAt').load('data/dashboard/modal/list_tb_cron_at.php?search=',{ds_ind:ds_ind});
  });
</script>