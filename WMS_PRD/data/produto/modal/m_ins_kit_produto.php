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
<div class="modal fade" id="novo_produto" aria-hidden="true">
    <form method="post" action="" id="formNovoKitProduto">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <h5 class="modal-title" id="novo_subgrupo" style="color: white">Incluir produtos no kit <h2><?php echo $descricao;?></h2></h5>
                    <input type="hidden" name="id_kit" value="<?php echo $id_kit?>">
                    <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                    <fieldset>
                      <label class="col-sm-2 control-label" for="cod_grupo">Produto</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="cod_estoque" id="cod_estoque">
                        <div class="form-control-focus"> </div>
                       </div>
                    </fieldset>
                    <fieldset>
                     <label class="col-sm-2 control-label" for="quantidade">Quantidade</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="quantidade" id="quantidade">
                            <input type="hidden" class="form-control" name="id_kit" value="<?php echo $id_kit;?>" id="id_kit">
                            <div class="form-control-focus"> </div>
                        </div> 
                    </fieldset>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #2F4F4F;">
                    <button type="submit" class="btn btn-primary" id="btnFormKitProduto">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#novo_produto').modal('show');
    });
</script>