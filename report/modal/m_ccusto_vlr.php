<?php
require_once('../bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_cc    = $_POST['cod_cc'];
$ds_mes    = $_POST['ds_mes'];

$query_pedido = "SELECT coalesce(t4.ds_custo,0) as cod_depto, format(t2.nr_qtde,0,'de_De') as nr_qtde, format(t2.vl_unit,2,'de_De') as vl_unit,
date_format(t2.dt_create,'%d/%m/%Y') as dt_create, t3.nm_produto, t2.produto, t2.nr_pedido, upper(t5.ds_nome) as ds_nome, t5.cod_depto
from tb_pedido_coleta t4
left join tb_pedido_coleta_produto t2 on t2.nr_pedido = t4.nr_pedido
left join tb_produto t3 on t2.produto = t3.cod_prod_cliente
left join tb_funcionario t5 on t4.cod_almox = t5.nr_matricula
where t4.ds_custo = '".$cod_cc."' and month(t4.dt_create) = '".$ds_mes."' and t4.fl_status = 'F'
order by date(t2.dt_create)";
$res_pedido = mysqli_query($link, $query_pedido);

$link->close();
?>
<div class="modal fade in" id="listCcustoVlr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding-right: 19px;">
    <form method="post" id="formCadPeca" action="">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <button type="submit" class="btn btn-success" id="mRelRecebidoMesGenExcel" style="float:right;margin-right: 10px;width: 100px">Excel</button>
                    <h4 class="modal-title" id="myModalLabel" style="color: white">DETALHAMENTO DE REQUISIÇÕES </h4>
                </div>
                <div class="modal-body modal-lg">
                    <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                        <div class="jarviswidget-editbox"></div>
                        <div class="widget-body no-padding">
                            <table id="TbRelPedidoMes" class="table table-striped table-bordered table-hover">
                                <thead>                         
                                    <tr>
                                        <th data-hide="phone"> CÓD. REQUISIÇÃO </th>
                                        <th data-hide="phone"> C.R. </th>
                                        <th data-class="expand"> DATA </th>
                                        <th data-class="expand"> PRODUTO </th>
                                        <th data-class="expand"> DESCRIÇÃO </th>
                                        <th data-class="expand"> QTDE </th>
                                        <th data-class="expand"> VALOR UNIT</th>
                                        <th data-class="expand"> SOLICITANTE </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($tipo=mysqli_fetch_assoc($res_pedido)) {
                                        ?>
                                        <tr>
                                            <td style="text-align: right;"><?php echo $tipo['nr_pedido'] ;?></td>
                                            <td style="text-align: right;"><?php echo $tipo['cod_depto'];?></td>
                                            <td style="text-align: center;"><?php echo $tipo['dt_create'];?></td>
                                            <td style="text-align: right;"><?php echo $tipo['produto'];?></td>
                                            <td><?php echo $tipo['nm_produto'];?></td>
                                            <td style="text-align: right;"><?php echo $tipo['nr_qtde'];?></td>
                                            <td style="text-align: right;"><?php echo $tipo['vl_unit'];?></td>
                                            <td><?php echo $tipo['ds_nome'];?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>  
                    <div id="pedidos"></div>     
                </div>
                <div class="modal-footer" style="background-color: #2F4F4F;">
                    <button type="button" id="" class="btn btn-default" data-dismiss="modal">
                        Fechar
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div> <!--Fim Modal-->
<script type="text/javascript">
    $(document).ready(function(){
        $('#listCcustoVlr').modal('show');
        return false;

    });
</script>