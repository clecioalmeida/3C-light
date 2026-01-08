<?php 

    require_once('bd_class.php');
    $objDb = new db();
    $link = $objDb->conecta_mysql();

    $sol_rep = mysqli_real_escape_string($link, $_POST["sol_rep"]);

    $sql_kit_prod = "select t1.*, t2.cod_produto, t2.nm_produto, t3.descricao 
    from tb_kit_produto t1 
    left join tb_produto t2 on t1.cod_estoque = t2.cod_produto
    left join tb_kit t3 on t1.id_kit = t3.id
    where id_kit = '$sol_rep'";
    $res_kit_prod = mysqli_query($link,$sql_kit_prod);

    while ($dados = mysqli_fetch_assoc($res_kit_prod)) {
    $id_kit=$dados['id_kit'];
    $cod_prod_cliente=$dados['cod_prod_cliente'];
    $cod_produto=$dados['cod_produto'];
    $codncm=$dados['codncm'];
    $quantidade=$dados['quantidade'];
}

$link->close();    
?>
<div class="modal fade" id="rep_kit" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Solicitação de reposição de produtos</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body" style="overflow-y: auto">
            <div class="form-group">
                <label class="col-sm-2 control-label" for="kit">Kit</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="kit" value="<?php echo $id_kit;?>" placeholder="Kit">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="p_cliente">Cód. Cliente</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="p_cliente" value="<?php echo $cod_prod_cliente;?>" placeholder="Cód. Cliente">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="p_estoque">Cód. Estoque</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="p_estoque" value="<?php echo $cod_produto;?>" placeholder="Cód. Estoque">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-sm-2 control-label" for="p_ncm">Cód. NCM</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="p_ncm" value="<?php echo $codncm;?>" placeholder="NCM">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="p_peso_l">Quantidade</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="p_peso_l" value="<?php echo $quantidade;?>" placeholder="Peso líquido">
                    <div class="form-control-focus"> </div>
                </div>
                <label class="col-md-2 control-label" for="p_motivo">Motivo</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="p_motivo" placeholder="Motivo">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="p_observacao">Observações</label>
                <div class="col-sm-4 form-md">
                    <input type="text" class="form-control" id="p_dobservacao" placeholder="Observações">
                    <div class="form-control-focus"> </div>
                </div>
            </div>
      </div>
      <div class="modal-footer" style="background-color: #2F4F4F;">
          <button type="button" class="btn blue">Salvar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
    </div>
  </div>
</div><!--Fim modal-->