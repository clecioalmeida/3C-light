<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_ns = mysqli_real_escape_string($link, $_POST["hist_ns"]);

$sql_ns = "select t1.*, t2.dt_recebimento_real, t2.cod_recebimento, t2.nm_fornecedor, t2.nm_transportadora, t2.dt_recebimento_real, t2.nm_user_recebido_por, t2.dt_descarregamento, t2.hr_descarregamento, t2.dt_user_conferido_por, t2.nm_user_conferido_por, t3.ds_galpao, t3.ds_prateleira, t3.ds_coluna, t3.ds_altura, t4.cod_cliente, t4.nr_pedido, t4.dt_pedido, t4.fl_status, t4.dt_entrega_real, t4.dt_carregamento, t4.hr_carregamento, t4.ds_modalidade, t5.nm_cliente, t6.nr_peso_afr, t6.nr_qtde, t6.nm_usuario_coleta, t6.dt_coleta
from tb_nserie t1
left join tb_recebimento t2 on t1.cod_rec = t2.cod_recebimento
left join tb_posicao_pallet t3 on t1.cod_estoque = t3.cod_estoque
left join tb_pedido_coleta t4 on t1.cod_pedido = t4.nr_pedido
left join tb_cliente t5 on t4.cod_cliente = t5.cod_cliente
left join tb_pedido_coleta_produto t6 on t4.nr_pedido = t6.nr_pedido
where t1.id = '$id_ns'";
$res_ns = mysqli_query($link, $sql_ns);
while ($dados_ns = mysqli_fetch_assoc($res_ns)) {
	$n_serie = $dados_ns['n_serie'];
	$dt_recebimento = $dados_ns['dt_recebimento_real'];
	$cod_recebimento = $dados_ns['cod_recebimento'];
	$nm_fornecedor = $dados_ns['nm_fornecedor'];
	$nm_transportadora = $dados_ns['nm_transportadora'];
	$dt_recebimento_real = $dados_ns['dt_recebimento_real'];
	$nm_user_recebido_por = $dados_ns['nm_user_recebido_por'];
	$dt_descarregamento = $dados_ns['dt_descarregamento'];
	$hr_descarregamento = $dados_ns['hr_descarregamento'];
	$dt_user_conferido_por = $dados_ns['dt_user_conferido_por'];
	$nm_user_conferido_por = $dados_ns['nm_user_conferido_por'];
	$ds_galpao = $dados_ns['ds_galpao'];
	$ds_prateleira = $dados_ns['ds_prateleira'];
	$ds_coluna = $dados_ns['ds_coluna'];
	$ds_altura = $dados_ns['ds_altura'];
	$nr_pedido = $dados_ns['nr_pedido'];
	$dt_pedido = $dados_ns['dt_pedido'];
	$fl_status = $dados_ns['fl_status'];
	$dt_recebimento_real = $dados_ns['dt_recebimento_real'];
	$nm_cliente = $dados_ns['nm_cliente'];
	$dt_entrega_real = $dados_ns['dt_entrega_real'];
	$dt_carregamento = $dados_ns['dt_carregamento'];
	$hr_carregamento = $dados_ns['hr_carregamento'];
	$ds_modalidade = $dados_ns['ds_modalidade'];
	$nr_peso_afr = $dados_ns['nr_peso_afr'];
	$nr_qtde_col = $dados_ns['nr_qtde'];
	$nm_usuario_coleta = $dados_ns['nm_usuario_coleta'];
	$dt_coleta = $dados_ns['dt_coleta'];
}

$link->close();
?>
<div class="modal fade" id="hist_ns" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2F4F4F;">
        <h5 class="modal-title" style="color: white">Histórico do número de série: <?php echo $n_serie; ?></h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
      </div>
      <div class="modal-body" style="overflow-y: auto">
            <div class="row">
              <div class="col-sm-12">
                <dl class="dl-horizontal">
                  <dt>Data de recebimento:</dt><dd> <?php
if ($dt_recebimento == 0) {
	echo '';
} else {
	echo date('d-m-Y', strtotime($dt_recebimento));
}?>
                  </dd>
                  <dt>Número da OR:</dt><dd> <?php echo $cod_recebimento; ?></dd>
                  <dt>Fornecedor:</dt><dd> <?php echo $nm_fornecedor; ?></dd>
                  <dt>Transportador:</dt><dd> <?php echo $nm_transportadora; ?></dd>
                  <dt>Recebido em:</dt><dd> <?php echo $dt_recebimento_real; ?></dd>
                  <dt>Recebido por:</dt><dd> <?php echo $nm_user_recebido_por; ?></dd>
                  <dt>Descarregado em:</dt><dd> <?php echo $dt_descarregamento . " " . $hr_descarregamento; ?></dd>
                  <dt>Conferido por:</dt><dd> <?php echo $nm_user_conferido_por; ?></dd>
                  <dt>Data da conferência:</dt><dd> <?php echo $dt_user_conferido_por; ?></dd>
                  <dt>Local:</dt><dd> <?php echo $ds_galpao; ?>, Rua <?php echo $ds_prateleira; ?>, Coluna <?php echo $ds_coluna; ?>, Altura <?php echo $ds_altura; ?></dd>
                </dl>
            </div>
          </div>
              <div class="row">
              <div class="col-sm-12">
                <dl class="dl-horizontal">
                  <dt>Número do pedido:</dt><dd> <?php echo $nr_pedido; ?></dd>
                  <dt>Data do pedido:</dt><dd><?php echo $dt_pedido; ?></dd>
                  <dt>Destinatário:</dt><dd> <?php echo $nm_cliente; ?></dd>
                  <dt>Status do pedido:</dt><dd> <?php echo $fl_status; ?></dd>
                  <dt>Data da entrega:</dt><dd> <?php
if ($dt_entrega_real == 0) {
	echo '';
} else {
	echo date('d-m-Y', strtotime($dt_entrega_real));
}?>
                  </dt>
                  <dt>Carregado em:</dt><dd> <?php echo $dt_carregamento . " " . $hr_carregamento; ?></dd>
                  <dt>Modal:</dt><dd> <?php echo $ds_modalidade; ?></dd>
                  <dt>Peso aferido:</dt><dd> <?php echo $nr_peso_afr; ?></dd>
                  <dt>Quantidade coletada:</dt><dd> <?php echo $nr_qtde_col; ?></dd>
                  <dt>Coletado por:</dt><dd> <?php echo $nm_usuario_coleta; ?></dd>
                  <dt>Coletado em:</dt><dd> <?php echo $dt_coleta; ?></dd>
                </dl>
              </div>
            </div>
          </div>

      <div class="modal-footer" style="background-color: #2F4F4F;">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
    </div>
        </div>
      </div>
  </div>
</div><!--Fim modal-->
<script>
    $(document).ready(function () {
        $('#hist_ns').modal('show');
    });
</script>