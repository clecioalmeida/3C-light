<?php 
//$cod_rec = $_GET['cod_rec'];
//$produto = $_GET['produto'];
//$alocacao = $_GET['alocacao'];

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_estoque = mysqli_real_escape_string($link, $_POST["cod_estoq"]);

$select_produto = "select t1.produto, t1.nr_nf_entrada, t2.nm_produto 
from tb_posicao_pallet t1 
left join tb_produto t2 on t1.produto = t2.cod_produto 
where t1.cod_estoque = '$cod_estoque'";
    $res_produto = mysqli_query($link,$select_produto);
    while($dados_produto=mysqli_fetch_assoc($res_produto)){
        $nm_produto=$dados_produto["nm_produto"];
        $produto=$dados_produto["produto"];
        $cod_rec=$dados_produto["nr_nf_entrada"];
    }
$select_qtde = "select sum(nr_qtde) as total from tb_posicao_pallet where produto = '$produto' and nr_nf_entrada = '$cod_rec' and ds_galpao = 'RECEBIMENTO'";
    $res_qtde = mysqli_query($link,$select_qtde);
    while($sum_qtde=mysqli_fetch_assoc($res_qtde)){
        $totalqtde=$sum_qtde["total"];
    }

    $select_alocado = "select sum(nr_qtde) as totalAlocado from tb_posicao_pallet where produto = '$produto' and nr_nf_entrada = '$cod_rec' and ds_galpao not in ('RECEBIMENTO')";
    $res_alocado = mysqli_query($link,$select_alocado);
    while($sum_alocado=mysqli_fetch_assoc($res_alocado)){
        $totalalocado=$sum_alocado["totalAlocado"];
    }

$select_aloc = "select t1.cod_estoque, t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.nr_lote, t1.dt_validade, t1.dt_fabr, t1.nr_qtde, t1.ds_projeto, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t2.cod_prod_cliente
from tb_posicao_pallet t1 
left join tb_produto t2 on t1.produto = t2.cod_produto
where t1.produto = '$produto' and t1.nr_nf_entrada = '$cod_rec' and t1.ds_galpao not in ('RECEBIMENTO')";
    $res_aloc = mysqli_query($link,$select_aloc);

$select_aval = "select * from tb_avaliacao";
    $res_aval = mysqli_query($link,$select_aval);

$selec_ns = "select t1.*, t2.cod_prod_cliente from tb_nserie t1 left join tb_produto t2 on t1.id_produto = t2.cod_produto where t1.cod_rec = '$cod_rec' and t1.id_produto = '$produto'";
$res_ns = mysqli_query($link,$selec_ns);

$count_ns = "select count(n_serie) as total_ns from tb_nserie where cod_rec = '$cod_rec'";
$res_count = mysqli_query($link,$count_ns);
while ($count=mysqli_fetch_assoc($res_count)) {
  $ns_count = $count['total_ns'];
}

$sql_nserie = "select count(n_serie) from tb_nserie where cod_rec = '$cod_rec' and id_produto = '$produto'";
$res_count = mysqli_query($link,$count_ns);

