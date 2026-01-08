<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$nr_pedido = $_POST['nr_pedido'];

if ($nr_pedido != '') {

	$sql_ped = "select t1.nr_pedido, t1.cod_cliente, t1.dt_pedido, t1.dt_limite, t1.hr_limite, t1.fl_status, t2.nm_cliente from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente where t1.nr_pedido = '$nr_pedido' and t1.fl_status <> 'D' ORDER BY t1.dt_limite desc";
	$ped = mysqli_query($link, $sql_ped);
	$tr = mysqli_num_rows($ped);

} else {

	if (isset($_POST['statusA']) && !isset($_POST['statusC']) && !isset($_POST['statusE'])) {

		$statusA = $_POST['statusA'];

		$sql_ped = "select t1.nr_pedido, t1.cod_cliente, t1.dt_pedido, t1.dt_limite, t1.hr_limite, t1.fl_status, t2.nm_cliente from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente where t1.fl_status = '$statusA' ORDER BY t1.dt_limite desc";
		$ped = mysqli_query($link, $sql_ped);
		$tr = mysqli_num_rows($ped);

	} elseif (isset($_POST['statusA']) && isset($_POST['statusC']) && !isset($_POST['statusE'])) {

		$statusA = $_POST['statusA'];
		$statusC = $_POST['statusC'];
		$statusM = "M";
		$statusP = "P";
		$statusF = "F";

		$sql_ped = "select t1.nr_pedido, t1.cod_cliente, t1.dt_pedido, t1.dt_limite, t1.hr_limite, t1.fl_status, t2.nm_cliente from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente where t1.fl_status = '$statusA' or t1.fl_status = '$statusC' or t1.fl_status = '$statusM' or t1.fl_status = '$statusP' or t1.fl_status = '$statusF' ORDER BY t1.dt_limite desc";
		$ped = mysqli_query($link, $sql_ped);
		$tr = mysqli_num_rows($ped);

	} elseif (!isset($_POST['statusA']) && isset($_POST['statusC']) && !isset($_POST['statusE'])) {

		$statusC = $_POST['statusC'];
		$statusM = "M";
		$statusP = "P";
		$statusF = "F";

		$sql_ped = "select t1.nr_pedido, t1.cod_cliente, t1.dt_pedido, t1.dt_limite, t1.hr_limite, t1.fl_status, t2.nm_cliente from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente where t1.fl_status = '$statusC' or t1.fl_status = '$statusM' or t1.fl_status = '$statusP' or t1.fl_status = '$statusF' ORDER BY t1.dt_limite desc";
		$ped = mysqli_query($link, $sql_ped);
		$tr = mysqli_num_rows($ped);

	} elseif (isset($_POST['statusA']) && isset($_POST['statusC']) && isset($_POST['statusE'])) {

		$statusA = $_POST['statusA'];
		$statusC = $_POST['statusC'];
		$statusE = $_POST['statusE'];
		$statusM = "M";
		$statusP = "P";
		$statusF = "F";

		$sql_ped = "select t1.nr_pedido, t1.cod_cliente, t1.dt_pedido, t1.dt_limite, t1.hr_limite, t1.fl_status, t2.nm_cliente from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente where t1.fl_status = '$statusA' or t1.fl_status = '$statusC' or t1.fl_status = '$statusM' or t1.fl_status = '$statusP' or t1.fl_status = '$statusF' or t1.fl_status = '$statusE' ORDER BY t1.dt_limite desc";
		$ped = mysqli_query($link, $sql_ped);
		$tr = mysqli_num_rows($ped);

	} elseif (!isset($_POST['statusA']) && isset($_POST['statusC']) && isset($_POST['statusE'])) {

		$statusC = $_POST['statusC'];
		$statusE = $_POST['statusE'];
		$statusM = "M";
		$statusP = "P";
		$statusF = "F";

		$sql_ped = "select t1.nr_pedido, t1.cod_cliente, t1.dt_pedido, t1.dt_limite, t1.hr_limite, t1.fl_status, t2.nm_cliente from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente where t1.fl_status = '$statusC' or t1.fl_status = '$statusM' or t1.fl_status = '$statusP' or t1.fl_status = '$statusF' or t1.fl_status = '$statusE' ORDER BY t1.dt_limite desc";
		$ped = mysqli_query($link, $sql_ped);
		$tr = mysqli_num_rows($ped);

	} elseif (!isset($_POST['statusA']) && !isset($_POST['statusC']) && isset($_POST['statusE'])) {

		$statusE = $_POST['statusE'];

		$sql_ped = "select t1.nr_pedido, t1.cod_cliente, t1.dt_pedido, t1.dt_limite, t1.hr_limite, t1.fl_status, t2.nm_cliente from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente where t1.fl_status = '$statusE' ORDER BY t1.dt_limite desc";
		$ped = mysqli_query($link, $sql_ped);
		$tr = mysqli_num_rows($ped);
	} elseif (isset($_POST['statusA']) && !isset($_POST['statusC']) && isset($_POST['statusE'])) {

		$statusA = $_POST['statusA'];
		$statusE = $_POST['statusE'];

		$sql_ped = "select t1.nr_pedido, t1.cod_cliente, t1.dt_pedido, t1.dt_limite, t1.hr_limite, t1.fl_status, t2.nm_cliente from tb_pedido_coleta t1 left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente where t1.fl_status = '$statusA' or t1.fl_status = '$statusE' ORDER BY t1.dt_limite desc";
		$ped = mysqli_query($link, $sql_ped);
		$tr = mysqli_num_rows($ped);
	}
}

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

    .expedido {
        background-color: #8FBC8F;
    }

    .expedicao {
        background-color: #98FB98;
    }
