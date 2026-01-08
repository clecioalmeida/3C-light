<?php
require_once('../bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_grp    = $_POST['cod_grupo'];

$query_pedido = "SELECT t2.nr_pedido, t2.produto, round(t2.nr_qtde,0) as nr_qtde, format(t2.vl_unit,2,'de_De') as vl_unit, t4.nm_produto, date_format(t2.dt_create,'%d/%m/%Y') as data_ped, UPPER(t7.ds_nome) as ds_nome, format((t2.vl_unit*t2.nr_qtde),2,'de_De') as vlr_total, t6.ds_custo, t7.cod_depto
from tb_pedido_coleta_produto t2
left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
left join tb_grupo t5 on t4.cod_grupo = t5.cod_grupo
left join tb_pedido_coleta t6 on t2.nr_pedido = t6.nr_pedido
left join tb_funcionario t7 on t6.cod_almox = t7.nr_matricula
where coalesce(t5.cod_grupo,0) = '$cod_grp' and t2.fl_status = 'F'
order by date(t2.dt_create)";
$res_pedido = mysqli_query($link, $query_pedido);

$link->close();
?>
<div class="modal fade in" id="listPedidoVlr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding-right: 19px;">
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
                                        <th data-class="expand"> CR </th>
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
                                            <td style="text-align: center;"><?php echo $tipo['data_ped'];?></td>
                                            <td style="text-align: right;"><?php echo $tipo['ds_custo'] ;?></td>
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
        $('#listPedidoVlr').modal('show');
        return false;

    });
</script>