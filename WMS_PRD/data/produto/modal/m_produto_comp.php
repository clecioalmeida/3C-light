<?php 

    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $prod_comp = mysqli_real_escape_string($link, $_POST["prod_comp"]);

    $sql_comp_prod = "select t1.cod_prod_cliente, t1.cod_produto, t1.nm_produto, t1.tp_separacao, t1.cod_cli, t1.cod_grupo, t1.cod_sub_grupo, t1.codncm, t1.fl_lote, t1.ean, t1.peso, t1.peso_bruto, t1.curva, t1.nr_estoque_min, t1.volume, t1.unid, t1.unid_controle, t1.altura, t1.compr, t1.largura, t1.cod_identificacao, t1.multiplo, t1.detalhe_produto, t1.id_armazem, t1.aloc_aut, t2.cod_cliente, t2.nm_cliente, t3.cod_grupo, t3.nm_grupo, t4.cod_sub_grupo, t4.nm_sub_grupo, t5.id, t5.nome 
    from tb_produto t1 
    left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente 
    left join tb_grupo t3 on t1.cod_grupo = t3.cod_grupo 
    left join tb_sub_grupo t4 on t1.cod_sub_grupo = t4.cod_sub_grupo 
    left join tb_armazem t5 on t1.id_armazem = t5.id where t1.fl_tipo_comp = 2 and t1.fl_comp = '$prod_comp'";
    $res_comp_prod = mysqli_query($link,$sql_comp_prod);

    
$link->close();
?>
<div class="modal fade" id="comp_produto" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Produtos do componente <?php echo $prod_comp; ?></h3></h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
        <div class="col-sm-12">
          <hr>
            <label><h4 style="color: white">Inserir novos produtos</h4></label>
            <form method="post" class="form-inline" action="" id="formNovoCompProduto">
                <div class="form-group">
                    <input type="text" class="form-control" name="cod_produto" id="cod_produto" placeholder="Código do produto">
                    <input type="text" class="form-control" name="nr_qtde_comp" id="nr_qtde_comp" placeholder="Quantidade">
                    <input type="hidden" class="form-control" name="prod_comp" value="<?php echo $prod_comp;?>" id="prod_comp">
                    <button type="button" class="btn btn-primary" value="<?php echo $prod_comp;?>" id="btnNovoProdutoComp">Inserir</button>
                </div>
            </form>
        </div>
      </div>
      <div class="modal-body" style="overflow-y: auto">
        <div id="produtoComp">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
              <thead>
                  <tr>
                      <th data-toggle="tooltip" data-placement="left" title="Código do cliente"> Código</th>
                      <th> Cód. Estoque </th>
                      <th> Produto </th>
                      <th> Detalhe </th>
                      <th> Grupo </th>
                      <th> Sub-grupo </th>
                  </tr>
              </thead>
              <tbody>
                  <?php                                                      
                      while($dados = mysqli_fetch_array($res_comp_prod)) {?>
                  <tr class="odd gradeX">
                      <td style="text-align: center; width: 10px"> <?php echo $dados['cod_prod_cliente']; ?> </td>
                      <td> <?php echo $dados['cod_produto']; ?> </td>
                      <td> <?php echo $dados['nm_produto']; ?> </td>
                      <td> <?php echo $dados['detalhe_produto']; ?> </td>
                      <td> <?php echo $dados['nm_grupo']; ?> </td>
                      <td> <?php echo $dados['nm_sub_grupo']; ?> </td>
                  </tr>
                  <?php } ?> 
              </tbody>
          </table>
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
        $('#comp_produto').modal('show');
    });
</script>