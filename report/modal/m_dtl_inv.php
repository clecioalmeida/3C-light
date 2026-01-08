<?php
require_once('../bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$dt_inv    = $_POST['dt_inv'];

$query_pedido = "select date_format(dt_inv, '%d/%m/%Y') as dt_inv, nr_qtd_ant, nr_qtd_at, nr_ac_qtd, nr_ac_end from tb_log_inv where dt_inv = '$dt_inv'";
$res_pedido = mysqli_query($link, $query_pedido);

$link->close();
?>
<div class="modal fade in" id="listPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding-right: 19px;">
    <form method="post" id="formCadPeca" action="">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <button type="submit" class="btn btn-success" id="mRelRecebidoMesGenExcel" style="float:right;margin-right: 10px;width: 100px">Excel</button>
                    <h4 class="modal-title" id="myModalLabel" style="color: white">DETALHAMENTO DE INVENTÁRIOS </h4>
                </div>
                <div class="modal-body modal-lg">
                    <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                        <div class="jarviswidget-editbox"></div>
                        <div class="widget-body no-padding">
                            <table id="TbRelPedidoMes" class="table table-striped table-bordered table-hover">
                                <thead>                         
                                    <tr>
                                        <th data-hide="phone"> DATA </th>
                                        <th data-class="expand"> QTDE ANTERIOR </th>
                                        <th data-class="expand"> QTDE ATUAL </th>
                                        <th data-class="expand"> AC. POR QTDE </th>
                                        <th data-class="expand"> AC. POR END. </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($tipo=mysqli_fetch_assoc($res_pedido)) {
                                        ?>
                                        <tr>
                                            <td style="text-align: center;"><?php echo $tipo['dt_inv'] ;?></td>
                                            <td style="text-align: right;"><?php echo $tipo['nr_qtd_ant'];?></td>
                                            <td style="text-align: right;"><?php echo $tipo['nr_qtd_at'];?></td>
                                            <td style="text-align: right;"><?php echo $tipo['nr_ac_qtd'];?></td>
                                            <td style="text-align: right;"><?php echo $tipo['nr_ac_end'];?></td>
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
        $('#listPedido').modal('show');
        return false;

    });
</script>