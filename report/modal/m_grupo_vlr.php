<?php
require_once('../bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_grp    = $_POST['cod_grp'];
$ds_mes     = $_POST['ds_mes'];

$query_pedido = "SELECT t2.nr_pedido, t2.produto, round(t2.nr_qtde_col,0) as nr_qtde, t4.nm_produto, format(t10.vl_unit,2,'de_De') as vl_unit, date_format(t2.dt_create,'%d/%m/%Y') as data_ped, UPPER(t7.ds_nome) as ds_nome, t9.nr_docto, date_format(t9.dt_docto,'%d/%m/%Y') as dt_docto, t7.cod_depto
from tb_coleta_pedido t2
left join tb_produto t4 on t2.produto = t4.cod_prod_cliente
left join tb_grupo t5 on t4.cod_grupo = t5.cod_grupo
left join tb_pedido_coleta t6 on t2.nr_pedido = t6.nr_pedido
left join tb_funcionario t7 on t6.cod_almox = t7.nr_matricula
left join tb_posicao_pallet t8 on t2.cod_estoque = t8.cod_estoque
left join tb_ca t9 on t8.cod_ca = t9.id
left join tb_pedido_coleta_produto t10 on t2.nr_pedido = t10.nr_pedido and t2.produto = t10.produto
where coalesce(t5.cod_grupo,0) = '$cod_grp' and month(t6.dt_create) = '$ds_mes' and t6.fl_status = 'F'
group by t2.nr_pedido, t2.produto, t6.cod_almox
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
                            <table id="TbRelPedidoMes" class="table" style="font-size: 12px">
                                <thead>                         
                                    <tr>
                                        <th> CÓD. REQUISIÇÃO </th>
                                        <th> C.R. </th>
                                        <th> DATA </th>
                                        <th> PRODUTO </th>
                                        <th> DESCRIÇÃO </th>
                                        <th> QTDE </th>
                                        <th> VALOR UNIT</th>
                                        <th> SOLICITANTE </th>
                                        <th> COD.CA </th>
                                        <th> DATA CA </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($tipo=mysqli_fetch_assoc($res_pedido)) {
                                        ?>
                                        <tr>
                                            <td class="mDtlPed" data-ped="<?php echo $tipo['nr_pedido'] ;?>" style="text-align: right;"><?php echo $tipo['nr_pedido'] ;?></td>
                                            <td style="text-align: right;"><?php echo $tipo['cod_depto'];?></td>
                                            <td style="text-align: center;"><?php echo $tipo['data_ped'];?></td>
                                            <td style="text-align: right;"><?php echo $tipo['produto'];?></td>
                                            <td><?php echo $tipo['nm_produto'];?></td>
                                            <td style="text-align: right;"><?php echo $tipo['nr_qtde'];?></td>
                                            <td style="text-align: right;"><?php echo $tipo['vl_unit'];?></td>
                                            <td><?php echo $tipo['ds_nome'];?></td>
                                            <td style="text-align: right;"><?php echo $tipo['nr_docto'];?></td>
                                            <td><?php echo $tipo['dt_docto'];?></td>
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