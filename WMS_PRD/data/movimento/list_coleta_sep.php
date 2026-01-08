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

$conferente = '<hr>
				<div class="form-group">
              		<label class="col-sm-1 control-label" for="galpao">SEPARADOR</label>
              		<div class="col-sm-3" id="armaz">
              			<select class="form-control" id="id_sep">
              				<option value="" disabled selected>Escolha o separador</option>';

$sql_conf = "select id, nm_user from tb_usuario where id_op = '$cod_cli' and id_depto = '4' and fl_status = 'A'";
$res_conf = mysqli_query($link, $sql_conf);
while ($conf=mysqli_fetch_assoc($res_conf)) {
	$conferente .= '<option value="'.$conf['id'].'">'.$conf['nm_user'].'</option>';            
}

$conferente .= '</select>
              </div>
              <button type="submit" class="btn btn-primary btn-sm" id="btnSaveSep" style="width:100px">Salvar</button>
             </div>';

$sql_ped = "select t1.nr_pedido, t1.nr_ped_sap, t1.cod_almox, t2.ds_almox, date_format(t1.dt_pedido,'%d/%m/%Y') as dt_pedido, date_format(t1.dt_lib_col,'%d/%m/%Y') as dt_lib_col, date_format(t1.dt_limite,'%d/%m/%Y') as dt_limite, t1.hr_limite, t1.fl_status 
from tb_pedido_coleta t1 
left join tb_almox t2 on t1.cod_almox = t2.cod_almox 
where t1.fl_empresa = '$cod_cli' and t1.fl_status = 'C' ORDER BY t1.nr_pedido desc limit 100";
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
<?php
if($tr > 0){

echo $conferente;
?>
<br>
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
				<th> PEDIDO</th>
				<th> DESTINATÁRIO </th>
				<th> DATA DO PEDIDO </th>
				<th> LIBERAÇÃO DA COLETA </th>
				<th> DATA LIMITE </th>
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
								<input type="checkbox" class="checkbox style-0 checkSep" id="checkSep" value="<?php echo $linha['nr_pedido'];?>" data-st="<?php echo $linha['fl_status'];?>">
								<span></span>
							</label>
						</div>
					</td>
					<td style="text-align: right;"> <?php echo $linha['nr_pedido']; ?> </td>
					<td> <?php echo $linha['cod_almox']." - ".$linha['ds_almox']; ?> </td>
					<td> <?php echo $linha['dt_pedido'];?></td>
					<td> <?php echo $linha['dt_lib_col'];?></td>
					<td> <?php echo $linha['dt_limite'];?></td>
					<td class="status">
						<?php
						if ($linha['fl_status'] == 'A') {
							echo '<bold>ABERTO</bold>';
						} elseif ($linha['fl_status'] == 'P') {
							echo '<bold>CONFERÊNCIA FINALIZADA</bold>';
						} elseif ($linha['fl_status'] == 'E' || $linha['fl_status'] == 'W') {
							echo '<bold>EXPEDIÇAO</bold>';
						} elseif ($linha['fl_status'] == 'C') {
							echo '<bold>COLETA LIBERADA</bold>';
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