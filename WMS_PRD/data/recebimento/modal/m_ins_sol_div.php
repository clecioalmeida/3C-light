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

$query_prod = "SELECT t1.cod_nf_entrada, t1.cod_rec, t1.nr_fisc_ent, t1.ds_div, t2.ds_divergencia, t1.ds_resp_div, t1.dt_limite_div, t1.dt_sol_div, t1.ds_sol_div 
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

$link->close();
?>
<style type="text/css">

  .tableFixHead          { overflow-y: auto; height: 640px; }
  .tableFixHead thead th { position: sticky; top: 0; }
  table  { border-collapse: collapse; width: 100%; }
  th, td { padding: 8px 16px; }
  th     { background:#eee; }

  /* CAMPO INPUT DENTRO DA TD */

  table td {
    position: relative;
}

table td input {
    position: absolute;
    display: block;
    top:0;
    left:0;
    margin: 0;
    height: 100%;
    width: 100%;
    border: none;
    padding: 10px;
    box-sizing: border-box;
    font-size: 12px;
    text-align: left;

</style>
<div class="modal fade" id="ins_div" tabindex="-1" role="dialog">
    <form method="post" action="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #22262E;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color: white">ALTERAÇÃO DE DIVERGÊNCIAS DE NOTAS FISCAIS</h4>
                </div>
                <div class="modal-body">
                    
            <form method="POST" action="" id="formDivNf">
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
        </div>
        <div class="modal-footer" style="background-color: #22262E;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary" id="btnSaveUpdSol" value="<?php echo $id_nf;?>">SALVAR</button>
        </div>
    </div>
</div>
</form>
</div>
<script>
    $(document).ready(function () {
        $('#ins_div').modal('show');

        $('#listTbDivNf').load('data/recebimento/list_tb_div_nf.php');
    });
</script>