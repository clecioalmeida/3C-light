<?php 

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$ns_ini = $_POST["ns_ini"];
$ns_fim = $_POST["ns_fim"];
$nr_ped = $_POST["nr_ped"];

$table = "";

for ($i=$ns_ini; $i <= $ns_fim; $i++) {

  $sql_ped="select n_serie, id_produto, status_sap, status_usr
  from tb_nserie
  where n_serie = '$i'";
  $res_ped = mysqli_query($link,$sql_ped);
  $dados = mysqli_fetch_assoc($res_ped);

  $table .= "<tr>
  <td>
  <div class='form-group'>
  <label class='checkbox-inline'>
  <input type='checkbox' class='checkbox style-0 checkPedNs' id='checkPedNs' value='".$i."' checked>
  <span></span>
  </label>
  </div>
  </td><td>".$dados['n_serie']."</td>
  <td>".$dados['id_produto']."</td>
  <td>".$dados['status_sap']."</td>
  <td>".$dados['status_usr']."</td></tr>";

}

$sql_st="select status_sap, status_usr
from tb_nserie
where n_serie >= '$ns_ini' and n_serie <= '$ns_fim' and (status_usr <> 'DEPS' or status_sap <> 'DEPS') and fl_status = 'A'
group by status_sap, status_usr";
$res_st = mysqli_query($link,$sql_st);

if(mysqli_num_rows($res_st) > 0){

  $status = '<p>EXISTEM NÚMEROS DE SÉRIE SEM STATUS DEPS. DESEJA CONTINUAR?
  <button type="button" id="btnInsNsPedido" class="btn btn-danger" value='.$nr_ped.' data-nsini='.$ns_ini.' data-nsfim='.$ns_fim.' style="width: 100px">SIM</button><button type="button" id="btnInsNsPedido" class="btn btn-primary" value="" style="width: 100px">NÃO</button></p>';

}else{

  $qtd = ($ns_fim - $ns_ini)+1;

  $status = '<p>CONFIRMA A INCLUSÃO DOS NÚMEROS DE SÉRIE?</p><p>SERÃO INCLUÍDOS <bold>'.$qtd.'</bold> NÚMEROS DE SÉRIE.
  <button type="button" id="btnInsNsPedido" class="btn btn-success" value='.$nr_ped.' data-nsini='.$ns_ini.' data-nsfim='.$ns_fim.' style="width: 100px">SIM</button><button type="button" id="btnInsNsPedido" class="btn btn-danger" value="" style="width: 100px">NÃO</button></p>';

}

$link->close();
?>
<div class="modal fade" id="altera_pedido" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E;">
        <h5 class="modal-title" style="color: white">INCLUIR NÚMEROS DE SÉRIE</h5>
        <input type="hidden" name="nr_pedido" id="nr_pedido" value="">
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <form method="post" action="" id="formFrota">
          <fieldset>
            <h3><?php echo $status;?></h3>
            <table class="table" id="">
              <thead>
                <tr>
                  <th>
                    <div class="form-group">
                      <label class="checkbox-inline">
                        <input type="checkbox" id="checkboxTodosExp" class="checkbox style-0" checked>
                        <span></span>
                      </label>
                    </div>
                  </th>
                  <th> NÚMERO DE SÉRIE</th>
                  <th> CÓDIGO SAP</th>
                  <th> STATUS SAP </th>
                  <th> STATUS USR </th>
                </tr>
              </thead>
              <tbody id="retPrdPedido">
                <?php echo $table;?>
              </tbody>
            </table>
          </fieldset>
        </form>   
      </div>
      <div class="modal-footer" style="background-color: #22262E;">
          <button type="button" class="btn btn-default" data-dismiss="modal">FECHAR</button>
      </div>
    </div>
  </div>
</form>
</div>
<script>
  $(document).ready(function () {
    $('#altera_pedido').modal('show');
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkboxTodos").click(function(){
      $('input:checkbox').not(this).prop('checked', this.checked);
    });;
  });
</script>