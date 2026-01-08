<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../../index.php");
	exit;
} else {

	$id 		= $_SESSION["id"];
	$cod_cli  	= $_SESSION['cod_cli'];
}
?>
<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$SQL = "SELECT t1.cod_recebimento, t1.cod_cli, t1.nm_fornecedor, t1.nr_peso_previsto, t1.tp_rec, date_format(t1.dt_recebimento_previsto,'%d/%m/%Y') as dt_recebimento_previsto,  t1.nr_volume_previsto, t1.nm_transportadora, t1.nm_motorista, t1.nm_placa, date_format(t1.dt_recebimento_real,'%d/%m/%Y') as dt_recebimento_real, t1.usr_create, t1.usr_confere, t1.dt_descarregamento, t1.hr_descarregamento, t1.fl_status, t1.ds_obs, t1.usr_recebe, t1.dt_recebido, t1.usr_autoriza, t1.dt_autoriza, t1.fl_status, t2.cod_cliente, t2.nm_cliente, t4.nm_user
from tb_recebimento_ag t1
left join tb_cliente t2 on t1.cod_cli = t2.cod_cliente
left join tb_usuario t4 on t1.usr_create = t4.id
where t1.cod_cli = '$cod_cli' and t1.fl_status = 'F' order by t1.cod_recebimento desc limit 200";

$res = mysqli_query($link, $SQL);

$link->close();
?>
<style type="text/css">
	.tableFixHead {
		overflow-y: auto;
		height: 640px;
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
<script src="jquery.table2excel.js"></script>
<button type="submit" class="btn btn-success" id="btnRecebOrFinExcel" style="float:right;width: 100px">Excel</button>
<br><br>
<div class="jarviswidget jarviswidget-color-blueDark tabRecebOrFin" id="wid-id-1" data-widget-editbutton="false">
	<div>
		<div class="jarviswidget-editbox">
		</div>
		<div id="retCte"></div>
		<div id="retNf"></div>
		<div class="widget-body no-padding" id="tabela_cte_pend">
			<div class="tableFixHead">
				<table class="display responsive nowrap" id="example1" style="width:100%">
					<thead>
						<tr>
							<th> AÇÕES </th>
							<th> O.R. </th>
							<th> DATA</th>
							<th> PESO </th>
							<th> VOLUME </th>
							<th> FORNECEDOR </th>
							<th> TRANSPORTADOR </th>
							<th> PLACA </th>
							<th> SITUAÇÃO </th>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($dados = mysqli_fetch_array($res)) {
						?>
							<tr class="status" data-status="<?php echo $dados['fl_status']; ?>">
								<td style="text-align: center; width: 200px">
									<button type="submit" id="btnDtlRecEnc" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">DETALHE</button>
									<button type="submit" id="btnPrintRec" class="btn btn-default btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">IMPRIMIR</button>
								</td>
								<td style="text-align: center; width: 10px"> <?php echo $dados['cod_recebimento']; ?> </td>
								<td style="text-align: center;">
									<?php
									if ($dados['dt_recebimento_real'] < 1) {
										echo '';
									} else {
										echo $dados['dt_recebimento_real'];
									}
									?>
								</td>
								<td style="text-align: right;"> <?php echo $dados['nr_peso_previsto']; ?> </td>
								<td style="text-align: right;"> <?php echo $dados['nr_volume_previsto']; ?> </td>
								<td> <?php echo $dados['nm_fornecedor']; ?> </td>
								<td> <?php echo $dados['nm_transportadora']; ?> </td>
								<td> <?php echo $dados['nm_placa']; ?> </td>
								<?php
								if ($dados['fl_status'] == 'L') {

									$td = '<td style="background-color: #F4A460">AGUARDANDO CONFERÊNCIA</td>';
									echo $td;
								} else if ($dados['fl_status'] == 'C') {

									$td = '<td style="background-color: #9AFF9A">CONFERÊNCIA FINALIZADA</td>';
									echo $td;
								} else if ($dados['fl_status'] == 'F') {

									$td = '<td style="background-color: #B0C4DE">OR FINALIZADA</td>';
									echo $td;
								}
								?>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#btnRecebOrFinExcel').on('click', function() {
		event.preventDefault();
		$('#btnRecebOrFinExcel').prop("disabled", true);
		var today = new Date();
		$(".tabRecebOrFin").table2excel({
			name: "Relatório de OR finalizadas",
			filename: "Relatório de OR finalizadas"
		});
		$('#btnRecebOrFinExcel').prop("disabled", false);

	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#example1").dataTable({
			"aLengthMenu": [5000]
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {

		pageSetUp();
		var responsiveHelper_dt_basic4 = undefined;

		var breakpointDefinition = {
			tablet: 1024,
			phone: 480
		};
	});
</script>