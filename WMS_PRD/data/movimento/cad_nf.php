<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

    header("Location:../../../index.php");
    exit;

} else {

    $id         = $_SESSION["id"];
    $cod_cli    = $_SESSION['cod_cli'];
}
?>
<?php
require_once "bd_class.php";

$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST["nr_pedido"];

$sql_tp = "select t1.nr_ped_sap, t1.doc_material, t1.cod_almox, t1.ds_destino
from tb_pedido_coleta t1
where t1.nr_pedido = '$nr_pedido'";
$res_tp = mysqli_query($link, $sql_tp);
while ($dados=mysqli_fetch_assoc($res_tp)) {
    $nr_ped_sap = $dados['nr_ped_sap'];
    $doc_material = $dados['doc_material'];
    $ds_destino = $dados['ds_destino']." - ".$dados['ds_destino'];
}

$link->close();
?>
<br><br>
<form method="post" action="" id="formNovoNfSaida">
    <legend>CADASTRAR NOTA FISCAL
      <button type="button" class="btn btn-success btn-xs" id="btnInsNfSaida" value="<?php echo $nr_pedido;?>" style="float: right;width: 150px">SALVAR</button>
  </legend>
  <fieldset>
    <section>
      <div class="form-group">
        <label for="nfe_chave" class="control-label col-sm-1">PEDIDO SAP</label>
        <div class="col-md-2">
           <input type="text" class="form-control" id="nr_ped_sap" name="nr_ped_sap" value="<?php echo $nr_ped_sap;?>" style="text-align: right;">
       </div>
   </div>
</section>
<section>
  <div class="form-group">
    <label for="nm_expedidor" class="control-label col-sm-1">DOC MATERIAL</label>
    <div class="col-md-2">
      <input type="text" class="form-control" id="doc_material" name="doc_material" value="<?php echo $doc_material;?>" style="text-align: right;">
  </div>
</div>
</section>
<section>
  <div class="form-group">
    <label for="nm_expedidor" class="control-label col-sm-1">DESTINO</label>
    <div class="col-md-5">
      <input type="text" class="form-control" id="ds_destino" name="ds_destino" value="<?php echo $ds_destino;?>">
  </div>
</div>
</section> 
</fieldset>
<fieldset>  
    <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">NÚMERO</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="nr_nf_formulario" name="nr_nf_formulario">
        </div>
    </div>
</section>
<section>
  <div class="form-group">
    <label for="nm_expedidor" class="control-label col-sm-1">EMISSÃO</label>
    <div class="col-md-2">
      <input type="date" class="form-control" id="dt_emissao" name="dt_emissao" placeholder="Emissão" required="true">
  </div>
</div>
</section> 
<section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">PESO TOTAL</label>
      <div class="col-md-2">
        <input type="text" class="form-control" id="nr_peso" name="nr_peso" placeholder="Peso total (kg)" style="text-align: right;">
    </div>
</div>
</section> 
<section>
    <div class="form-group">
      <label for="nm_expedidor" class="control-label col-sm-1">VALOR TOTAL</label>
      <div class="col-md-2">
        <input type="text" class="form-control valor" id="vl_tot_nf_ent" name="vl_tot_nf_ent" placeholder="Valor total" required="true" style="text-align: right;">
    </div>
</div>
</section>
</fieldset>
<fieldset>
    <section>
        <div class="form-group">
          <label for="nm_expedidor" class="control-label col-sm-1">OBSERVAÇÃO</label>
          <div class="col-md-5">
            <textarea class="form-control" id="ds_obs_nf" name="ds_obs_nf" id="ds_obs_nf" rows="3" placeholder="Observação"></textarea>
        </div>
    </div>
</section>
</fieldset>
<fieldset>
    <section>
        <br><br>
        <div class="form-group">
            <div id="retornoNfSaida">

            </div>
        </div>
        
    </section>
</fieldset>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('#retornoNfSaida').load('data/movimento/list_prd_nf.php?search=',{nr_pedido:'<?php echo $nr_pedido;?>'});
    });
</script>