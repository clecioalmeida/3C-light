<?php

$select_nf = "select r.nm_fornecedor, r.nm_transportadora, r.nm_placa, r.ds_obs, DATE_FORMAT(dt_recebimento_previsto ,'%d/%m/%Y') dt_recebimento_previsto, c.nm_cliente, i.cod_nf_entrada, i.nr_fisc_ent, i.dt_emis_ent, i.nr_cfop_ent, i.qtd_vol_ent, i.nr_peso_ent, i.vl_tot_nf_ent, i.tp_vol_ent, i.base_icms_ent, i.vl_icms_ent, i.chavenfe from tb_recebimento r left join tb_cliente c on r.cod_cli = c.cod_cliente left join tb_nf_entrada i on i.cod_rec = r.cod_recebimento where cod_recebimento = '$id_rec'";
$res_nf = mysqli_query($link, $select_nf);

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
}

$sql_estado = "select * from tb_estado_produto";
$res_estado = mysqli_query($link, $sql_estado);

$sql_emit = "select cod_cliente, nm_cliente from tb_cliente where cod_cli is null and fl_tipo = 'C'";
$res_emit = mysqli_query($link, $sql_emit);

$sql_dest = "select cod_cliente, nm_cliente from tb_cliente where cod_cli is null and fl_tipo = 'D'";
$res_dest = mysqli_query($link, $sql_dest);
while ($dados_emit = mysqli_fetch_assoc($res_emit)) {
	$destinatario = $dados_emit['nm_cliente'];
}

$select_nf_item = "select t1.cod_compra_venda, t2.nr_fisc_ent, t3.nr_peso_unit, t3.vl_unit, t3.cod_nf_entrada_item, t3.nr_qtde, t4.estado, t5.cod_produto, t5.nm_produto
from tb_saldo_produto t1
left join tb_nf_entrada t2 on t1.cod_compra_venda = t2.cod_rec
left join tb_nf_entrada_item t3 on t2.cod_nf_entrada = t3.cod_nf_entrada
left join tb_estado_produto t4 on t3.estado_produto = t4.id
left join tb_produto t5 on t1.produto = t5.cod_produto
where t3.cod_nf_entrada = '$cod_nf_entrada'";
$res_nf_item = mysqli_query($link, $select_nf_item);

