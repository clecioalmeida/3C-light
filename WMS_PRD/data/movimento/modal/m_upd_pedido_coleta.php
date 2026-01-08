<?php

require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
 
$id_pedido = $_POST['id_pedido'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);
/*
$select_pedido = "select * from tb_pedido_coleta_produto where nr_pedido = '$id_pedido' and fl_status <> 'F'";
$res_pedido = mysqli_query($link,$select_pedido);
while ($dados=mysqli_fetch_assoc($res_pedido)) {
  $nr_pedido=$dados['nr_pedido'];
}
*/
$select_local = "select t1.cod_col, t1.nr_pedido, t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, sum(t1.nr_qtde_col) as nr_qtde_col, t2.cod_prod_cliente, t2.nm_produto, t3.nome
from tb_coleta_pedido t1
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_armazem t3 on t1.ds_galpao = t3.id
where t1.nr_pedido = '$id_pedido' and t1.fl_status <> 'F' and t1.fl_status <> 'E' and t1.nr_qtde_col > 0
group by t1.cod_col
order by t2.cod_prod_cliente";
$res_local = mysqli_query($link,$select_local);
$link->close();
?>
<div class="modal fade" id="prdPedidoColeta" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Alterar local de coleta</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="codigo">Pedido</label>
            <div class="col-sm-2">
              <input type="text" class="form-control"  align="center" id="nr_pedido" name="nr_pedido" value="<?php echo $id_pedido; ?>" readonly="true">
              <div class="form-control-focus"> </div>
            </div>
          </div>
        </fieldset>
            <h5> Produtos e locais</h5>
            <hr/>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
              <thead>
                <tr>
                  <th> ID</th>
                  <th> Código SAP</th>
                  <th> Descrição </th>
                  <th> Galpão </th>
                  <th> Rua  </th>
                  <th> Coluna  </th>
                  <th> Altura  </th>
                  <th> Qtde reservada</th>
                  <th style="text-align:center;"> Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                while($dados_local = mysqli_fetch_assoc($res_local)) {?>												
                <tr class="odd gradeX">
                  <td><?php echo $dados_local['cod_col']; ?></td>
                  <td><?php echo $dados_local['cod_prod_cliente']; ?></td>
                  <td id="nm_produto"><?php echo $dados_local['nm_produto']; ?></td>
                  <td><?php echo $dados_local['nome']; ?></td>
                  <td id="ds_prateleira"><?php echo $dados_local['ds_prateleira']; ?></td>
                  <td id="ds_coluna"><?php echo $dados_local['ds_coluna']; ?></td>
                  <td id="ds_altura"><?php echo $dados_local['ds_altura']; ?></td>
                  <td id="nr_qtde"><?php echo $dados_local['nr_qtde_col']; ?></td>
                  <td style="text-align:center;"> 
                    <button type="submit" id="btnUpdEndPrdPed" class="btn btn-primary btn-xs" value="<?php echo $dados_local['cod_col']; ?>">Alterar
                    </button> 
                    <input type="hidden" name="ds_galpao" id="ds_galpao" value="<?php echo $dados_local['ds_galpao']; ?>">
                     <input type="hidden" name="nr_pedido" id="nr_pedido" value="<?php echo $dados_local['nr_pedido']; ?>">
                    <input type="hidden" name="cod_produto" id="cod_produto" value="<?php echo $dados_local['produto']; ?>">
                  </td>
                </tr> 
                <?php } ?>
              </tbody>
            </table>
          </div>
        <div class="modal-footer" style="background-color: #2F4F4F;">
        <!--button type="submit" class="btn btn-primary" id="btnFormNovoRec">Salvar</button-->
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
 </form>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#prdPedidoColeta').modal('show');
    });
</script>