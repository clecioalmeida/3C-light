<?php
//session_start();

//$id_torre = $_POST['id_torre'];

require_once('bd_class_dsv.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$Mes = $_POST['thisMes'];
$Total = $_POST['thisTotal'];

$big_select="SET SQL_BIG_SELECTS=1";
$res_big=mysqli_query($link, $big_select);

$query_pedido="select * from tb_pedido_coleta where MONTH(dt_pedido) = '$Mes'";
$res_pedido=mysqli_query($link, $query_pedido);
$tr_pedido = mysqli_num_rows($res_pedido);

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
                    <button type="submit" class="btn btn-success" id="mRelPedidoMesGenExcel" style="float:right;margin-right: 10px;width: 100px">Excel</button>
                    <h4 class="modal-title" id="myModalLabel" style="color: white">Pedidos emitidos em <?php
                                                                                    if($Mes==1){
                                                                                        echo "Janeiro";
                                                                                    }elseif($Mes==2){
                                                                                        echo "Fevereiro";
                                                                                    }elseif($Mes==3){
                                                                                        echo "Março";
                                                                                    }elseif($Mes==4){
                                                                                        echo "Abril";
                                                                                    }elseif($Mes==5){
                                                                                        echo "Maio";
                                                                                    }elseif($Mes==6){
                                                                                        echo "Junho";
                                                                                    }elseif($Mes==7){
                                                                                        echo "Julho";
                                                                                    }elseif($Mes==8){
                                                                                        echo "Agosto";
                                                                                    }elseif($Mes==9){
                                                                                        echo "Setembro";
                                                                                    }elseif($Mes==10){
                                                                                        echo "Outubro";
                                                                                    }elseif($Mes==11){
                                                                                        echo "Novembro";
                                                                                    }elseif($Mes==12){
                                                                                        echo "Dezembro";
                                                                                    }

                                                                                                        ?>
                </h4>
                </div>
                <div class="modal-body modal-lg">
                    <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                            <div class="jarviswidget-editbox"></div>
                                <div class="widget-body no-padding">
                                    <table id="TbRelPedidoMes" class="table table-striped table-bordered table-hover">
                                        <thead>                         
                                            <tr>
                                                <th data-hide="phone"> Pedido </th>
                                                <th data-class="expand"> Data </th>
                                                <th data-class="expand"> Situação </th>
                                                <th data-class="expand"> Dt limite </th>
                                                <th data-class="expand"> Dt carregamento </th>
                                                <th data-class="expand"> Dt entrega </th>
                                                <th data-class="expand"> # </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                while ($tipo=mysqli_fetch_assoc($res_pedido)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $tipo['nr_pedido'] ;?></td>
                                                <td><?php echo $tipo['dt_pedido'];?></td>
                                                <td><?php echo $tipo['fl_status'];?></td>
                                                <td><?php echo $tipo['dt_limite'];?></td>
                                                <td><?php echo $tipo['dt_carregamento'];?></td>
                                                <td><?php echo $tipo['dt_entrega_real'];?></td>
                                                <td>
                                                    <button type="submit" id="btnDtlPedidoMes" class="btn btn-primary btn-xs" value="<?php echo $tipo['nr_pedido']; ?>">DETALHE</button>
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

        $(document).on('click', '#mRelPedidoMesGenExcel', function(){
            event.preventDefault();
            var today = new Date();
            var mes = <?php echo $Mes;?>;
           $("#TbRelPedidoMes").table2excel({
                exclude: ".noExl",
                name: "Pedidos emitidos por mês - Analítico",
                filename: "Pedidos emitidos por mês - Analítico - Mês-" + mes +" - Data-" + today //do not include extension
            });

        });

    });
</script>