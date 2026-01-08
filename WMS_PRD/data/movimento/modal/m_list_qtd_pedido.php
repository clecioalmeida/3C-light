<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_peiddo = $_POST['nr_pedido'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$SQL_prod = "select t1.nr_pedido, t1.produto, sum(t1.nr_qtde) as qtde_sol, sum(COALESCE(t3.nr_qtde_col,0)) as qtde_find, sum(COALESCE(t2.nr_qtde,0)) as qtde_sep, (sum(t1.nr_qtde)-sum(COALESCE(t2.nr_qtde,0))) as diff
from tb_pedido_coleta_produto t1
left join tb_pedido_conferencia t2 on t1.nr_pedido = t2.nr_pedido and t1.produto = t2.produto
left join tb_coleta_pedido t3 on t1.nr_pedido = t3.nr_pedido and t1.produto = t3.produto
where t1.nr_pedido = '$nr_pedido' group by t1.produto order by t1.produto";
$res_prod = mysqli_query($link, $SQL_prod);

$link->close();

?>
<script src="js/libs/jquery-2.1.1.min.js"></script>
<div class="modal fade" id="aloca_destino" aria-hidden="true">
 <form method="post" action="" id="formNovoRec">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #22262E;">
        <h5 class="modal-title" style="color: white">Produtos aguardando alocação</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body modal-lg" style="overflow-y: auto">
        <div class="row">
          <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="prtEtq">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th style="width: 100px">PEDIDO</th>
                  <th>QTDE SOLICITADA</th>
                  <th>QTDE ENCONTRADA</th>
                  <th>QTDE SEPARADA</th>
                  <th>DIFERENÇA</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($dados = mysqli_fetch_assoc($res_prod)) {?>
                  <tr>
                    <td style="text-align: center;width: 100px"><?php echo $dados['nr_pedido']; ?></td>
                    <td><?php echo $dados['qtde_sol']; ?></td>
                    <td><?php echo $dados['qtde_find']; ?></td>
                    <td><?php echo $dados['qtde_sep']; ?></td>
                    <td><?php echo $dados['diff']; ?></td>
                  </tr>
                <?php }?>
              </tbody >
            </table>
          </article>
        </div>
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
  });
</script>