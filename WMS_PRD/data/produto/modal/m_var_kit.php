<?php 

    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $id_kit = mysqli_real_escape_string($link, $_POST["var_kit"]);

    $sql_kit_var = "select t1.*, t2.descricao, t3.nm_produto 
    from tb_kit_var t1
    left join tb_kit t2 on t1.id_kit = t2.id
    left join tb_produto t3 on t1.cod_estoque = t3.cod_produto and t1.cod_estoque_sbst = t3.cod_produto
    where t1.id_kit = '$id_kit'";
    $res_kit_var = mysqli_query($link,$sql_kit_var);

    $SQL = "select * from tb_kit where id = '$id_kit'";
    $res_kit = mysqli_query($link,$SQL);

    while ($dados = mysqli_fetch_assoc($res_kit)) {
    $descricao=$dados['descricao'];
}
    
$link->close();
?>
<div class="modal fade" id="kit_var" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
        <h5 class="modal-title" style="color: white">Variação de produtos do kit <h3 style="color: white"><?php echo $descricao; ?></h3></h5>
      </div>
      <div class="modal-body" style="overflow-y: auto">
        <div class="row">
            <div class="col-sm-12">
                <label><h4>Inserir novas variações de produtos</h4></label>
                <form method="post" class="form-inline" action="" id="formNovoKitVar">
                    <div class="form-group">
                        <input type="text" class="form-control" name="cod_estoque" id="cod_estoque" placeholder="Código do produto">
                        <input type="text" class="form-control" name="cod_estoque_sbst" id="cod_estoque_sbst" placeholder="Produto substituto">
                        <input type="hidden" class="form-control" name="id_kit" value="<?php echo $id_kit;?>" id="id_kit">
                        <button type="button" class="btn btn-primary" id="btnNovoVarKit" value="<?php echo $id_kit;?>">Inserir</button>
                    </div>
                </form>
            </div>
        </div><br>
        <div class="row">
            <div id="varKit">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                    <thead>
                        <tr>
                            <th> Código</th>
                            <th> Kit</th>
                            <th> Descrição </th>
                            <th> Produto </th>
                            <th> Produto substituto </th>
                            <th> Excluir </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php 
                            while($dados_kit_var = mysqli_fetch_assoc($res_kit_var)) {?>
                            <td><?php echo $dados_kit_var['id_kit_var']; ?></td>
                            <td><?php echo $dados_kit_var['id_kit']; ?></td>
                            <td><?php echo $dados_kit_var['descricao']; ?></td>
                            <td><?php echo $dados_kit_var['cod_estoque']; ?></td>
                            <td><?php echo $dados_kit_var['cod_estoque_sbst']; ?></td>
                            <td style="text-align: center">  
                                <a href="" data-toggle="modal" data-target="#"><span class="fa fa-minus-circle" aria-hidden="true" ></span></a>
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
<script>
    $(document).ready(function () {
        $('#kit_var').modal('show');
    });
</script>