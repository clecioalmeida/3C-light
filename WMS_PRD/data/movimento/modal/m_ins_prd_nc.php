<?php
//$cod_rec = $_GET['cod_rec'];
//$produto = $_GET['produto'];
//$alocacao = $_GET['alocacao'];

require_once 'bd_class_dsv.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

//$cod_estoque = mysqli_real_escape_string($link, $_POST["cod_estoq"]);

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$sql_galpao = "SELECT distinct id, nome FROM tb_armazem";
$res_galpao = mysqli_query($link, $sql_galpao);

$sql_galpao_new = "SELECT distinct id, nome FROM tb_armazem";
$res_galpao_new = mysqli_query($link, $sql_galpao_new);
$link->close();
?>
<div class="modal fade" id="aloca_destino" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Inclusão de produtos não-conforme</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
          <fieldset>
            <div>
              <h5 style="float: left"> Selecione o local e o produto</h5>

            </div>
          </fieldset>
          <hr>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="galpao">Produto</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="produtoNc" id="produtoNc" placeholder="Digite o código SAP do produto">
              </div>
            </div>
          </fieldset>
          <hr>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="galpao">Galpão</label>
              <div class="col-sm-4" id="armaz">
                <select class="form-control" name="ds_galpao" id="cmbarmaz">
                  <option>Galpão</option>
                    <?php
while ($dados_galpao = mysqli_fetch_assoc($res_galpao)) {?>
                  <option value="<?php echo $dados_galpao['id']; ?>">
                    <?php echo $dados_galpao['nome']; ?>
                  </option> <?php }?>
                </select>
              </div>
              <label class="col-sm-2 control-label" for="rua">Rua</label>
              <div class="col-sm-4" id="rua">
                <select class="form-control" name="ds_prateleira" id="cmbrua">
                  <option value=""></option>
                </select><br>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="coluna">Coluna</label>
              <div class="col-sm-4" id="coluna">
                <select class="form-control" name="ds_coluna" id="cmbcoluna">
                  <option></option>
                </select>
              </div>
              <label class="col-sm-2 control-label" for="id_altura">Altura</label>
              <div class="col-sm-4" id="altura">
                <select class="form-control" name="ds_altura" id="cmbaltura">
                  <option></option>
                </select>
              </div>
            </div>

            <hr>
          </fieldset><br>
          <fieldset>
              <button type="submit" class="btn btn-primary btn-sm" id="btnPesqProdNc" style="float: left;">Pesquisar</button>
          </fieldset>
          <fieldset>
            <div class="row">
              <!--div class="col-sm-9">
                <h3> Quantidades alocadas: <?php echo $totalalocado; ?> itens</h3>
              </div-->
              <!--div class="col-md-2" style="padding-top: 15px">
                <button style="text-align: left" class="btn btn-primary" value="Consulta números de série alocados" data-toggle="modal" data-target="#lista_ns">Núm. de série alocados</button>
              </div-->
            </div>
          </fieldset>
          <hr/>
          <fieldset>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
              <thead>
                <tr>
                  <th> Código</th>
                  <th> Código SAP</th>
                  <th> Descrição </th>
                  <th> Local </th>
                  <th> Qtde alocada  </th>
                  <th> Qtde a transferir  </th>
                </tr>
              </thead>
              <tbody id="retPesqProdNc">
               </tbody>
              </table>
            </fieldset>
            <fieldset>
              <h2 id="retExpEnd"></h2>
              <div class="produto">
                <legend>Selecione endereço</legend>

                <fieldset>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="galpao">Galpão</label>
                    <div class="col-sm-4" id="armaz">
                      <select class="form-control" name="ds_galpao" id="cmbarmaz_new">
                        <option>Galpão</option>
                          <?php
while ($dados_galpao_new = mysqli_fetch_assoc($res_galpao_new)) {?>
                        <option value="<?php echo $dados_galpao_new['id']; ?>">
                          <?php echo $dados_galpao_new['nome']; ?>
                        </option> <?php }?>
                      </select>
                    </div>
                    <label class="col-sm-2 control-label" for="rua">Rua</label>
                    <div class="col-sm-4" id="rua">
                      <select class="form-control" name="ds_prateleira" id="cmbrua_new">
                        <option value=""></option>
                      </select><br>
                    </div>
                  </div>
                </fieldset>
                <fieldset>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="coluna">Coluna</label>
                    <div class="col-sm-4" id="coluna">
                      <select class="form-control" name="ds_coluna" id="cmbcoluna_new">
                        <option></option>
                      </select>
                    </div>
                    <label class="col-sm-2 control-label" for="id_altura">Altura</label>
                    <div class="col-sm-4" id="altura">
                      <select class="form-control" name="ds_altura" id="cmbaltura_new">
                        <option></option>
                      </select>
                    </div>
                  </div>
                  <hr>
                </fieldset>
                <fieldset>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="galpao">Motivo</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="motivoNc" id="motivoNc" placeholder="Digite o motivo da não-conformidade" required="true">
                    </div>
                  </div>
                </fieldset>
                <br>
                <fieldset>
                    <button type="submit" class="btn btn-success btn-sm" id="btnInsNewPrdNc" style="float: left;">Salvar</button>
                </fieldset>
              </div>
            </fieldset>
      </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
 </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#aloca_destino').modal('show');
        $('.produto').hide();
    });
</script>