$sql_galpao = "SELECT distinct id, nome FROM tb_armazem";
$res_galpao = mysqli_query($link,$sql_galpao);
?>
<div class="modal fade" id="aloca_destino" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Produtos aguardando alocação</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="codigo">Produto</label>
              <div class="col-sm-2">
                <input type="text" class="form-control"  align="center" id="codigo" name="produto" value="<?php echo $produto; ?>" readonly="true">
                <div class="form-control-focus"> </div>
              </div><br>
              <label class="col-sm-2 control-label" for="descricao">Descrição</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="descricao" name="nm_produto" value="<?php echo $nm_produto; ?>" readonly="true">
                  <div class="form-control-focus"> </div>
                </div>
            </div>
          </fieldset>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="qtde">Quantidade a alocar</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" value="<?php echo $totalqtde; ?>" align="center" id="qtde" name="nr_qtde_old" readonly="true">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </fieldset><br/>
          <form method="post" action="" id="formAlocacao">
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="alocar">Digite a quantidade que deseja alocar</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="nr_qtde" id="alocar">
                <input type="hidden" class="form-control" value="<?php echo $totalqtde; ?>" name="nr_qtde_old" id="nr_qtde_old">
                <input type="hidden" class="form-control" value="<?php echo $cod_rec; ?>" name="nr_nf_entrada" id="nr_nf_entrada">
                <input type="hidden" class="form-control" value="<?php echo $produto; ?>" name="produto" id="produto">
                <input type="hidden" name="alocacao" value="<?php echo $cod_estoque; ?>">
                <div class="form-control-focus"> </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="qtde">Tipo de avaliação</label>
              <div class="col-sm-4">
                <select class="form-control" name="id_aval">
                  <option>Selecione</option>
                    <?php                                                           
                    while($dados_aval=mysqli_fetch_assoc($res_aval)) {?>
                  <option value="<?php echo $dados_aval['id']; ?>">
                    <?php echo $dados_aval['nm_avaliacao']; ?>
                  </option> <?php } ?>
                </select>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="qtde">Projetos especiais</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="ds_projeto" align="center" id="ds_projeto">
                <div class="form-control-focus"> </div>
              </div>
            </div>
          </fieldset>
          <fieldset>
          <hr>
            <h5> Escolha o local de armazenagem</h5>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="galpao">Galpão</label>
              <div class="col-sm-4" id="armaz">
                <select class="form-control" name="ds_galpao" id="cmbarmaz">
                  <option>Galpão</option>
                    <?php 
                    while($dados_galpao = mysqli_fetch_assoc($res_galpao)) {?>
                  <option value="<?php echo $dados_galpao['id']; ?>">
                    <?php echo $dados_galpao['nome']; ?>
                  </option> <?php } ?>
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
            <button type="submit" class="btn btn-primary btn-sm" id="btnFormAlocacao">Salvar</button>
            <hr>
          </fieldset>
        </form>
          <fieldset>
            <div class="row">
              <div class="col-sm-9">
                <h3> Quantidades alocadas: <?php echo $totalalocado; ?> itens</h3>
              </div>
              <div class="col-md-2" style="padding-top: 15px">
                <button style="text-align: left" class="btn btn-primary" value="Consulta números de série alocados" data-toggle="modal" data-target="#lista_ns">Núm. de série alocados</button>
              </div>
            </div>
          </fieldset>
          <hr/>
          <fieldset>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
              <thead>
                <tr>
                  <th> Código SAP</th>
                  <th> Descrição </th>
                  <th> Galpão </th>
                  <th> Rua  </th>
                  <th> Coluna  </th>
                  <th> Altura  </th>
                  <th> Lote  </th>
                  <th> Fabricação  </th>
                  <th> Validade  </th>
                  <th> Qtde alocada  </th>
                  <th> N.S.  </th>
                </tr>
              </thead>
              <tbody>
                <?php 
                 while($dados_aloc = mysqli_fetch_array($res_aloc)) {
                   $cod_estoque = $dados_aloc['cod_prod_cliente'];
                ?>                        
                <tr class="odd gradeX">
                  <td style="width: 10%"> <?php echo $dados_aloc['cod_prod_cliente']; ?> </td>
                  <td style="width: 30%"> <?php echo $dados_aloc['nm_produto']; ?> </td>
                  <td style="width: 10%"> <?php echo $dados_aloc['ds_galpao']; ?> </td>
                  <td> <?php echo $dados_aloc['ds_prateleira']; ?> </td>
                  <td> <?php echo $dados_aloc['ds_coluna']; ?> </td>
                  <td> <?php echo $dados_aloc['ds_altura']; ?> </td>
                  <td> <?php echo $dados_aloc['nr_lote']; ?> </td>
                  <td> </td>
                  <td> </td>
                  <td> <?php echo $dados_aloc['nr_qtde']; ?> </td>
                  <td style="text-align: center; width: 5px">
                    <?php 
                      if($ns_count <= $dados_aloc['nr_qtde']){ ?>
                        <button type="submit" id="btnNovons" class="btn btn-primary btn-xs" value="<?php echo $dados_aloc['cod_estoque']; ?>">NS</button>
                    <?php }else{?>
                        <button type="submit" id="btnTotalok" class="btn btn-primary btn-xs" value="<?php echo $dados_aloc['cod_estoque']; ?>" data-toggle="tooltip" data-placement="left" title="Inserir número de série">NS</button>
                    <?php } ?>
                  </td>
                </tr>
                    <?php } ?>
               </tbody>
              </table>
            </fieldset>
      </div>
      <div class="modal-footer">
        <!--button type="submit" class="btn btn-primary" id="btnFormNovoRec">Salvar</button-->
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
 </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#aloca_destino').modal('show');
    });
</script>