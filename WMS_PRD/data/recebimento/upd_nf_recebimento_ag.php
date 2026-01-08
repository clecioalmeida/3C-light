<?php

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_nf = mysqli_real_escape_string($link, $_POST["upd_nfrec"]);

$select_nf = "select t1.*, date(t1.dt_emis_Ent) as data_emiss, format(t1.vl_tot_nf_ent,2,'de_DE') as vl_tot_nf, format(t1.vl_icms_ent,2,'de_DE') as vl_icms, t2.nm_cliente, t3.nm_fornecedor, t4.nm_cliente as detinatario
from tb_nf_entrada t1
left join tb_cliente t2 on t1.id_dest = t2.cod_cliente
left join tb_recebimento_ag t3 on t1.cod_rec = t3.cod_recebimento
left join tb_cliente t4 on t1.id_rem = t4.cod_cliente
where t1.cod_nf_entrada = '$id_nf'";
$res_nf = mysqli_query($link, $select_nf);

while ($dados = mysqli_fetch_assoc($res_nf)) {
  $cod_recebimento  = $dados["cod_rec"];
  $nr_fisc_ent      = $dados["nr_fisc_ent"];
  $cod_nf_entrada   = $dados["cod_nf_entrada"];
  $nm_fornecedor    = $dados["nm_fornecedor"];
  $nm_cliente       = $dados["nm_cliente"];
  $nr_fisc_ent      = $dados["nr_fisc_ent"];
  $dt_emis_ent      = $dados["data_emiss"];
  $nr_cfop_ent      = $dados["nr_cfop_ent"];
  $qtd_vol_ent      = $dados["qtd_vol_ent"];
  $nr_peso_ent      = $dados["nr_peso_ent"];
  $tp_vol_ent       = $dados["tp_vol_ent"];
  $vl_tot_nf_ent    = $dados["vl_tot_nf"];
  $base_icms_ent    = $dados["base_icms_ent"];
  $vl_icms_ent      = $dados["vl_icms"];
  $chavenfe         = $dados["chavenfe"];
  $ds_obs_nf        = $dados["ds_obs_nf"];
  $detinatario      = $dados["detinatario"];
}
$link->close();
?>
<br><br>
<legend>NOTA FISCAL No. <?php echo $nr_fisc_ent;?><button type="submit" class="btn btn-success" id="btnFormUpdNfRecebimentoAg" value="<?php echo $id_nf;?>" style="float: right;margin-top: -10px;width: 100px">Salvar</button></legend>
<form method="POST" action="" id="checkout-form">
  <fieldset>
    <section>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="nm_fornecedor"> Emitente</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" value="<?php echo $detinatario;?>" id="nm_fornecedor" name="nm_fornecedor" readonly="true">
          <div class="form-control-focus"> </div>
        </div>
        <label class="col-sm-2 control-label" for="nm_cliente">Destinatário</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" value="<?php echo $nm_cliente;?>" id="nm_cliente" name="nm_cliente" readonly="true">
          <div class="form-control-focus"> </div>
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="nr_fisc_ent">Nota fiscal</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" value="<?php echo $nr_fisc_ent;?>" id="nr_fisc_ent" name="nr_fisc_ent" style="text-align: right;">
          <div class="form-control-focus"> </div>
        </div>
        <label class="col-sm-2 control-label" for="dt_emis_ent">Emissão</label>
        <div class="col-sm-2">
          <input type="date" class="form-control" value="<?php echo $dt_emis_ent;?>" id="dt_emis_ent" name="dt_emis_ent">
          <div class="form-control-focus"> </div>
        </div>
        <label class="col-sm-2 control-label" for="nr_cfop_ent">CFOP</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" value="<?php echo $nr_cfop_ent;?>" id="nr_cfop_ent" name="nr_cfop_ent" style="text-align: right;">
          <div class="form-control-focus"> </div>
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="tp_vol_ent">Total de volumes</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" value="<?php echo $qtd_vol_ent;?>" id="qtd_vol_ent" name="qtd_vol_ent" style="text-align: right;">
          <div class="form-control-focus"> </div>
        </div>
        <label class="col-sm-2 control-label" for="nr_peso_ent">Peso total</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" value="<?php echo $nr_peso_ent;?>" id="nr_peso_ent" name="nr_peso_ent" style="text-align: right;">
          <div class="form-control-focus"> </div>
        </div>
        <label class="col-sm-2 control-label" for="tp_vol_ent">Tipo de volume</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" value="<?php echo $tp_vol_ent;?>" id="tp_vol_ent" name="tp_vol_ent">
          <div class="form-control-focus"> </div>
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="vl_tot_nf_ent">Valor total</label>
        <div class="col-sm-2">
          <input type="text" class="form-control valor" value="<?php echo $vl_tot_nf_ent;?>" id="vl_tot_nf_ent" name="vl_tot_nf_ent" style="text-align: right;">
          <div class="form-control-focus"> </div>
        </div>
        <label class="col-sm-2 control-label" for="form_control_cliente">Base ICMS</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" value="<?php echo $base_icms_ent;?>" name="base_icms_ent" id="base_icms_ent" style="text-align: right;">
          <div class="form-control-focus"> </div>
        </div>
        <label class="col-sm-2 control-label" for="base_icms_ent">Valor do ICMS</label>
        <div class="col-sm-2">
          <input type="text" class="form-control valor" value="<?php echo $vl_icms_ent;?>" id="vl_icms_ent" name="vl_icms_ent" style="text-align: right;">
          <div class="form-control-focus"> </div>
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="chavenfe">Chave Nfe</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" value="<?php echo $chavenfe;?>" id="chavenfe" name="chavenfe" style="text-align: right;">
          <div class="form-control-focus"> </div>
        </div>
      </div>
    </section>
  </fieldset>
  <fieldset>
    <section>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="ds_obs_nf">Observações</label>
        <div class="col-sm-6">
          <textarea class="form-control" name="ds_obs_nf" id="ds_obs_nf" value="<?php echo $ds_obs_nf;?>" placeholder="Observação"><?php echo $ds_obs_nf;?></textarea>
          <div class="form-control-focus"> </div>
        </div>
      </div>
    </section>
  </fieldset>
</form>
<!--script type="text/javascript">
  $(document).ready(function () {
    $('.valor').maskMoney();
  });
</script-->