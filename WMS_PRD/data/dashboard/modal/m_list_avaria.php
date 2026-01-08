 <?php 

 $ds_mes = $_POST['ds_mes'];

 ?>
 <div class="modal fade" id="recListIndAv" aria-hidden="true">
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
                <table id="RepIndCronExcel" class="table table-bordered" width="100%" style="font-size: 10px">
                  <thead>
                    <tr>
                      <th>DATA</th>
                      <th>3C SERVICES (SKU)</th>
                      <th>3C SERVICES (VALOR)</th>
                      <th>FORNECEDOR (SKU)</th>
                      <th>FORNECEDOR (VALOR)</th>
                      <th>EDP (SKU)</th>
                      <th>EDP (VALOR)</th>
                      <th>TOTAL (SKU)</th>
                      <th>VTOTAL (VALOR)</th>
                      <th>AÇÕES</th>
                    </tr>
                  </thead>
                  <tbody id="listTbAv">
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
    $('#recListIndAv').modal('show');
    var ds_mes = '<?php echo $ds_mes;?>';
    $('#listTbAv').load('data/dashboard/modal/list_tb_avaria.php?search=',{ds_mes:ds_mes});
  });
</script>