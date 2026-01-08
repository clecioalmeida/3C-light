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
                <table id="RepIndCronExcel" class="table" width="100%" style="font-size: 10px">
                  <thead>
                    <tr style="font-size: 10px">
                      <th>DATA</th>
                      <th>QTDE SKU INVENTARIADA</th>
                      <th>QTDE SKU SOBRA</th>
                      <th>QTDE SKU FALTA</th>
                      <th>ACURACIDADE SKU</th>
                      <th>VLR INICIAL</th>
                      <th>VLR SOBRA</th>
                      <th>VLR FALTA</th>
                      <th>VLR FINAL</th>
                      <th>ACURACIDADE VALOR</th>
                      <th>AÇÕES</th>
                    </tr>
                  </thead>
                  <tbody id="listTbInvDep">
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
    $('#listTbInvDep').load('data/dashboard/modal/list_tb_inv_dep.php?search=',{id_ind:id_ind});
  });
</script>