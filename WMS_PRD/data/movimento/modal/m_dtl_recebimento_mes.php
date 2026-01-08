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

$query_recebimento="select * from tb_recebimento where MONTH(dt_recebimento_real) = '$Mes'";
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
                    <h4 class="modal-title" id="myModalLabel" style="color: white">Recebimentos emitidos em <?php
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
                                                <th data-hide="phone"> O.R. </th>
                                                <th data-class="expand"> Dt prevista </th>
                                                <th data-class="expand"> Dt recebiment </th>
                                                <th data-class="expand"> Situação </th>
                                                <th data-class="expand"> Dt descarregamento </th>
                                                <th data-class="expand"> Fornecedor </th>
                                                <th data-class="expand"> # </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                while ($tipo=mysqli_fetch_assoc($res_recebimento)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $tipo['cod_recebimento'] ;?></td>
                                                <td><?php echo $tipo['dt_recebimento_previsto'];?></td>
                                                <td><?php echo $tipo['dt_recebimento_real'];?></td>
                                                <td><?php echo $tipo['fl_status'];?></td>
                                                <td><?php echo $tipo['dt_descarregamento'];?></td>
                                                <td><?php echo $tipo['nm_fornecedor'];?></td>
                                                <td>
                                                    <button type="submit" id="btnDtlRecebidoMes" class="btn btn-primary btn-xs" value="<?php echo $tipo['cod_recebimento']; ?>">DETALHE</button>
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
            var mes = <?php echo $Mes;?>;
           $("#TbRelRecebidoMes").table2excel({
                exclude: ".noExl",
                name: "Recebimentos por mês - Analítico",
                filename: "Recebimentos por mês - Analítico - Mês-" + mes +" - Data-" + today //do not include extension
            });

        });

    });
</script>