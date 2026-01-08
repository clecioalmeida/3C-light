<?php
session_start();    
?>
<?php

if(!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])){

  header("Location:index.php");
  exit;

}else{

  $id=$_SESSION["id"];
  $cod_cli    = $_SESSION["cod_cli"];
}
?>
<?php
require_once('bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$data = $_POST['thisData'];

$big_select="SET SQL_BIG_SELECTS=1";
$res_big=mysqli_query($link, $big_select);

$query_pedido="select t1.nr_pedido, t1.cod_almox, t2.ds_almox, date_format(t1.dt_create,'%d/%m/%Y') as dt_create, t1.fl_status
from tb_pedido_coleta t1
left join tb_almox t2 on t1.cod_almox = t2.cod_almox
where t1.fl_status <> 'E' and t1.fl_status <> 'F' and t1.fl_empresa = '$cod_cli' and date_format(t1.dt_create,'%d/%m/%Y') = '$data'";
$res_pedido=mysqli_query($link, $query_pedido);

$link->close();
?>
<style type="text/css">
    .ocupado {
        background-color: #F4A460;
    }

    .livre {
        background-color: #7FFFD4;
    }

    .alerta {
        background-color: #EEDD82;
    }

    .finalizado {
        background-color: #ADD8E6;
    }

    .expedido {
        background-color: #8FBC8F;
    }

    .expedicao {
        background-color: #98FB98;
    }
</style>
<div class="modal fade in" id="dtlPedidoMes" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="post" id="formCadPeca" action="">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #2F4F4F;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                    <button type="submit" class="btn btn-success" id="RepEstoqGenExcel" style="float:right;margin-right: 10px;width: 100px">Excel</button>
                    <h4 class="modal-title" id="myModalLabel" style="color: white">PEDIDOS PENDENTES 
                    </h4>
                </div>
                <div class="modal-body modal-lg">
                    <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                        <div class="jarviswidget-editbox"></div>
                        <div class="widget-body no-padding">
                            <div id="reportSalEstoque">
                                <table id="TbRelPedidoMes" class="table">
                                    <thead>                         
                                        <tr>
                                            <th data-hide="phone"> PEDIDO </th>
                                            <th data-class="expand"> COD ALMOX </th>
                                            <th data-class="expand"> DESTINO </th>
                                            <th data-class="expand"> DATA </th>
                                            <th data-class="expand"> STATUS </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($tipo=mysqli_fetch_assoc($res_pedido)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $tipo['nr_pedido'] ;?></td>
                                                <td><?php echo $tipo['cod_almox'];?></td>
                                                <td><?php echo $tipo['ds_almox'];?></td>
                                                <td><?php echo $tipo['dt_create'];?></td>
                                                <td class="status">
                                                    <?php
                                                    if ($tipo['fl_status'] == 'A') {
                                                        echo '<bold>ABERTO</bold>';
                                                    } elseif ($tipo['fl_status'] == 'P') {
                                                        echo '<bold>CONFERÊNCIA FINALIZADA</bold>';
                                                    } elseif ($tipo['fl_status'] == 'E' || $tipo['fl_status'] == 'W') {
                                                        echo '<bold>EXPEDIÇAO</bold>';
                                                    } elseif ($tipo['fl_status'] == 'C') {
                                                        echo '<bold>AGUARDANDO COLETA</bold>';
                                                    } elseif ($tipo['fl_status'] == 'M') {
                                                        echo '<bold>COLETA INICIADA</bold>';
                                                    } elseif ($tipo['fl_status'] == 'F') {
                                                        echo '<bold>COLETADO</bold>';
                                                    } elseif ($tipo['fl_status'] == 'X') {
                                                        echo '<bold>EXPEDIÇÃO</bold>';
                                                    } elseif ($tipo['fl_status'] == 'L') {
                                                        echo '<bold>EXPEDIDO</bold>';
                                                    } elseif ($tipo['fl_status'] == 'H') {
                                                        echo '<bold>MANUSEIO</bold>';
                                                    } elseif ($tipo['fl_status'] == 'S') {
                                                        echo '<bold>EXPEDIÇÃO FINALIZADA</bold>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>  
                    <div id="pedidos"></div>     
                </div>
                <div class="modal-footer" style="background-color: #2F4F4F;">
                    <button type="button" id="" class="btn btn-default" data-dismiss="modal">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#dtlPedidoMes').modal('show');
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var status_ = new Array();
        $('.status').each( function( i,v ){
            var $this = $( this )
            status_[i] = $this.attr('data-status');
            if(status_[i] == "A"){
                $this.addClass('ocupado');
            }else if(status_[i] == "C"){
                $this.removeClass('ocupado').addClass('alerta');
            }else if(status_[i] == "F"){
                $this.removeClass('ocupado').addClass('livre');
            }else if (status_[i] == "P"){
                $this.removeClass('ocupado').addClass('finalizado');
            }else if (status_[i] == "S"){
                $this.removeClass('ocupado').addClass('expedido');
            }else if (status_[i] == "X" || status_[i] == "W"){
                $this.removeClass('ocupado').addClass('expedicao');
            }else if (status_[i] == "H"){
                $this.removeClass('ocupado').addClass('alerta');
            }
        });
    });
</script>
<script type="text/javascript">
    $('#RepEstoqGenExcel').on('click', function(){
        event.preventDefault();
        $('#RepEstoqGenExcel').prop("disabled", true);
        var today = new Date();
        $("#reportSalEstoque").table2excel({
            exclude: ".noExl",
            name: "Consulta fechamento de inventário - Analítico",
            filename: "Relatório de saldo de estoque detalhado" + today});
        $('#RepEstoqGenExcel').prop("disabled", false);

    });
</script>