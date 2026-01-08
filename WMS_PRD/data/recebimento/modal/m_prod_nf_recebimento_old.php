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
            <legend>Ordem de recebimento<button type="button" id="btnPrintBarcodeRec" class="btn btn-default" style="float: right;">Código de barras</button><br /><br /></legend>
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
                            if($dt_recebimento_previsto == 0){
                              echo '';
                            }else{   
                               echo date("d/m/Y", strtotime($dt_recebimento_previsto));
                            }?>"
                            name="dt_recebimento_previsto" id="dt_recebimento_previsto" readonly="true">
                    <div class="form-control-focus"> </div>
                  </div>
                </div>
              </fieldset>
            <legend>Selecione a nota fiscal</legend>
            <form method="post" class="form-inline" action="" id="formNovoNfRec">
              <input type="hidden" class="form-control" id="cod_rec" name="cod_rec" value="<?php echo $id_rec;?>" placeholder="Nota fiscal">
              <label class="control-label" for="or">Nota fiscal</label>
                <select class="form-control" id="produto_nf" required="true">
                  <option>Nota fiscal</option>
                    <?php 
                      while($row_select_nf = mysqli_fetch_assoc($res_nf)) {?>
                  <option value="<?php echo $row_select_nf['cod_nf_entrada']; ?>">
                    <?php echo $row_select_nf['nr_fisc_ent']; ?>
                  </option> <?php } ?>
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
          </div><br><br>
          <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#produto" aria-controls="produto" role="tab" data-toggle="tab">Produtos</a>
              </li>
              <li role="presentation"><a href="#nserie" aria-controls="nserie" role="tab" data-toggle="tab">Número de série</a>
              </li>
            </ul>
            <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="produto"><br>
                  <div class="row">
                    <form method="post" class="form-inline" action="" id="formNovoProdRec">
                    <!--label class="control-label" for="or">Digite o código do produto</label-->
                      <input type="hidden" class="form-control" id="cod_nf_entrada" name="cod_nf_entrada" value="<?php echo $cod_nf_entrada;?>">
                      <input type="text" class="form-control" id="cod_prod_cliente" name="cod_prod_cliente" placeholder="Código SAP">    
                      <!--label class="control-label" for="or">Quantidade</label-->
                      <input type="text" class="form-control" id="nr_qtde" name="nr_qtde" placeholder="Quantidade">
                      <!--label class="control-label" for="or">Valor unitário</label-->
                      <input type="text" class="form-control" id="vl_unit" name="vl_unit" placeholder="Valor unitário">
                      <!--label class="control-label" for="or">Peso total</label-->
                      <input type="text" class="form-control" id="nr_peso_ent" name="nr_peso_ent" placeholder="Peso total (kg)">
                      <select class="form-control" id="estado_produto">
                        <option>Estado</option>
                          <?php 
                            while($row_estado = mysqli_fetch_assoc($res_estado)) {?>
                        <option value="<?php echo $row_estado['id']; ?>">
                          <?php echo $row_estado['estado']; ?>
                        </option> <?php } ?>
                      </select>
                      <button type="submit" class="btn btn-primary" id="btnFormNovoProdRec">Inserir</button>
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
                              <th data-toggle="tooltip" data-placement="left" title="Peso total da NF"> Descrição</th>
                              <th data-toggle="tooltip" data-placement="left" title="Total de volumes da NF"> Estado </th>
                              <th data-toggle="tooltip" data-placement="left" title="Tipo de volume"> Qtde </th>
                              <th data-toggle="tooltip" data-placement="left" title="Valor total da NF"> Vlr Unit.  </th>
                              <th data-toggle="tooltip" data-placement="left" title="Valor total da NF"> Peso Unit.  </th>
                            </tr>
                          </thead>
                          <tbody id="retProdNfItem">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="nserie">
                    <legend>Cadastre os números de série</legend>
                    <fieldset><br>
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="n_serie">Números de série:</label>
                        <form method="post" action="" id="formCadNs">
                          <div class="col-sm-12">
                            <input type="hidden" name="produto" value="<?php echo $produto; ?>">
                            <input type="hidden" name="cod_rec" value="<?php echo $cod_rec; ?>">
                            <input type="hidden" name="cod_estoque" value="<?php echo $cod_estoque; ?>">
                            <div class="row">
                              <div class="form-group">
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" name="n_serie" id="n_serie" align="right">
                                  <input type="text" class="form-control" name="n_serie1" id="n_serie1" align="right">
                                  <input type="text" class="form-control" name="n_serie2" id="n_serie2" align="right">
                                  <input type="text" class="form-control" name="n_serie3" id="n_serie3" align="right">
                                  <input type="text" class="form-control" name="n_serie4" id="n_serie4" align="right">
                                </div>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" name="n_serie5" id="n_serie5" align="right">
                                  <input type="text" class="form-control" name="n_serie6" id="n_serie6" align="right">
                                  <input type="text" class="form-control" name="n_serie7" id="n_serie7" align="right">
                                  <input type="text" class="form-control" name="n_serie8" id="n_serie8" align="right">
                                  <input type="text" class="form-control" name="n_serie9" id="n_serie9" align="right">
                                </div>
                              </div>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-primary" id="btnFormCadNs">Salvar</button>
                        </form>
                      </div>
                    </fieldset>
                  </div>
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
        $('#prod_recebimento').modal('show');
    });

</script>