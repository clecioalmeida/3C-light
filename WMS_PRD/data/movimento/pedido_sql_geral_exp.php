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


$sql_ped = "select 
t1.nr_pedido, 
t1.doc_material, 
t1.doc_material, 
t1.nr_ped_sap, 
t1.cod_almox, 
t2.ds_nome, 
date_format(t1.dt_pedido,'%d/%m/%Y') as dt_pedido, 
t1.nr_dem, 
t1.vlr_dem, 
date_format(t1.dt_limite,'%d/%m/%Y') as dt_limite, 
t1.hr_limite, 
t1.fl_status, 
t1.ds_frete 
from tb_pedido_coleta t1
left join tb_funcionario t2 
on t1.cod_almox = t2.nr_matricula 
where t1.fl_Status = 'F' 
and t1.fl_empresa = '$cod_cli' 
and t1.nr_minuta is null 
ORDER BY t1.nr_pedido desc
limit 100";
$ped = mysqli_query($link, $sql_ped);
$tr = mysqli_num_rows($ped);

$link->close();
?>
<style type="text/css">
	.ocupado {
		background-color: #F4A460;
	}

	.livre {
		background-color: #C1FFC1;
	}

	.alerta {
		background-color: #EEDD82;
	}

	.finalizado {
		background-color: #C1FFC1;
	}

	.expedido {
		background-color: #C1FFC1;
	}

	.expedicao {
		background-color: #C1FFC1;
	}
</style>
<style type="text/css">
	.tableFixHead          { overflow-y: auto; height: 640px; }
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
					<th class="hasinput" style="width: 20px">
						<div class="form-group">
							<label class="checkbox-inline">
								<input type="checkbox" id="checkboxTodos" class="checkbox style-0">
								<span></span>
							</label>
						</div>
					</th>
					<th> AÇÕES </th>
					<th> PEDIDO</th>
					<th> DESTINATÁRIO </th>
					<th> DATA DO PEDIDO </th>
					<th> DATA LIMITE </th>
					<th> MODALIDADE </th>
					<th> D.E.M </th>
					<th colspan="2"> VALOR TOTAL </th>
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
									<input type="checkbox" class="checkbox style-0 checkRom" id="checkRom" value="<?php echo $linha['nr_pedido'];?>" data-st="<?php echo $linha['fl_status'];?>">
									<span></span>
								</label>
							</div>
						</td>
						<td style="text-align: center;width: 150px">
							<button type="submit" id="btnDtlPedExp" class="btn btn-default btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Detalhe</button>
							<button type="submit" id="btnUpdPed" class="btn btn-primary btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Etiqueta</button>
							<!--button type="submit" id="btnPrintCol" class="btn btn-info btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Imprimir</button>
								<button type="submit" id="btnEndCol" class="btn btn-success btn-xs" value="<?php echo $linha['nr_pedido']; ?>">Finalizar</button-->
								</td>
								<td style="text-align: right;"> <?php echo $linha['nr_pedido']; ?> </td>
								<td> <?php echo $linha['cod_almox']." - ".$linha['ds_nome']; ?> </td>
								<td> <?php echo $linha['dt_pedido'];?></td>
								<td> <?php echo $linha['dt_limite'];?></td>
								<td> <?php echo $linha['ds_frete'];?></td>
								<td id="nr_dem"> <?php echo $linha['doc_material'];?></td>
								<!--td id="nr_dem" contenteditable="true" style="text-align: right;width: 100px;background-color: white"> <?php echo $linha['nr_dem']; ?> </td-->
								<td id="vlr_dem" contenteditable="true" style="text-align: right;width: 100px;background-color: white;border: 1"> <?php echo $linha['vlr_dem']; ?> </td>
								<td style="text-align: right;width: 70px;background-color: #D3D3D3"><button type="button" id="btnSaveDemPrd" value="<?php echo $linha['nr_pedido'];?>">Gravar</button></td>
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
										echo '<bold>EXPEDIÇÃO PENDENTE</bold>';
									} elseif ($linha['fl_status'] == 'L') {
										echo '<bold>EXPEDIDO</bold>';
									} elseif ($linha['fl_status'] == 'H') {
										echo '<bold>MANUSEIO</bold>';
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
				});
			</script>