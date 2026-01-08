<?php 

    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $id_kit = mysqli_real_escape_string($link, $_POST["prod_kit"]);

    $sql_kit_prod = "select t1.*, t2.cod_produto, t2.nm_produto, t3.descricao 
    from tb_kit_produto t1 
    left join tb_produto t2 on t1.cod_estoque = t2.cod_produto
    left join tb_kit t3 on t1.id_kit = t3.id
    where id_kit = '$id_kit'";
    $res_kit_prod = mysqli_query($link,$sql_kit_prod);

    $SQL = "select * from tb_kit where id = '$id_kit'";
    $res_kit = mysqli_query($link,$SQL);

    while ($dados = mysqli_fetch_assoc($res_kit)) {
    $descricao=$dados['descricao'];
}
 
$link->close();   
?>
<div class="modal fade" id="kit_produto" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
        <h5 class="modal-title" style="color: white">Produtos do kit <h3 style="color: white"><?php echo $descricao; ?></h3></h5>
      </div>
      <div class="modal-body" style="overflow-y: auto">
        <div class="row">
          <div class="col-sm-12">
              <label><h4>Inserir novos produtos</h4></label>
              <form method="post" class="form-inline" action="" id="formNovoKitProduto">
                  <div class="form-group">
                      <input type="text" class="form-control" name="cod_estoque" id="cod_estoque" placeholder="Código do produto">
                      <input type="text" class="form-control" name="quantidade" id="quantidade" placeholder="Quantidade">
                      <input type="hidden" class="form-control" name="id_kit" value="<?php echo $id_kit;?>" id="id_kit">
                      <button type="button" class="btn btn-primary" id="btnNovoProdutoKit" value="<?php echo $id_kit;?>">Inserir</button>
                  </div>
              </form>
          </div>
        </div><br>
        <div class="row">
          <div id="produtoKit">
              <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                <thead>
                  <tr>
                    <th> Código kit</th>
                    <th> Qtde </th>
                    <th> Descrição </th>
                    <th> Grupo </th>
                    <th> Subgrupo </th>
                    <th> Segurança </th>
                    <th> Estoque </th>
                    <th colspan="2"> Ações </th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                          while($dados_kit_prod = mysqli_fetch_assoc($res_kit_prod)) {
                      ?>
                  <tr>
                    <td> <?php echo $dados_kit_prod['id_kit_produto']; ?> </td>
                    <td style="width: 10px"> <?php echo $dados_kit_prod['quantidade']; ?> </td>
                    <td> <?php echo $dados_kit_prod['nm_produto']; ?> </td>
                    <td style="width: 20px">  </td>
                    <td style="width: 10px">  </td>
                    <td style="width: 10px">  </td>
                    <td style="width: 10px">  </td>
                    <td style="text-align: center; width: 5px">
                      <button type="submit" id="btnSolRep" class="btn btn-primary btn-xs" value="<?php echo $dados_kit_prod['id_kit_produto']; ?>">Repor</button>
                    </td>
                    <td style="text-align: center; width: 5px">
                      <button type="submit" id="btnDelRep" class="btn btn-primary btn-xs" value="<?php echo $dados_kit_prod['id_kit_produto']; ?>">Excluir</button> 
                    </td>
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
<?php include'sol_rep_produto.php';?>
<script>
    $(document).ready(function () {
        $('#kit_produto').modal('show');
    });
</script>