<?php
//session_start();

//$id_torre = $_POST['id_torre'];

require_once('bd_class_dsv.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

//$Mes = $_POST['thisMes'];
$thisProduto = $_POST['thisProduto'];

$big_select="SET SQL_BIG_SELECTS=1";
$res_big=mysqli_query($link, $big_select);

$query_recebimento="select t3.cod_prod_cliente, t2.produto, t3.nm_produto, sum(t1.nr_qtde) as saldo, sum(t2.nr_qtde) as saida, sum(t2.nr_qtde/90) as nivel, count(distinct t2.nr_pedido) as freq
from tb_posicao_pallet t1
left join tb_pedido_coleta_produto t2 on t1.produto = t2.produto
left join tb_produto t3 on t1.produto = t3.cod_produto
where t1.produto > 0 and  t2.dt_create BETWEEN CURDATE() - INTERVAL 90 DAY AND CURDATE()
group by t1.produto
order by count(distinct t2.nr_pedido) desc";
$res_recebimento=mysqli_query($link, $query_recebimento);
$tr_recebimento = mysqli_num_rows($res_recebimento);

$link->close();
?>
<div class="modal fade in" id="dtlPedidoMes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding-right: 19px;">
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
                                                <th data-class="expand"> Saldo </th>
                                                <th data-class="expand"> Exp. ou reservados </th>
                                                <th data-class="expand"> Nível de estoque </th>
                                                <th data-class="expand"> Indice de curva </th>
                                                <th data-class="expand"> # </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                while ($tipo=mysqli_fetch_assoc($res_recebimento)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $tipo['cod_prod_cliente'] ;?></td>
                                                <td><?php echo $tipo['nm_produto'];?></td>
                                                <td><?php echo $tipo['saldo'];?></td>
                                                <td><?php echo $tipo['saida'];?></td>
                                                <td><?php echo $tipo['nivel'];?></td>
                                                <td><?php echo $tipo['freq'];?></td>
                                                <td>
                                                    <button type="submit" id="btnListPedidos" class="btn btn-primary btn-xs" value="<?php echo $tipo['produto']; ?>">PEDIDOS</button>
                                                </td>
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
        $('#dtlPedidoMes').modal('show');

        $(document).on('click', '#mRelRecebidoMesGenExcel', function(){
            event.preventDefault();
            var today = new Date();
           $("#TbRelRecebidoMes").table2excel({
                exclude: ".noExl",
                name: "Nível de estoque - produtos por curva",
                filename: "Nível de estoque - produtos por curva - Data:" + today //do not include extension
            });

        });

    });
</script>