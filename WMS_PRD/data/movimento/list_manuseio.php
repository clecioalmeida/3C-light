<?php
//Incluir a conexão com banco de dados
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();
$listManuseio = $_POST['listManuseio'];

$sql = "select t1.*, t2.produto, t2.nr_qtde
from tb_pedido_coleta t1
left join tb_pedido_coleta_produto t2 on t1.nr_pedido = t2.nr_pedido
 where t1.fl_status = 'H' or t1.fl_status = 'I'";

$query = mysqli_query($link, $sql);
$coleta = mysqli_num_rows($query);
$hoje = date('d/m/Y');
$cor1 = '#FF6347';
$cor2 = '#9AFF9A';
$cor3 = '#FFFF00';
$link->close();
?>
<style type="text/css">
    .ocupado {
        background-color: #F08080;
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
</style>
<section class="panel col-lg-12" id="tbColeta">
    <?php
if ($coleta > 0) {
	?>
    <legend>Pedidos aguardando manuseio</legend>
    <table class="table table-bordered table-hover table-checkable order-column" id="tbConfPed">
        <thead>
            <tr>
                <th> Pedido</th>
                <th> Destinatário </th>
                <th> Cidade </th>
                <th> Modal </th>
                <th> Data limite</th>
                <th> Produto</th>
                <th> Quantidade</th>
                <th> Situação</th>
                <th colspan="3" style="text-align: center"> Ações </th>
            </tr>
        </thead>
        <tbody>
            <?php
while ($linha = mysqli_fetch_assoc($query)) {
		?>
                <tr class="status" data-status="<?php echo $linha['fl_status']; ?>">
                    <td class="PedidoCol" id="nrPedidoCol" style="width: 30px"> <?php echo $linha['nr_pedido']; ?> </td>
                    <td> <?php echo $linha['nm_cliente']; ?> </td>
                    <td></td>
                    <td style="width: 100px"> <?php echo $linha['ds_modalidade']; ?> </td>
                    <td style="width: 100px">
                            <?php

		if (date("d/m/Y", strtotime($linha['dt_limite'])) == strtotime($hoje) && $linha['ds_modalidade'] == 'P') {
			echo "<style>.mudacor{background-color:" . $cor1 . ";}</style>";
		} else {

			echo "<style>.mudacor{background-color:" . $cor2 . ";}</style>";

		}

		echo date("d/m/Y", strtotime($linha['dt_limite']));
		?>

                    </td>
                    <td id="produto"><?php echo $linha['produto']; ?></td>
                    <td id="nr_qtde"><?php echo $linha['nr_qtde']; ?></td>
                    <td id="status" style="width: 220px"> <?php
if ($linha['fl_status'] == 'H') {
			echo '<bold>AGUARDANDO MANUSEIO</bold>';
		} elseif ($linha['fl_status'] == 'I') {
			echo '<bold>MANUSEIO INICIADO</bold>';
		} elseif ($linha['fl_status'] == 'E') {
			echo '<bold>EXPEDIÇAO</bold>';
		} elseif ($linha['fl_status'] == 'C') {
			echo '<bold>INICIADO</bold>';
		} elseif ($linha['fl_status'] == 'M') {
			echo '<bold>COLETA INICIADA</bold>';
		} elseif ($linha['fl_status'] == 'F') {
			echo '<bold>COLETADO</bold>';
		} elseif ($linha['fl_status'] == 'X') {
			echo '<bold>EXPEDIÇÃO</bold>';
		}
		?>
                    </td>
                    <td style="text-align: center; width: 300px">
                    	<button type="submit" id="btnStartMan" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Iniciar</button>
                        <button type="submit" id="btnPrintManEtq" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Etiqueta</button>
                    	<button type="submit" id="btnPrintMan" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Imprimir</button>
                    	<button type="submit" id="btnEndMan" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Finalizar</button>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
        <div id="MretornoEtq"></div>
    <?php } else {?>

    <h4>Nao foram encontrados produtos com esta descrição.</h4>

    <?php }
?>
</section>
<!--script src="//code.jquery.com/jquery-1.11.2.min.js"></script-->
<script type="text/javascript">
    $(document).ready(function(){
        var status_ = new Array();
        $('.status').each( function( i,v ){
            var $this = $( this )
            status_[i] = $this.attr('data-status');
            if(status_[i] == "C"){
                $this.addClass('ocupado');
            }else if(status_[i] == "M"){
                $this.removeClass('ocupado').addClass('alerta');
            }else if(status_[i] == "F"){
                $this.removeClass('ocupado').addClass('livre');
            }else if (status_[i] == "P"){
                $this.removeClass('ocupado').addClass('finalizado');
            }
        });
    });
</script>