$link->close();
?>
<div class="modal fade" id="prod_recebimento" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title"></h3></h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
        <div class="col-sm-12">
          <label><h4 style="color: white">Inclusão de produtos</h4></label>
        </div>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <div id="produtoRec">
          <h2>Ordem de recebimento</h2>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="emissor">O.R.</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" value="<?php echo $id_rec; ?>" name="cod_recebimento" id="id_rec" readonly="true">
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
          </fieldset><hr>
          <h2>Selecione a nota fiscal</h2>
          <form method="post" class="form-inline" action="" id="formNovoNfRec">
            <input type="hidden" class="form-control" id="cod_rec" name="cod_rec" value="<?php echo $id_rec; ?>" placeholder="Nota fiscal">
            <label class="control-label" for="or">Nota fiscal</label>
            <select class="form-control" id="produto_nf" required="true">
              <option>Nota fiscal</option>
              <?php
              while ($row_select_nf = mysqli_fetch_assoc($res_nf)) {?>
                <option value="<?php echo $row_select_nf['cod_nf_entrada']; ?>">
                  <?php echo $row_select_nf['nr_fisc_ent']; ?>
                  </option> <?php }?>
                </select><br><br>
                <div id="formNf">
                 <label class="control-label" for="or">Emissão</label>
                 <input type="text" class="form-control" id="dt_emis_ent" name="dt_emis_ent" placeholder="Emissão">
                 <label class="control-label" for="or">Total de volumes</label>
                 <input type="text" class="form-control" id="tp_vol_ent" name="qtd_vol_ent" placeholder="Total de volumes">
                 <label class="control-label" for="or">Peso total</label>
                 <input type="text" class="form-control" id="nr_peso_ent" name="nr_peso_ent" placeholder="Peso total (kg)">
               </div>
             </form>
           </div><hr>
           <h2>Insira os produtos<button type="submit" class="btn btn-success" id="btnFormPesqProdRec" style="float: right;width: 80px">Pesquisar</button></h2>
           <div id="retPesqPrdRecOk">
            <h2 id="retPesqPrdRec" style="text-align: center;background-color: #A52A2A;color: white"></h2>
          </div>
          <div id="retMPesPrd"></div>
          <div class="row">
            <form method="post" class="form-inline" action="" id="formNovoProdRec">
              <input type="hidden" class="form-control" id="cod_nf_entrada" name="cod_nf_entrada" value="<?php echo $cod_nf_entrada; ?>">
              <!--input type="hidden" class="form-control" id="id_user" name="id_user" value="<?php echo $id; ?>"-->
              <input type="text" class="form-control" id="cod_produto" name="cod_produto" value="" placeholder="Código" style="width: 150px">
              <input type="text" class="form-control" id="cod_prod_cliente" name="cod_prod_cliente" placeholder="Código SAP" style="width: 150px">
              <input type="text" class="form-control" id="nr_qtde" name="nr_qtde" placeholder="Quantidade" style="width: 100px">
              <input type="text" class="form-control" id="vl_unit" name="vl_unit" placeholder="Valor unitário" style="width: 100px">
              <input type="text" class="form-control" id="nr_peso_ent" name="nr_peso_ent" placeholder="Peso total (kg)" style="width: 100px">
              <select class="form-control" id="estado_produto" style="width: 150px">
                <option>Estado</option>
                <?php
                while ($row_estado = mysqli_fetch_assoc($res_estado)) {
                 ?>
                 <option value="<?php echo $row_estado['id']; ?>">
                  <?php
                  echo $row_estado['estado'];
                  ?>
                  </option> <?php }?>
                </select>
                <button type="button" class="btn btn-primary" id="btnInsPrdNfRec" style="float: right;margin-right: 10px;width: 80px">Inserir</button>
              </form>
              <br><br>
              <div id="retornoPrd">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                  <thead>
                    <tr>
                      <th colspan="4"> Ações</th>
                      <th> ID </th>
                      <th> NF </th>
                      <th> Produto </th>
                      <th> Descrição</th>
                      <th> Estado </th>
                      <th> Qtde </th>
                      <th> Vlr Unit.  </th>
                      <th> Peso Unit.  </th>
                    </tr>
                  </thead>
                  <tbody id="retProdNfItem">
                    <?php
                    while ($dados_prdNf = mysqli_fetch_assoc($res_nf_item)) {
                     ?>
                     <tr>
                      <td style="text-align: center; width: 5px"><button type="submit" id="btnUpdNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados_prdNf['cod_nf_entrada_item']; ?>">Alterar</button></td>
                      <td style="text-align: center; width: 5px"><button type="submit" id="btnDelPrdNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados_prdNf['cod_nf_entrada_item']; ?>">Excluir</button></td>
                      <td style="text-align: center; width: 5px"><button type="submit" id="btnNsPrdrec" class="btn btn-primary btn-xs" value="<?php echo $dados_prdNf['cod_nf_entrada']; ?>">N.Série</button></td>
                      <td><?php echo $dados_prdNf['cod_nf_entrada']; ?></td>
                      <td><?php echo $dados_prdNf['nr_fisc_ent']; ?></td>
                      <td><?php echo $dados_prdNf['cod_produto']; ?></td>
                      <td><?php echo $dados_prdNf['nm_produto']; ?></td>
                      <td style="text-align: right;"><?php echo $dados_prdNf['estado']; ?></td>
                      <td style="text-align: right;"><?php echo $dados_prdNf['nr_qtde']; ?></td>
                      <td style="text-align: right;"><?php echo $dados_prdNf['vl_unit']; ?></td>
                      <td style="text-align: right;"><?php echo $dados_prdNf['nr_peso_unit']; ?></td>
                    </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color: #2F4F4F;">
          <div id="testeRetorno"></div>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div><!--Fim modal-->
  <script>
    $(document).ready(function () {
      $('#prod_recebimento').modal('show');
    });

  </script>