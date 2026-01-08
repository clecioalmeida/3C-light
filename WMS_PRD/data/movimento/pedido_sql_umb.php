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


// $sql_ped = "SELECT t1.nr_pedido, t1.nr_ped_sap, t1.ds_destino, date_format(t1.dt_pedido,'%d/%m/%Y') as dt_pedido, t1.fl_status
// from tb_pedido_coleta t1  
// where (t1.fl_status = 'A' or t1.fl_status = 'M' or t1.fl_status = 'C' or t1.fl_status = 'X' or t1.fl_status = 'D') and t1.fl_empresa = '$cod_cli'
// group by t1.nr_pedido
//  ORDER BY date(t1.dt_pedido) desc";
// $ped = mysqli_query($link, $sql_ped);
// $tr = mysqli_num_rows($ped);

$sql_ped = "SELECT t1.nr_qtde, t1.ds_umb, t1.ds_material, t3.nr_pedido, t1.cod_prd_dst, t1.fl_status
FROM tb_reclassifica t1
LEFT JOIN tb_pedido_coleta_produto t2 ON t1.cod_ped = t2.cod_ped
LEFT JOIN tb_coleta_pedido t3 ON t2.cod_ped = t3.cod_col
ORDER BY t3.nr_pedido DESC";
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
	.tableFixHead {
		overflow-y: auto;
		height: 540px;
	}

	.tableFixHead thead th {
		position: sticky;
		top: 0;
	}

	table {
		border-collapse: collapse;
		width: 100%;
	}

	th,
	td {
		padding: 8px 16px;
	}

	th {
		background: #eee;
	}
</style>
<?php
if ($tr > 0) { ?>
	<div class="tableFixHead">
		<button type="submit" class="btn btn-success" id="btnPedidosExcel" style="float:right;width:100px;margin-bottom:10px">Excel</button>
		<table class="table table-bordered table-checkable order-column" id="reportSalEstoque">
			<thead>
				<tr>
					<!-- <th> Ações </th> -->
					<th> Pedido </th>
					<th> Produto </th>
					<th> Qtde </th>
					<!-- <th> Status </th> -->
					<th> Tipo Material </th>
					<th> Unidade </th>
					<!-- <th> Ações </th> -->
				</tr>
			</thead>
			<tbody>
				<?php while ($linha = mysqli_fetch_array($ped)) {
				?>
					<tr class="" data-status="<?php echo $linha['fl_status']; ?>">
						<!-- <td>
							<button type="submit" id="btnDtlPed" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>" disabled>DETALHE</button>
							<button type="submit" id="btnPrintCol" class="btn btn-info btn-xs" value="<?php echo $linha['nr_pedido']; ?>" disabled>IMPRIMIR</button>
							<div class="btn-group">
								<a href="data/movimento/relatorio/picking_list.php?cod_ped=<?php echo $linha['nr_pedido']; ?>" target="_blank"><button type="submit" id="btnPrintEtq" class="btn btn-success btn-xs" value="" disabled>PICKING LIST</button></a>
							</div>
						</td> -->
						<td style="text-align: right;"> <?php echo $linha['nr_pedido']; ?> </td>
						<td> <?php echo $linha['cod_prd_dst']; ?> </td>
						<td> <?php echo $linha['nr_qtde']; ?></td>
						<!-- <td class="">
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
							} elseif ($linha['fl_status'] == 'D') {
								echo '<bold>DIVERGENTE</bold>';
							}
							?>
						</td> -->
						<td> <?php echo $linha['ds_material']; ?></td>
						<td> <?php echo $linha['ds_umb']; ?></td>
						<!-- <td style="text-align: center">
							<button type="submit" id="btnEndCol" class="btn btn-success btn-xs" value="<?php echo $linha['nr_pedido']; ?>" disabled>FINALIZAR</button>
							<button type="submit" id="btnDelPed" class="btn btn-danger btn-xs" value="<?php echo $linha['nr_pedido']; ?>" disabled>CANCELAR</button>
						</td> -->
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } else { ?>

	<h4>Nao foram encontrados pedidos com esta descrição.</h4>

<?php } ?>

<script type="text/javascript">
	$('#btnPedidosExcel').on('click', function() {
		event.preventDefault();
		$('#btnPedidosExcel').prop("disabled", true);
		var today = new Date();
		$("#reportSalEstoque").table2excel({
			name: "Relatório de Pedidos",
			filename: "Relatório de Pedidos"
		});
		$('#btnPedidosExcel').prop("disabled", false);
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		var status_ = new Array();
		$('.status').each(function(i, v) {
			var $this = $(this)
			status_[i] = $this.attr('data-status');
			if (status_[i] == "A") {
				$this.addClass('ocupado');
			} else if (status_[i] == "C") {
				$this.removeClass('ocupado').addClass('alerta');
			} else if (status_[i] == "F") {
				$this.removeClass('ocupado').addClass('livre');
			} else if (status_[i] == "P") {
				$this.removeClass('ocupado').addClass('finalizado');
			} else if (status_[i] == "S") {
				$this.removeClass('ocupado').addClass('expedido');
			} else if (status_[i] == "X" || status_[i] == "W") {
				$this.removeClass('ocupado').addClass('expedicao');
			} else if (status_[i] == "H") {
				$this.removeClass('ocupado').addClass('alerta');
			}
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#BtnExpExcel').on('click', function() {
			event.preventDefault();
			$('#BtnExpExcel').prop("disabled", true);
			var today = new Date();
			$("#reportSalEstoque").table2excel({
				exclude: ".noExl",
				name: "Relatório geral de pedidos pendentes - Analítico",
				filename: "Relatório geral de pedidos pendentes - Analítico - " + today //do not include extension
			});
			$('#BtnExpExcel').prop("disabled", false);

		});
	});
</script>