</style>
<section class="panel col-lg-12" id="tbColeta">
    <?php
if ($tr > 0) {
	?>

	<table class="table table-bordered table-checkable order-column" id="tbConfPed">
		<thead>
            <tr>
            	<th> Ações </th>
                <th> Pedido</th>
                <th> Destinatário </th>
                <th> Data do pedido </th>
                <th> Data limite </th>
                <th> Status do pedido </th>
                <th> Ações </th>
            </tr>
        </thead>
        <tbody>
            <?php
while ($linha = mysqli_fetch_array($ped)) {
		?>
            <tr  class="status" data-status="<?php echo $linha['fl_status']; ?>">
            	<td style="text-align: center">
                    <button type="submit" id="btnDtlPed" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Detalhe</button>
                    <button type="submit" id="btnUpdPed" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Alterar</button>
                    <button type="submit" id="btnInsInst" class="btn btn-success btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Instruções</button>
                </td>
                <td style="text-align: right;"> <?php echo $linha['nr_pedido']; ?> </td>
                <td> <?php echo $linha['nm_cliente']; ?> </td>
                <td> <?php
if ($linha['dt_pedido'] == '') {
			echo '';
		} else {
			echo date('d-m-Y', strtotime($linha['dt_pedido']));
		}?>
                </td>
                <td> <?php
if ($linha['dt_limite'] == 0) {
			echo '';
		} else {
			echo date('d-m-Y', strtotime($linha['dt_limite']));
		}?>
                </td>
                <td class="status"> <?php
if ($linha['fl_status'] == 'A') {
			echo '<bold>ABERTO</bold>';
		} elseif ($linha['fl_status'] == 'P') {
			echo '<bold>CONFERÊNCIA FINALIZADA</bold>';
		} elseif ($linha['fl_status'] == 'E') {
			echo '<bold>EXPEDIÇAO</bold>';
		} elseif ($linha['fl_status'] == 'C') {
			echo '<bold>AGUARDANDO COLETA</bold>';
		} elseif ($linha['fl_status'] == 'M') {
			echo '<bold>COLETA INICIADA</bold>';
		} elseif ($linha['fl_status'] == 'F') {
			echo '<bold>COLETADO</bold>';
		} elseif ($linha['fl_status'] == 'X') {
			echo '<bold>EXPEDIÇÃO</bold>';
		} elseif ($linha['fl_status'] == 'L') {
			echo '<bold>EXPEDIDO</bold>';
		} elseif ($linha['fl_status'] == 'H') {
			echo '<bold>MANUSEIO</bold>';
		}
		?>
                </td>
                <td style="text-align: center">
                    <button type="submit" id="btnNsPed" class="btn btn-default btn-xs" value="<?php echo $linha['nr_pedido']; ?>">N. Série</button>
                    <button type="submit" id="btnColPed" class="btn btn-default btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Liberar coleta</button>
                    <button type="submit" id="btnExpPed" class="btn btn-default btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Finalizar</button>
                    <button type="submit" id="btnDelPed" class="btn btn-danger btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Cancelar</button>
                </td>
                <?php }?>
            </tr>
        </tbody>
	</table>
	<div id="retDtlProduto"></div>
	<div id="retDtlPedido"></div>
    <?php } else {?>

    <h4>Nao foram encontrados produtos com esta descrição.</h4>

    <?php }
?>
</section>
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
            }else if (status_[i] == "L"){
            	$this.removeClass('ocupado').addClass('expedido');
            }else if (status_[i] == "X"){
            	$this.removeClass('ocupado').addClass('expedicao');
            }else if (status_[i] == "H"){
            	$this.removeClass('ocupado').addClass('alerta');
            }
        });
    });
</script>