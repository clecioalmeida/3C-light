 <?php 

 $dt_exp = $_POST['dt_exp'];

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
                      <th>NR PEDIDO</th>
                      <th>DOC MATERIAL</th>
                      <th>ALMOX</th>
                      <th>DATA CRONOGRAMA</th>
                      <th>DATA EXPEDIÇÃO</th>
                    </tr>
                  </thead>
                  <tbody id="listTbTmpExp">
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
    var dt_exp = '<?php echo $dt_exp;?>';
    $('#listTbTmpExp').load('data/dashboard/modal/list_tb_tmp_exp.php?search=',{dt_exp:dt_exp});
  });
</script>