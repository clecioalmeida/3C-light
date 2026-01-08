<?php
//session_start();

//$id_torre = $_POST['id_torre'];

require_once('bd_class_dsv.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

//$Mes = $_POST['thisMes'];
$produto = $_POST['cod_produto'];

$big_select="SET SQL_BIG_SELECTS=1";
$res_big=mysqli_query($link, $big_select);

$query_pedido="select t3.cod_prod_cliente, t2.nr_pedido, t2.produto, t2.dt_create, t3.nm_produto, t2.nr_qtde as saida
from tb_pedido_coleta_produto t2
left join tb_produto t3 on t2.produto = t3.cod_produto
where  t2.produto = '$produto' and t2.dt_create BETWEEN CURDATE() - INTERVAL 90 DAY AND CURDATE()";
$res_pedido=mysqli_query($link, $query_pedido);
$tr_pedido = mysqli_num_rows($res_pedido);

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
                    <h4 class="modal-title" id="myModalLabel" style="color: white">Nível de estoque - últimos 90 dias </h4>
                </div>
                <div class="modal-body modal-lg">
                    <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                            <div class="jarviswidget-editbox"></div>
                                <div class="widget-body no-padding">
                                    <table id="TbRelPedidoMes" class="table table-striped table-bordered table-hover">
                                        <thead>                         
                                            <tr>
                                                <th data-hide="phone"> Código SAP </th>
                                                <th data-class="expand"> Produto </th>
                                                <th data-class="expand"> Pedido </th>
                                                <th data-class="expand"> Data </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                while ($tipo=mysqli_fetch_assoc($res_pedido)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $tipo['cod_prod_cliente'] ;?></td>
                                                <td><?php echo $tipo['nm_produto'];?></td>
                                                <td><?php echo $tipo['nr_pedido'];?></td>
                                                <td><?php echo $tipo['dt_create'];?></td>
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