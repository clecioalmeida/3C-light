 <?php 

 $ds_mes = $_POST['ds_mes'];

 ?>
 <div class="modal fade" id="recListIndDestVeic" aria-hidden="true">
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
                <th>DESTINOS</th>
                <th>QTDE SPOT</th>
                <th>QTDE NORMAL</th>
                <th>% TOTAL</th>
              </tr>
              <tbody id="listTbDestVeic">
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
    $('#recListIndDestVeic').modal('show');
    var ds_mes = '<?php echo $ds_mes;?>';
    $('#listTbDestVeic').load('data/dashboard/modal/list_tb_dest_veic.php?search=',{ds_mes:ds_mes});
  });
</script>