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
            <legend>Ordem de recebimento
              <!--form method="post" action="data/recebimento/relatorio/list_etq_rec.php">
                <input type="hidden" name="BarcodeRec" value="<?php echo $id_rec;?>">
                <button type="submit" id="btnPrintEtqRec" class="btn btn-success btn-xs" value="">Código de barras</button>
              </form-->
             <!--a href="data/recebimento/relatorio/list_etq_rec.php?cod_produto=<?php echo $estoque['cod_produto'];?>&cod_red=<?php echo $estoque['ds_prateleira'];?>&cod_nf=<?php echo $estoque['ds_coluna'];?>" target="_blank" style="float:right;"><button type="submit" id="btnPrintEtqRec" class="btn btn-success btn-xs" value="">Código de barras</button></a-->
            </legend>
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
              </fieldset><hr>
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
          </div><hr>
          <legend>Insira os produtos</legend>
          <div class="row">
            <form method="post" class="form-inline" action="" id="formNovoProdRec">
            <!--label class="control-label" for="or">Digite o código do produto</label-->
              <input type="hidden" class="form-control" id="cod_nf_entrada" name="cod_nf_entrada" value="<?php echo $cod_nf_entrada;?>">
              <input type="text" class="form-control" id="cod_produto" name="cod_produto" placeholder="Código" style="width: 150px">
              <input type="text" class="form-control" id="cod_prod_cliente" name="cod_prod_cliente" placeholder="Código SAP" style="width: 150px">    
              <!--label class="control-label" for="or">Quantidade</label-->
              <input type="text" class="form-control" id="nr_qtde" name="nr_qtde" placeholder="Quantidade" style="width: 100px">
              <!--label class="control-label" for="or">Valor unitário</label-->
              <input type="text" class="form-control" id="vl_unit" name="vl_unit" placeholder="Valor unitário" style="width: 100px">
              <!--label class="control-label" for="or">Peso total</label-->
              <input type="text" class="form-control" id="nr_peso_ent" name="nr_peso_ent" placeholder="Peso total (kg)" style="width: 100px">
              <select class="form-control" id="estado_produto" style="width: 150px">
                <option>Estado</option>
                  <?php 
                    while($row_estado = mysqli_fetch_assoc($res_estado)) {
                  ?>
                <option value="<?php echo $row_estado['id']; ?>">
                  <?php 
                    echo $row_estado['estado']; 
                  ?>
                </option> <?php } ?>
              </select>
              <button type="submit" class="btn btn-primary" id="btnFormNovoProdRec" style="float: right;margin-right: 10px">Inserir</button>
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
                    while($dados_prdNf=mysqli_fetch_assoc($res_nf_item)) {
                  ?>
                  <tr>
                    <td style="text-align: center; width: 5px"><button type="submit" id="btnUpdNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados_prdNf['cod_nf_entrada_item'];?>">Alterar</button></td>
                    <td style="text-align: center; width: 5px"><button type="submit" id="btnDelPrdNfrec" class="btn btn-primary btn-xs" value="<?php echo $dados_prdNf['cod_nf_entrada_item'];?>">Excluir</button></td>
                    <td style="text-align: center; width: 5px"><button type="submit" id="btnNsPrdrec" class="btn btn-primary btn-xs" value="<?php echo $dados_prdNf['cod_nf_entrada'];?>">N.Série</button></td>
                    <td><?php echo $dados_prdNf['cod_nf_entrada'];?></td>
                    <td><?php echo $dados_prdNf['nr_fisc_ent'];?></td>
                    <td><?php echo $dados_prdNf['cod_produto'];?></td>
                    <td><?php echo $dados_prdNf['nm_produto'];?></td>
                    <td style="text-align: right;"><?php echo $dados_prdNf['estado'];?></td>
                    <td style="text-align: right;"><?php echo $dados_prdNf['nr_qtde'];?></td>
                    <td style="text-align: right;"><?php echo $dados_prdNf['vl_unit'];?></td>
                    <td style="text-align: right;"><?php echo $dados_prdNf['nr_peso_unit'];?></td>
                  </tr>
                  <?php } ?>
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
        $('#prod_recebimento').modal('show');
/*
        $(document).on('click', '#btnPrintEtq', function(){
            event.preventDefault();
            var cod_produto = $(this).val();
              $.ajax({
                  url:"data/recebimento/relatorio/list_etq_rec.php",
                  method:"POST",
                  data:{cod_produto:cod_produto},
                  success:function(data)
                {
                  $('#retornoPrd').html(data);
                   }
                });
                return false;
            });
*/    
    });

</script>