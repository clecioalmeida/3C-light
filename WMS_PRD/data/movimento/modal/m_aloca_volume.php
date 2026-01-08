<?php 
//$cod_rec = $_GET['cod_rec'];
//$produto = $_GET['produto'];
//$alocacao = $_GET['alocacao'];

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_estoque = $_POST["cod_estoq"];

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

$select_produto = "select t1.produto, t2.nm_produto, t2.cod_produto, t2.cod_prod_cliente, t1.nr_qtde, t1.nr_or 
from tb_posicao_pallet t1 
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
where t1.cod_estoque = '$cod_estoque'";
$res_produto = mysqli_query($link,$select_produto);
while($dados_produto=mysqli_fetch_assoc($res_produto)){
  $nm_produto=$dados_produto["nm_produto"];
  $produto=$dados_produto["cod_prod_cliente"];
  $cod_produto=$dados_produto["cod_produto"];
  $cod_rec=$dados_produto["nr_or"];
  $nr_qtde=$dados_produto["nr_qtde"];
}

$select_alocado = "select sum(nr_qtde) as totalAlocado from tb_posicao_pallet where produto = '$produto' and nr_nf_entrada = '$cod_rec' and ds_galpao > 1";
$res_alocado = mysqli_query($link,$select_alocado);
while($sum_alocado=mysqli_fetch_assoc($res_alocado)){
  $totalalocado=$sum_alocado["totalAlocado"]." ITENS";
}

$sql_galpao = "SELECT distinct id, nome FROM tb_armazem";
$res_galpao = mysqli_query($link,$sql_galpao);
$link->close();
?>
<div class="modal fade" id="aloca_destino" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E;">
        <h5 class="modal-title" style="color: white">ALOCAÇÃO POR VOLUME</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="codigo">PRODUTO</label>
            <div class="col-sm-2">
              <input type="text" class="form-control"  align="center" id="codigo" name="produto" value="<?php echo $produto; ?>" readonly="true">
              <input type="hidden" class="form-control"  align="center" id="cod_produto" name="cod_produto" value="<?php echo $cod_produto; ?>" readonly="true">
              <div class="form-control-focus"> </div>
            </div>
            <label class="col-sm-2 control-label" for="descricao">DESCRIÇÃO</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="descricao" name="nm_produto" value="<?php echo $nm_produto; ?>" readonly="true">
              <div class="form-control-focus"> </div>
            </div>
          </div>
        </fieldset><br>
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="qtde">QUANTIDADE A ALOCAR</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" value="<?php echo $nr_qtde; ?>" align="center" id="nr_qtde_old" name="nr_qtde_old" readonly="true">
              <div class="form-control-focus"> </div>
            </div>
          </div>
        </fieldset><br/>
        <form method="post" action="" id="formAlocaVolume">
          <fieldset>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="alocar">QUANTIDADE</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="nr_qtde_new" id="nr_qtde_new">
                <input type="hidden" class="form-control" value="<?php echo $cod_rec; ?>" name="nr_or" id="nr_or">
                <input type="hidden" class="form-control" value="<?php echo $produto; ?>" name="produto" id="produto">
                <input type="hidden" id="cod_estoque" name="cod_estoque" value="<?php echo $cod_estoque; ?>">
                <div class="form-control-focus"> </div>
              </div>
              <label class="col-sm-2 control-label" for="qtde">VOLUMES</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="nr_vol_new" id="nr_vol_new">
              </div>
            </div>
          </fieldset>
          <fieldset>
          </form>
          <hr>
          <fieldset>
            <div class="row">
              <div class="col-sm-6">
                <h3> Quantidades alocadas:</h3>
              </div>
              <div class="col-md-6" style="padding-top: 15px;text-align: right;">
                <button style="text-align: left" class="btn btn-primary" data-toggle="modal" data-target="#lista_ns" style="width: 150px">Números de série</button>
                <button type="submit" class="btn btn-success btn-sm" id="btnFormAlocaVolume" style="width: 150px">Salvar</button>
              </div>
            </div>
          </fieldset>
          <hr/>
          <fieldset id="reg_table">
          </fieldset>
        </div>
        <div class="modal-footer" style="background-color: #22262E;">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
  $(document).ready(function () {
    $('#aloca_destino').modal('show');
    $('#reg_table').load("data/movimento/modal/list_aloc_modal.php?search=" ,{cod_estoq: $(this).val()});
  });
</script>