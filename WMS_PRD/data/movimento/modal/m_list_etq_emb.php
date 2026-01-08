<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_pedido = $_POST['nr_pedido'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$SQL = "select t1.dt_pedido, t1.dt_limite, t2.nm_cliente, t3.ds_doca, t3.fl_tipo
from tb_pedido_coleta t1
left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente
left join tb_doca t3 on t1.id_doca = t3.id
where t1.nr_pedido = '$cod_pedido'";
$res = mysqli_query($link, $SQL);
while ($dados = mysqli_fetch_assoc($res)) {
	$dt_pedido = $dados['dt_pedido'];
	$nm_cliente = $dados['nm_cliente'];
	$dt_limite = $dados['dt_limite'];
	$ds_doca = $dados['ds_doca'];
	$fl_tipo = $dados['fl_tipo'];
}

$SQL_prod = "select t1.*, t2.cod_prod_cliente, t2.nm_produto, t3.ds_tipo
from tb_pedido_manuseio t1
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_embalagem t3 on t1.id_embalagem = t3.id
where t1.nr_pedido = '$cod_pedido'";
$res_prod = mysqli_query($link, $SQL_prod);

$link->close();

?>
<div class="modal fade" id="iniciaManuseio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #8B1A1A">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          &times;
        </button>
        <h4 class="modal-title" id="myModalLabel" style="color:white">Imprime novas etiquetas</h4>
      </div>
      <div class="modal-body modal-lg">
        <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="prtEtq">
          <table class="table table-hover">
          <thead>
            <tr>
              <th style="width: 100px">PEDIDO</th>
                <th>COD SAP</th>
                <th>PRODUTO</th>
                <th>EMBALAGEM</th>
                <th style="text-align: right;">QTDE</th>
                <th style="text-align: center;">#</th>
            </tr>
          </thead>
          <tbody>
              <?php
while ($dados = mysqli_fetch_assoc($res_prod)) {?>
            <tr>
              <td style="text-align: center;width: 100px"><?php echo $dados['nr_pedido']; ?></td>
              <td><?php echo $dados['cod_prod_cliente']; ?></td>
              <td><?php echo $dados['nm_produto']; ?></td>
              <td><?php echo $dados['ds_tipo']; ?></td>
              <td style="text-align: right;"><?php echo $dados['qtd_vol']; ?></td>
              <td>
                <a href="data/movimento/relatorio/list_etq_man.php?cod_produto=<?php echo $dados['produto']; ?>" target="_blank"><button type="submit" id="btnPrintEtq" class="btn btn-primary btn-xs" value="">Etiqueta</button></a>
              </td>
            </tr>
            <?php }?>
          </tbody >
        </table>
        </article>
        </div>
      </div>
      <div class="modal-footer modal-lg" style="background-color: #8B1A1A">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          Cancelar
        </button>
        <button type="button" class="btn btn-primary" id="btnInitManuseio">
          Salvar
        </button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    $(document).ready(function () {
        $('#iniciaManuseio').modal('show');
    });
</script>