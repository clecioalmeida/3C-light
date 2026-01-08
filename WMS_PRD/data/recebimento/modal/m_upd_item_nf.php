 <?php 

  require_once('bd_class.php');
  $objDb = new db();
  $link = $objDb->conecta_mysql();

  $id_nfItem = $_REQUEST['id_nfItem'];

  $sql_estado = "select id, estado from tb_estado_produto";
  $res_estado = mysqli_query($link,$sql_estado);

  $query_prod="select t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t1.estado_produto, t1.nr_qtde, t1.vl_unit, t1.nr_peso_unit, t3.estado
  from tb_nf_entrada_item t1
  left join tb_produto t2 on t1.produto = t2.cod_produto
  left join tb_estado_produto t3 on t1.estado_produto = t3.id
  where t1.cod_nf_entrada_item = $id_nfItem";
  $res_prod = mysqli_query($link,$query_prod);
  while ($dados=mysqli_fetch_assoc($res_prod)) {
    $cod_produto=$dados['cod_produto'];
    $cod_prod_cliente=$dados['cod_prod_cliente'];
    $nm_produto=$dados['nm_produto'];
    $nr_qtde=$dados['nr_qtde'];
    $vl_unit=$dados['vl_unit'];
    $nr_peso_unit=$dados['nr_peso_unit'];
    $estado=$dados['estado'];
    $estado_produto=$dados['estado_produto'];
  }

$link->close();
?>
<div class="modal fade" id="updPrd" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Alterar produtos</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        
              <fieldset>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="produto">Cód. Produto</label>
                  <div class="col-sm-2">
                      <input type="text" class="form-control" value="<?php echo $cod_produto;?>" name="cod_produto" id="cod_produto" readonly="true">
                      <div class="form-control-focus"> </div>
                  </div>
                  <label class="col-sm-2 control-label" for="nm_fornecedor">Cód. SAP</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" value="<?php echo $cod_prod_cliente;?>" name="cod_prod_cliente" id="cod_prod_cliente" readonly="true">
                    <div class="form-control-focus"> </div>
                  </div>
                  <label class="col-sm-2 control-label" for="nm_produto">Descrição</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="nm_produto" value="<?php echo $nm_produto;?>" name="nm_produto" id="nm_produto" readonly="true">
                    <div class="form-control-focus"> </div>
                  </div>
                </div>
              </fieldset><br>
              <fieldset>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="qtde">Quantidade</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" name="nr_qtde_new" id="nr_qtde_new" value="<?php echo number_format($nr_qtde, 0, '.', '');?>">
                    <div class="form-control-focus"> </div>
                  </div>
                  <label class="col-sm-2 control-label" for="vlr_unit">Vlr. Unitário</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="vlr_unit" value="<?php echo $vl_unit;?>" name="vlr_unit" id="vlr_unit">
                    <div class="form-control-focus"> </div>
                  </div>
                  <label class="col-sm-2 control-label" for="peso_unit">Peso Unitário</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="nr_peso_unit" value="<?php echo $nr_peso_unit;?>" name="peso_unit" id="nm_produto">
                    <div class="form-control-focus"> </div>
                  </div>
                </div>
              </fieldset><br>
              <fieldset>                
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="estado_produto">Estado</label>
                  <select class="form-control" name="estado_produto_new" id="estado_produto_new" style="width: 150px">
                    <option value="<?php echo $estado_produto;?>" ><?php echo $estado;?></option>
                      <?php 
                        while($row_estado = mysqli_fetch_assoc($res_estado)) {
                      ?>
                    <option value="<?php echo $row_estado['id']; ?>">
                      <?php 
                        echo $row_estado['estado']; 
                      ?>
                    </option> <?php } ?>
                  </select>
                </div>
              </fieldset>
      </div>
      <div class="modal-footer modal-lg" style="background-color: #2F4F4F;">
        <input type="hidden" name="id_nfItem" id="id_nfItem" value="<?php echo $id_nfItem;?>">
        <button type="submit" class="btn btn-primary" id="btnSaveUpdPrdRec">Salvar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

      </div>
    </div>
  </div>
  </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#updPrd').modal('show');

/*
    $(document).on('change', '#cod_prod_cliente', function(){
            event.preventDefault();
            var cod_cliente = $('#cod_cliente').val();
              $.ajax({
                  url:"data/recebimento/consulta_prd_cod_cliente.php",
                  method:"POST",
                  data:{cod_cliente:cod_cliente},
                  success:function(j)
                {
                  $('input[name=nm_produto]').attr('value', j[i].nm_produto);
                }
                });
                return false;
            });

*/    
    });
</script>