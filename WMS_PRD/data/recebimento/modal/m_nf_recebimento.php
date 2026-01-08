<?php

require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_rec = mysqli_real_escape_string($link, $_POST["nf_rec"]);

$select_nf = "select r.nm_fornecedor, r.nm_transportadora, r.nm_placa, r.ds_obs, DATE_FORMAT(dt_recebimento_previsto ,'%d/%m/%Y') dt_recebimento_previsto, c.nm_cliente, i.cod_nf_entrada, i.nr_fisc_ent, i.dt_emis_ent, i.nr_cfop_ent, i.qtd_vol_ent, i.nr_peso_ent, i.vl_tot_nf_ent, i.tp_vol_ent, i.base_icms_ent, i.vl_icms_ent, i.chavenfe from tb_recebimento r left join tb_cliente c on r.cod_cli = c.cod_cliente left join tb_nf_entrada i on i.cod_rec = r.cod_recebimento where r.cod_recebimento = '$id_rec' and i.fl_status <> 'E'";
$res_nf = mysqli_query($link, $select_nf);
$tr = mysqli_num_rows($res_nf);

$select_or = "select * from tb_recebimento where cod_recebimento = '$id_rec'";
$res_or = mysqli_query($link, $select_or);
while ($dados_or = mysqli_fetch_assoc($res_or)) {
	$nm_fornecedor = $dados_or["nm_fornecedor"];
	$nm_transportadora = $dados_or["nm_transportadora"];
	$nr_peso_previsto = $dados_or["nr_peso_previsto"];
	$nr_volume_previsto = $dados_or["nr_volume_previsto"];
	$dt_recebimento_previsto = $dados_or["dt_recebimento_previsto"];
	$nm_motorista = $dados_or["nm_motorista"];
	$nm_placa = $dados_or["nm_placa"];
	$ds_obs = $dados_or["ds_obs"];
	$fl_status = $dados_or["fl_status"];
}

$sql_emit = "select cod_cliente, nm_cliente from tb_cliente where cod_cli is null and fl_tipo = 'D'";
$res_emit = mysqli_query($link, $sql_emit);

