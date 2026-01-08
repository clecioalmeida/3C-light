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

$doc_material = $_POST['doc_mat'];


$sql_ped = "select t1.nr_pedido, t1.nr_ped_sap, t2.nr_matricula, t1.ds_destino, upper(t2.ds_nome) as ds_nome, date_format(t1.dt_pedido,'%d/%m/%Y') as dt_pedido, t1.fl_status, t1.ds_custo
from tb_pedido_coleta t1  
left join tb_funcionario t2 on t1.cod_almox = t2.nr_matricula
where t1.ds_custo = '$doc_material'";
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
<style type="text/css">
	.tableFixHead          { overflow-y: auto; height: 540px; }
	.tableFixHead thead th { position: sticky; top: 0; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }

</style>
	<?php
	if ($tr > 0) {
		?>


		<div class="tableFixHead">
			<table class="table table-bordered table-checkable order-column" id="tbConfPed">
				<thead>
					<tr>
						<th> Ações </th>
						<th> Pedido</th>
						<th> Requisição</th>
						<th> Destinatário </th>
						<th> Data do pedido </th>
						<th> Status do pedido </th>
						<th> Ações </th>
					</tr>
				</thead>
				<tbody>
					<?php while ($linha = mysqli_fetch_array($ped)) {
						?>
						<tr class="" data-status="<?php echo $linha['fl_status']; ?>">
						<td style="text-align: center">
							<button type="submit" id="btnDtlPed" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">DETALHE</button>
							<button type="submit" id="btnPrintCol" class="btn btn-info btn-xs" value="<?php echo $linha['nr_pedido']; ?>">IMPRIMIR</button>
							<div class="btn-group">
								<a href="data/movimento/relatorio/list_req.php?cod_ped=<?php echo $linha['nr_pedido']; ?>" target="_blank"><button type="submit" id="btnPrintEtq" class="btn btn-success btn-xs" value="" style="width: 100px">REQUISIÇÃO</button></a>
							</div>
						</td>
						<td style="text-align: right;"> <?php echo $linha['nr_pedido']; ?> </td>
						<td style="text-align: right;"> <?php echo $linha['nr_ped_sap']; ?> </td>
						<td> <?php echo $linha['ds_custo']." - ".$linha['ds_nome']; ?> </td>
						<td> <?php echo $linha['dt_pedido'];?></td>
						<td class="">
							<?php
							if ($linha['fl_status'] == 'A') {
								echo '<bold>ABERTO</bold>';
							} elseif ($linha['fl_status'] == 'P') {
								echo '<bold>CONFERÊNCIA FINALIZADA</bold>';
							} elseif ($linha['fl_status'] == 'E' || $linha['fl_status'] == 'W') {
								echo '<bold>EXCLUÍDO</bold>';
							} elseif ($linha['fl_status'] == 'C') {
								echo '<bold>AGUARDANDO COLETA</bold>';
							} elseif ($linha['fl_status'] == 'M') {
								echo '<bold>COLETA INICIADA</bold>';
							} elseif ($linha['fl_status'] == 'F') {
								echo '<bold>FINALIZADO</bold>';
							} elseif ($linha['fl_status'] == 'X') {
								echo '<bold>COLETADO</bold>';
							} elseif ($linha['fl_status'] == 'L') {
								echo '<bold>EXPEDIDO</bold>';
							} elseif ($linha['fl_status'] == 'H') {
								echo '<bold>MANUSEIO</bold>';
							} elseif ($linha['fl_status'] == 'S') {
								echo '<bold>EXPEDIÇÃO FINALIZADA</bold>';
							}
							?>
						</td>
						<td style="text-align: center">
							<button type="submit" id="btnEndCol" class="btn btn-success btn-xs" value="<?php echo $linha['nr_pedido']; ?>">FINALIZAR</button>
							<button type="submit" id="btnDelPed" class="btn btn-danger btn-xs" value="<?php echo $linha['nr_pedido']; ?>">CANCELAR</button>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
		<div id="retDtlProduto"></div>
		<div id="retDtlPedido"></div>
	<?php } else {?>

		<h4>Nao foram encontrados pedidos com esta descrição.</h4>

	<?php }
	?>
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