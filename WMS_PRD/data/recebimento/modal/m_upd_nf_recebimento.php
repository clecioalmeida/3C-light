<?php

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_nf = mysqli_real_escape_string($link, $_POST["upd_nfrec"]);

$select_nf = "select t1.*, t2.nm_cliente, t3.nm_fornecedor
    from tb_nf_entrada t1
    left join tb_cliente t2 on t1.id_dest = t2.cod_cliente
    left join tb_recebimento t3 on t1.cod_rec = t3.cod_recebimento
    where t1.cod_nf_entrada = '$id_nf'";
$res_nf = mysqli_query($link, $select_nf);

while ($dados = mysqli_fetch_assoc($res_nf)) {
	$cod_recebimento = $dados["cod_rec"];
	$nr_fisc_ent = $dados["nr_fisc_ent"];
	$cod_nf_entrada = $dados["cod_nf_entrada"];
	$nm_fornecedor = $dados["nm_fornecedor"];
	$nm_cliente = $dados["nm_cliente"];
	$nr_fisc_ent = $dados["nr_fisc_ent"];
	$dt_emis_ent = $dados["dt_emis_ent"];
	$nr_cfop_ent = $dados["nr_cfop_ent"];
	$qtd_vol_ent = $dados["qtd_vol_ent"];
	$nr_peso_ent = $dados["nr_peso_ent"];
	$tp_vol_ent = $dados["tp_vol_ent"];
	$vl_tot_nf_ent = $dados["vl_tot_nf_ent"];
	$base_icms_ent = $dados["base_icms_ent"];
	$vl_icms_ent = $dados["vl_icms_ent"];
	$chavenfe = $dados["chavenfe"];
	$ds_obs_nf = $dados["ds_obs_nf"];
}
$link->close();
?>
<div class="modal fade" id="alterar_nf" aria-hidden="true">
    <form method="post" action="" id="formUpdNfRecebimento">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <h3 class="modal-title" id="novo_item" style="color: white">Alterar nota fiscal <?php echo $nr_fisc_ent; ?> da OR <?php echo $cod_recebimento; ?></h3>
                    <input type="hidden" name="cod_nf_entrada" value="<?php echo $cod_nf_entrada; ?>">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-lg" style="overflow-y: auto">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="nm_fornecedor"> Emitente</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $nm_fornecedor; ?>" id="nm_fornecedor" name="nm_fornecedor" readonly="true">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-sm-2 control-label" for="nm_cliente">Destinatário</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $nm_cliente; ?>" id="nm_cliente" name="nm_cliente" readonly="true">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="nr_fisc_ent">Nota fiscal</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="nr_fisc_ent" name="nr_fisc_ent" value="<?php echo $nr_fisc_ent; ?>">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-sm-2 control-label" for="dt_emis_ent">Emissão</label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" id="dt_emis_ent" name="dt_emis_ent" value="<?php echo $dt_emis_ent; ?>">
                                            <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-sm-2 control-label" for="nr_cfop_ent">CFOP</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="nr_cfop_ent" name="nr_cfop_ent" value="<?php echo $nr_cfop_ent; ?>">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="tp_vol_ent">Total de volumes</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="qtd_vol_ent" name="qtd_vol_ent" value="<?php echo $qtd_vol_ent; ?>">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-sm-2 control-label" for="nr_peso_ent">Peso total</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="nr_peso_ent" name="nr_peso_ent"value="<?php echo $nr_peso_ent; ?>">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-sm-2 control-label" for="tp_vol_ent">Tipo de volume</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="tp_vol_ent" name="tp_vol_ent" value="<?php echo $tp_vol_ent; ?>">
                                    <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="vl_tot_nf_ent">Valor total</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="vl_tot_nf_ent" name="vl_tot_nf_ent" value="<?php echo $vl_tot_nf_ent; ?>">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-sm-2 control-label" for="form_control_cliente">Base ICMS</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="base_icms_ent" id="base_icms_ent" value="<?php echo $base_icms_ent; ?>">
                                <div class="form-control-focus"> </div>
                            </div>
                            <label class="col-sm-2 control-label" for="base_icms_ent">Valor do ICMS</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="vl_icms_ent" name="vl_icms_ent" value="<?php echo $vl_icms_ent; ?>">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="chavenfe">Chave Nfe</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="chavenfe" name="chavenfe" value="<?php echo $chavenfe; ?>">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="ds_obs_nf">Observações</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="ds_obs_nf" name="ds_obs_nf" id="ds_obs_nf" value="<?php echo $ds_obs_nf; ?>" placeholder="Observação"></textarea>
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer" style="background-color: #2F4F4F;">
                    <button type="submit" class="btn btn-primary" id="btnFormUpdNfRecebimento">Salvar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </form>
</div><!--Fim modal-->
<script>
  $(document).ready(function () {
    $('#alterar_nf').modal('show');
  });
</script>