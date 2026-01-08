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


$sql_ped = "select t1.cod_minuta, t1.ds_tipo, t1.ds_transporte, t1.nr_placa, date_format(t1.dt_minuta,'%d/%m/%Y') as dt_minuta, TIME_FORMAT(t1.hr_entrada, '%T') as hr_entrada, TIME_FORMAT(t1.hr_saida, '%T') as hr_saida, t1.km_ini, t1.km_fim, t1.fl_expedido, t1.fl_status 
from tb_minuta t1 where t1.fl_empresa = '$cod_cli' ORDER BY date(t1.dt_minuta) desc limit 100";
$ped = mysqli_query($link, $sql_ped);
$tr = mysqli_num_rows($ped);

$link->close();
?>
<style type="text/css">
	.ocupado {
		background-color: #F4A460;
	}

	.livre {
		background-color: #E0FFFF;
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

	<table class="table" id="tbConfPed">
		<thead>
			<tr>
				<th class="hasinput" style="width: 20px">
					<div class="form-group">
						<label class="checkbox-inline">
							<input type="checkbox" id="checkboxTodos" class="checkbox style-0">
							<span></span>
						</label>
					</div>
				</th>
				<th> AÇÕES </th>
				<th> MINUTA</th>
				<th> TIPO </th>
				<th> TRANSPORTADOR </th>
				<th> PLACA </th>
				<th> DATA </th>
				<th> ENTRADA </th>
				<th> SAÍDA </th>
				<th> KM INICIAL </th>
				<th> KM FINAL </th>
				<th> STATUS </th>
			</tr>
		</thead>
		<tbody>
			<?php while ($linha = mysqli_fetch_array($ped)) {
				?>
				<tr class="status" data-status="<?php echo $linha['fl_status']; ?>">
					<td>
						<div class="form-group">
							<label class="checkbox-inline">
								<input type="checkbox" class="checkbox style-0 checkRom" id="checkRom" value="<?php echo $linha['cod_minuta'];?>" data-st="<?php echo $linha['fl_status'];?>">
								<span></span>
							</label>
						</div>
					</td>
					<td style="text-align: center">
						<form class="form-horizontal" method="post" action="data/movimento/relatorio/minuta_list.php" target="_blank">
							<button type="button" id="btnDtlMinuta" class="btn btn-default btn-xs" value="<?php echo $linha['cod_minuta']; ?>" disbled="true">DETALHE</button>
							<input type="hidden" id="cod_min" name="cod_min" value="<?php echo $linha['cod_minuta']; ?>">
							<button type="submit" id="btnPrintMinuta" class="btn btn-primary btn-xs" value="<?php echo $linha['cod_minuta']; ?>">IMPRIMIR</button>
							<button type="button" id="btnLibMinuta" class="btn btn-success btn-xs" value="<?php echo $linha['cod_minuta']; ?>">LIBERAR</button>
						</form>
					</td>
					<td style="text-align: right;"> <?php echo $linha['cod_minuta']; ?> </td>
					<td> <?php echo $linha['ds_tipo']; ?> </td>
					<td> <?php echo $linha['ds_transporte'];?></td>
					<td> <?php echo $linha['nr_placa'];?></td>
					<td> <?php echo $linha['dt_minuta'];?></td>
					<td> <?php echo $linha['hr_entrada'];?></td>
					<td> <?php echo $linha['hr_saida'];?></td>
					<td> <?php echo $linha['km_ini'];?></td>
					<td> <?php echo $linha['km_fim'];?></td>
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
							echo '<bold>EXPEDIDO</bold>';
						} elseif ($linha['fl_status'] == 'X') {
							echo '<bold>EXPEDIÇÃO FINALIZADA</bold>';
						} elseif ($linha['fl_status'] == 'L') {
							echo '<bold>EXPEDIDO</bold>';
						} elseif ($linha['fl_status'] == 'H') {
							echo '<bold>MANUSEIO</bold>';
						} elseif ($linha['fl_status'] == 'D') {
							echo '<bold>EXCLUÍDO</bold>';
						}
						?>
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
	$(document).ready(function() {
		$("#checkboxTodos").click(function(){
			$('input:checkbox').not(this).prop('checked', this.checked);
		});
		$("#btnPrintMinuta").prop("disabled", false);
	});
</script>