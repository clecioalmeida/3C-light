<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_pedido = $_POST['nr_pedido'];

$sql_ped = "select t1.nr_pedido, t1.nr_ped_sap, t1.cod_almox, t1.ds_destino, date_format(t1.dt_pedido,'%d/%m/%Y') as dt_pedido,date_format(t1.dt_separa,'%d/%m/%Y') as dt_separa,  date_format(t1.dt_limite,'%d/%m/%Y') as dt_limite, t1.hr_limite, t1.fl_status, t1.doc_material 
from tb_pedido_coleta t1  where t1.nr_pedido  = '$nr_pedido' ORDER BY t1.nr_pedido desc";
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
<?php
if ($tr > 0) {
	?>

	<table class="table table-bordered table-checkable order-column" id="reportSalEstoque">
		<thead>
			<tr>
				<th> Ações </th>
				<th> Pedido</th>
				<th> Doc Material</th>
				<th> Destinatário </th>
				<th> Data do pedido </th>
				<th> Data separação </th>
				<th> Data limite </th>
				<th> Status do pedido </th>
				<th> Ações </th>
			</tr>
		</thead>
		<tbody>
			<?php while ($linha = mysqli_fetch_array($ped)) {
				?>
				<tr class="status" data-status="<?php echo $linha['fl_status']; ?>">
					<td style="text-align: center">
						<button type="submit" id="btnDtlPed" class="btn btn-default btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Detalhe</button>
						<button type="submit" id="btnUpdPed" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Etiqueta</button>
						<button type="submit" id="btnPrintCol" class="btn btn-info btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Imprimir</button>
						<div class="btn-group">
							<a href="data/movimento/relatorio/list_req.php?cod_ped=<?php echo $linha['nr_pedido']; ?>" target="_blank"><button type="submit" id="btnPrintEtq" class="btn btn-success btn-xs" value="" style="width: 100px">REQUISIÇÃO</button></a>
						</div>
						<button type="submit" id="btnEndCol" class="btn btn-success btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Finalizar</button>
					</td>
					<td style="text-align: right;"> <?php echo $linha['nr_pedido']; ?> </td>
					<td style="text-align: right;"> <?php echo $linha['doc_material']; ?> </td>
					<td> <?php echo $linha['cod_almox']." - ".$linha['ds_destino']; ?> </td>
					<td> <?php echo $linha['dt_pedido'];?></td>
					<td> <?php echo $linha['dt_separa'];?></td>
					<td> <?php echo $linha['dt_limite'];?></td>
					<td class="status">
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
					<td style="text-align: center">
						<button type="submit" id="btnNsPed" class="btn btn-default btn-xs" value="<?php echo $linha['nr_pedido']; ?>">N. Série</button>
						<button type="submit" id="btnDelPed" class="btn btn-danger btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Cancelar</button>
					</td>
				<?php }?>
			</tr>
		</tbody>
	</table>
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
	$(document).ready(function(){
		$('#BtnExpExcel').on('click', function(){
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