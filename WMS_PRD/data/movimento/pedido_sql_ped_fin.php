<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION['cod_cli'];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$nr_ped = $_POST['nr_ped'];


$sql_ped = "select t1.nr_pedido, t1.nr_ped_sap, t1.cod_almox, t3.ds_nome as ds_almox, date_format(t1.dt_pedido,'%d/%m/%Y') as dt_pedido,  date_format(t1.dt_limite,'%d/%m/%Y') as dt_limite, t1.hr_limite, t1.fl_status, date_format(t2.dt_exp,'%d/%m/%Y') as dt_exp, t1.nr_minuta, t1.doc_material 
from tb_pedido_coleta t1 
left join tb_pedido_coleta_produto t2 on t1.nr_pedido = t2.nr_pedido
left join tb_funcionario t3 on t1.cod_almox = t3.nr_matricula 
where t1.nr_pedido = '$nr_ped'
group by t1.nr_pedido";
$ped = mysqli_query($link, $sql_ped);
$tr = mysqli_num_rows($ped);

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
<section class="panel col-lg-12" id="tbColeta">
	<?php
	if ($tr > 0) {
		?>

		<table class="table table-bordered table-checkable order-column" id="tbConfPed">
			<thead>
				<tr>
					<th> Ações </th>
					<th> Pedido</th>
					<th> Doc Material</th>
					<th> Destinatário </th>
					<th> Data do pedido </th>
					<th> Data limite </th>
					<th> Data expedição </th>
					<th> Romaneio </th>
					<th> Status do pedido </th>
				</tr>
			</thead>
			<tbody>
				<?php while ($linha = mysqli_fetch_array($ped)) {
					?>
					<tr class="status" data-status="<?php echo $linha['fl_status']; ?>">
						<td style="text-align: center">
							<button type="submit" id="btnDtlPedFin" class="btn btn-default btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Detalhe</button>
							<button type="submit" id="btnUpdPed" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Etiqueta</button>
							<!--button type="submit" id="btnPrintCol" class="btn btn-info btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Imprimir</button>
								<button type="submit" id="btnEndCol" class="btn btn-success btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Finalizar</button-->
								</td>
								<td style="text-align: right;"> <?php echo $linha['nr_pedido']; ?> </td>
								<td> <?php echo $linha['doc_material']; ?> </td>
								<td> <?php echo $linha['cod_almox']." - ".$linha['ds_almox']; ?> </td>
								<td style="text-align: right;"> <?php echo $linha['dt_pedido'];?></td>
								<td style="text-align: right;"> <?php echo $linha['dt_limite'];?></td>
								<td style="text-align: right;"> <?php echo $linha['dt_exp'];?></td>
								<td style="text-align: right;"> <?php echo $linha['nr_minuta'];?></td>
								<td class="status">
									<?php
									if ($linha['fl_status'] == 'A') {
										echo '<bold>ABERTO</bold>';
									} elseif ($linha['fl_status'] == 'P') {
										echo '<bold>CONFERÊNCIA FINALIZADA</bold>';
									} elseif ($linha['fl_status'] == 'E' || $linha['fl_status'] == 'W') {
										echo '<bold>EXPEDIÇAO</bold>';
									} elseif ($linha['fl_status'] == 'C') {
										echo '<bold>AGUARDANDO COLETA</bold>';
									} elseif ($linha['fl_status'] == 'M') {
										echo '<bold>COLETA INICIADA</bold>';
									} elseif ($linha['fl_status'] == 'F') {
										echo '<bold>FINALIZADO</bold>';
									} elseif ($linha['fl_status'] == 'X') {
										echo '<bold>EXPEDIÇÃO</bold>';
									} elseif ($linha['fl_status'] == 'L') {
										echo '<bold>EXPEDIDO</bold>';
									} elseif ($linha['fl_status'] == 'H') {
										echo '<bold>MANUSEIO</bold>';
									} elseif ($linha['fl_status'] == 'S') {
										echo '<bold>EXPEDIÇÃO FINALIZADA</bold>';
									}
									?>
								</td>
							<?php }?>
						</tr>
					</tbody>
				</table>
		<div id="retDtlProduto"></div>
		<div id="retDtlPedido"></div>
	<?php } else {?>

		<h4>Nao foram encontrados pedidos com esta descrição.</h4>

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