<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

  header("Location:../index.php");
  exit;

} else {

  $id       = $_SESSION["id"];
  $cod_cli  = $_SESSION['cod_cli'];
}
?>
<?php

require_once "bd_class.php";
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_div = "select id, ds_divergencia from tb_div_nf" or die(mysqli_error($sql_div));
$res_div = mysqli_query($link, $sql_div);

$link->close();
?>
<br><br>
<legend>CADASTRAR DIVERGÊNCIA DE NOTA FISCAL
  <button type="button" class="btn btn-primary btn-xs" id="btnInsDivNfRec" style="float: right;width: 150px">SALVAR</button>
</legend>
<form method="POST" action="" id="formDivNf">
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">CÓDIGO RECEBIMENTO</label>
        <div class="col-md-2">       
          <div class="input-group input-group-md">
            <input class="form-control" id="cod_rec" name="cod_rec" placeholder="DIGITE A OR E CLIQUE EM CONSULTAR" type="text">
            <span class="input-group-btn">
              <button class="btn btn-info" type="button" id="btnPesqRecNf" style="height: 32px"><span class="fa fa-search" title data-original-title="SALVAR"></button>
              </span>
            </div>
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">NOTAS FISCAIS</label>
          <div class="col-md-2">            
            <select name="nr_nf" id="nr_nf" class="form-control">
              <?php
              while ($dados = mysqli_fetch_assoc($res)) {?>
                <option value="<?php echo $dados['nr_nf'];?>"><?php echo $dados['nr_nf_formulario'];?></option> 
              <?php }?>
            </select>
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">DIVERGÊNCIA</label>
          <div class="col-md-3">            
            <select name="ds_div" id="ds_div" class="form-control">
              <?php
              while ($dados_div = mysqli_fetch_assoc($res_div)) {?>
                <option value="<?php echo $dados_div['id'];?>"><?php echo $dados_div['ds_divergencia'];?></option> 
              <?php }?>
            </select>
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">PEDIDO</label>
          <div class="col-md-1">
            <input type="text" class="form-control" name="nr_ped_sap" placeholder="PEDIDO SAP" id="nr_ped_sap">
          </div>
        </div>
      </section>
    </fieldset>
    <fieldset>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">RESPONSÁVEL (CLIENTE)</label>
          <div class="col-md-2">
            <input type="text" class="form-control" name="ds_resp_div" placeholder="RESPONSÁVEL" id="ds_resp_div">
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">DATA LIMITE</label>
          <div class="col-md-2">
            <input type="date" class="form-control" name="dt_limite_div" placeholder="DATA LIMITE" id="dt_limite_div">
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">DATA DA SOLUÇÃO</label>
          <div class="col-md-2">
            <input type="date" class="form-control" name="dt_sol_div" placeholder="DATA DA SOLUÇÃO" id="dt_sol_div">
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">CHAMADO</label>
          <div class="col-md-2">
            <input type="text" class="form-control" name="nr_chamado" placeholder="CHAMADO" id="nr_chamado">
          </div>
        </div>
      </section>
    </fieldset>
    <fieldset>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">SITUAÇÃO</label>
          <div class="col-md-5">
           <textarea class="form-control" placeholder="SOLUÇÃO APLICADA" name="ds_sol_div" id="ds_sol_div" rows="3"></textarea>
         </div>
       </div>
     </section>
   </fieldset><br>
   <fieldset id="">
    <section>
      <div class="tableFixHead">
        <table id="" class="table" data-detail-view="" data-pagination="true" data-pagination-pre-text="< Previous" data-pagination-next-text="Next >" data-classes="table table-hover table-condensed" style="font-size: 12px">
         <tr>
          <th>NOTA FISCAL</th>
          <th>DIVERGÊNCIA</th>
          <th>RESPONSÁVEL</th>
          <th>DATA LIMITE</th>
          <th>DATA DE SOLUÇÃO</th>
          <th>SOLUÇÃO</th>
        </tr>
        <tbody id="cad_div_nfe"> 
        </tbody>
      </table>
    </div>
  </section>
</fieldset>
</form>
<script>
  $(document).ready(function () {
    $( '#liRecNfe').on('click', function(){
      var id_rec = $('#btnNovaNfe').val();
      $('#retornoNfe').load('data/recebimento/list_recebimento_nf.php?search=',{id_rec:id_rec});
    });
  });
</script>