$sql_dest = "select cod_cliente, nm_cliente from tb_cliente where cod_cli is null and fl_tipo = 'C'";
$res_dest = mysqli_query($link, $sql_dest);
$link->close();
?>
<div class="modal fade" id="nf_recebimento" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title"></h3></h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
        <div class="col-sm-12">
          <label><h4 style="color: white">Notas fiscais de entrada</h4></label>

        </div>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <div id="produtoRec">
          <legend>Ordem de recebimento</legend>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="emissor">O.R.</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" value="<?php echo $id_rec; ?>" name="cod_recebimento" id="or" readonly="true">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="nm_fornecedor">Fornecedor</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" value="<?php echo $nm_fornecedor; ?>" name="nm_fornecedor" id="nm_fornecedor" readonly="true">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="nm_transportador">Transportador</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" value="<?php echo $nm_transportadora; ?>" name="nm_transportador" id="nm_transportador" readonly="true">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </fieldset><br>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="nr_peso_previsto">Peso previsto</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" value="<?php echo $nr_peso_previsto; ?>" name="nr_peso_previsto" id="nr_peso_previsto" readonly="true">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="nr_volume_previsto">Volume previsto</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" value="<?php echo $nr_volume_previsto; ?>" name="nr_volume_previsto" id="nm_transportador" readonly="true">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="dt_recebimento_previsto">Data prevista</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" value="<?php
                if ($dt_recebimento_previsto == 0) {
                 echo '';
                 } else {

                   echo date("d/m/Y", strtotime($dt_recebimento_previsto));
                 }?>"

                 name="dt_recebimento_previsto" id="dt_recebimento_previsto" readonly="true">
                 <div class="form-control-focus"> </div>
               </div>
             </div>
           </fieldset>
           <legend>Inserir notas fiscais</legend>
           <form method="post" class="form-inline" action="" id="formNovoNfRec">
            <select class="form-control" name="id_rem" id="id_rem" style="width: 355px">
              <option>Emitente</option>
              <?php
              while ($row = mysqli_fetch_assoc($res_emit)) {?>
                <option value="<?php echo $row['cod_cliente']; ?>">
                  <?php echo $row['nm_cliente']; ?>
                  </option> <?php }?>
                </select>
                <select class="form-control" name="id_dest" id="id_dest" style="width: 355px">
                  <?php
                  while ($dados_dest = mysqli_fetch_assoc($res_dest)) {?>
                    <option value="<?php echo $dados_dest['cod_cliente']; ?>">
                      <?php echo $dados_dest['nm_cliente']; ?>
                      </option> <?php }?>
                    </select>
                    <br /><br />
                    <input type="hidden" class="form-control" id="cod_rec" name="cod_rec" value="<?php echo $id_rec; ?>" >
                    <input type="hidden" class="form-control" id="fl_status" name="fl_status" value="<?php echo $fl_status; ?>" >
                    <input type="text" class="form-control" id="nr_fisc_ent" name="nr_fisc_ent" placeholder="Nota fiscal" required="true">
                    <input type="date" class="form-control" id="dt_emis_ent" name="dt_emis_ent" placeholder="Emissão" required="true">
                    <input type="text" class="form-control" id="tp_vol_ent" name="tp_vol_ent" placeholder="Tipo de volumes" required="true">
                    <input type="text" class="form-control" id="qtd_vol_ent" name="qtd_vol_ent" placeholder="Total de volume">
                    <br /><br />
                    <input type="text" class="form-control" id="nr_cfop_ent" name="nr_cfop_ent" placeholder="Cfop">
                    <input type="text" class="form-control" id="nr_peso_ent" name="nr_peso_ent" placeholder="Peso total (kg)">
                    <input type="text" class="form-control" id="vl_tot_nf_ent" name="vl_tot_nf_ent" placeholder="Valor total" required="true">
                    <input type="text" class="form-control" id="base_icms_ent" name="base_icms_ent" placeholder="Base ICMS">
                    <br /><br />
                    <input type="text" class="form-control" id="vl_icms_ent" name="vl_icms_ent" placeholder="Valor ICMS">
                    <input type="text" class="form-control" id="chavenfe" name="chavenfe" placeholder="Chave Nfe" style="width: 530px">
                    <br><br>
                    <textarea class="form-control" id="ds_obs_nf" name="ds_obs_nf" id="ds_obs_nf" placeholder="Observação" style="width: 600px"></textarea>
                    <br><br>
                    <button type="submit" class="btn btn-primary" id="btnFormNovoNfRec">Inserir</button>
                    <button type="button" class="btn btn-green btn-outline" id="btnModalXml" value="<?php echo $id_rec; ?>">
                      <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                      Importar Xml
                    </button>
                  </form>
                </div>
                <br><br>
                <div class="row">
                  <div id="retornoNf">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                      <thead>
                        <tr>
                          <th colspan="4"> Ações</th>
                          <th> N.F. </th>
                          <th> Fornecedor </th>
                          <th data-toggle="tooltip" data-placement="left" title="Peso total da NF"> Peso (Kg)</th>
                          <th data-toggle="tooltip" data-placement="left" title="Total de volumes da NF"> Volumes </th>
                          <th data-toggle="tooltip" data-placement="left" title="Tipo de volume"> Tipo </th>
                          <th data-toggle="tooltip" data-placement="left" title="Valor total da NF"> Valor  </th>
                        </tr>
                      </thead>
                      <tbody id="retNfRec">
                        <?php
                        while ($dados = mysqli_fetch_assoc($res_nf)) {
                         ?>
                         <tr class="odd gradeX">
                          <td style="text-align: center; width: 5px">
                            <button type="submit" id="btnDtlNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Detalhe</button>
                          </td>
                          <td style="text-align: center; width: 5px">
                            <button type="submit" id="btnUpdNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Alterar</button>
                          </td>
                          <td style="text-align: center; width: 5px">
                            <button type="submit" id="btnDelNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Excluir</button>
                          </td>
                          <td style="text-align: center; width: 5px">
                            <button type="submit" id="btnProdNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_nf_entrada']; ?>">Produtos</button>
                          </td>
                          <td style="text-align: center; width: 10px"> <?php echo $dados['nr_fisc_ent']; ?> </td>
                          <td style="width: 30%"> <?php echo $dados['nm_fornecedor']; ?> </td>
                          <td style="text-align: center; width: 30px"> <?php echo $dados['nr_peso_ent']; ?> </td>
                          <td style="text-align: center; width: 30px"> <?php echo $dados['qtd_vol_ent']; ?> </td>
                          <td style="text-align: center; width: 10px"> <?php echo $dados['tp_vol_ent']; ?> </td>
                          <td style="text-align: center; width: 10px"> <?php echo $dados['vl_tot_nf_ent']; ?> </td>
                        </tr>
                      <?php }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="modal-footer" style="background-color: #2F4F4F;">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div><!--Fim modal-->
      <script>
        $(document).ready(function () {
          $('#nf_recebimento').modal('show');
        });
      </script>