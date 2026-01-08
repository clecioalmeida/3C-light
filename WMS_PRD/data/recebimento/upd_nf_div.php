<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:../../index.php");
  exit;

}else{

  $id     = $_SESSION["id"];
  $cod_cli  = $_SESSION["cod_cli"];
}
?>
<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date("Y-m-d H:i:s");
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_nf = $_POST['id_nf'];

$query_prod = "SELECT t1.cod_nf_entrada, t1.cod_rec, t1.nr_fisc_ent, t1.ds_div, t2.ds_divergencia, t1.ds_resp_div, t1.dt_limite_div, t1.dt_sol_div, t1.ds_sol_div, t1.nr_ped_sap, t1.nr_chamado 
from tb_nf_entrada t1
left join tb_div_nf t2 on t1.ds_div = t2.id
 where t1.cod_nf_entrada = '$id_nf'";
$res_prod = mysqli_query($link,$query_prod);
$dados = mysqli_fetch_assoc($res_prod);
$cod_rec        = $dados['cod_rec'];
$cod_nf_entrada = $dados['cod_nf_entrada'];
$nr_fisc_ent    = $dados['nr_fisc_ent'];
$ds_div         = $dados['ds_div'];
$ds_divergencia = $dados['ds_divergencia'];
$ds_resp_div    = $dados['ds_resp_div'];
$dt_limite_div  = $dados['dt_limite_div'];
$dt_sol_div     = $dados['dt_sol_div'];
$ds_sol_div     = $dados['ds_sol_div'];
$nr_ped_sap     = $dados['nr_ped_sap'];
$nr_chamado     = $dados['nr_chamado'];

$link->close();
?>
<br><br>
<legend>ALTERAR DIVERGÊNCIA DE NOTA FISCAL
  <button type="button" class="btn btn-primary btn-xs" id="btnUpdDivNfRec" value="<?php echo $id_nf;?>" style="float: right;width: 150px">SALVAR</button>
</legend>
<form method="POST" action="" id="formUpdDivNf">
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nm_expedidor" class="control-label col-sm-1">CÓDIGO RECEBIMENTO</label>
        <div class="col-md-2">       
          <div class="input-group input-group-md">
            <input class="form-control" id="cod_rec" name="cod_rec" placeholder="DIGITE A OR E CLIQUE EM CONSULTAR" type="text" value="<?php echo $cod_rec;?>">
            <span class="input-group-btn">
              <button class="btn btn-info" type="button" id="btnPesqRecNf" style="height: 32px"><span class="fa fa-save" title data-original-title="SALVAR"></button>
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
              <option value="<?php echo $cod_nf_entrada;?>"><?php echo $nr_fisc_ent;?></option>
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
              <option value="<?php echo $ds_div;?>"><?php echo $ds_divergencia;?></option>
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
            <input type="text" class="form-control" name="ds_resp_div" placeholder="RESPONSÁVEL" id="ds_resp_div" value="<?php echo $ds_resp_div;?>">
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">DATA LIMITE</label>
          <div class="col-md-2">
            <input type="date" class="form-control" name="dt_limite_div" placeholder="DATA LIMITE" id="dt_limite_div" value="<?php echo $dt_limite_div;?>">
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">DATA DA SOLUÇÃO</label>
          <div class="col-md-2">
            <input type="date" class="form-control" name="dt_sol_div" placeholder="DATA DA SOLUÇÃO" id="dt_sol_div" value="<?php echo $dt_sol_div;?>">
          </div>
        </div>
      </section>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">CHAMADO</label>
          <div class="col-md-2">
            <input type="text" class="form-control" name="nr_chamado" placeholder="CHAMADO" id="nr_chamado" value="<?php echo $nr_chamado;?>">
          </div>
        </div>
      </section>
    </fieldset>
    <fieldset>
      <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">SOLUÇÃO APLICADA</label>
          <div class="col-md-5">
           <textarea class="form-control" placeholder="SOLUÇÃO APLICADA" name="ds_sol_div" id="ds_sol_div" rows="3"><?php echo $ds_sol_div;?></textarea>
         </div>
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