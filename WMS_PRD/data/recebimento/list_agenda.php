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

$SQL = "SELECT t1.id, date_format(t1.dt_janela,'%d/%m/%Y') as dt_janela_conf, t1.ds_janela, t1.fl_status, t1.fl_tipo, CASE t1.fl_status WHEN 'A' THEN 'ABERTA' WHEN 'S' THEN 'SOLICITADA' WHEN 'C' THEN 'CONFIRMADA' WHEN 'B' THEN 'FECHADA' END as janela, t2.cod_recebimento, t2.nm_fornecedor, t2.nr_peso_previsto, t2.nr_volume_previsto
from tb_janela t1
left join tb_recebimento_ag t2 on t1.cod_rec = t2.cod_recebimento
where t1.fl_empresa = '$cod_cli' and t1.dt_janela >= CURRENT_DATE
order by t1.dt_janela, t1.ds_janela asc";
$res = mysqli_query($link, $SQL);

$link->close();
?>

<script src="jquery.table2excel.js"></script>
<button type="submit" class="btn btn-success" id="btnRecebJanExcel" style="float:right;width: 100px">Excel</button>
<br><br>

<div class="jarviswidget jarviswidget-color-blueDark tabRecebJan" id="wid-id-1" data-widget-editbutton="false">
	<table class="display responsive nowrap" id="example2" style="width:100%">
		<thead>
			<tr>
				<th> DATA</th>
				<th> JANELA </th>
				<th> STATUS </th>
				<th> O.R. </th>
				<th> FORNECEDOR </th>
				<th> PESO PREVISTO </th>
				<th> VOLUME PREVISTO </th>
				<th style="text-align: center;"> AÇÕES </th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($dados = mysqli_fetch_array($res)) {
			?>
				<tr class="status" data-status="<?php echo $dados['fl_status']; ?>">
					<input type="hidden" id="id_jan" name="" value="<?php echo $dados['fl_status']; ?>">
					<td> <?php echo $dados['dt_janela_conf']; ?></td>
					<td> <?php echo $dados['ds_janela']; ?> </td>
					<?php
					if ($dados['fl_status'] == "A") {

						if ($dados['fl_tipo'] == "E") {

							$td = '<td style="background-color: #98FB98">' . $dados['janela'] . " (EXTRA)" . '</td>';
						} else {

							$td = '<td style="background-color: #98FB98">' . $dados['janela'] . '</td>';
						}
					} else if ($dados['fl_status'] == "C") {

						if ($dados['fl_tipo'] == "E") {

							$td = '<td style="background-color: #8FBC8F">' . $dados['janela'] . " (EXTRA)" . '</td>';
						} else {

							$td = '<td style="background-color: #8FBC8F">' . $dados['janela'] . '</td>';
						}
					} else if ($dados['fl_status'] == "B") {

						if ($dados['fl_tipo'] == "E") {

							$td = '<td style="background-color: #FF6347">' . $dados['janela'] . " (EXTRA)" . '</td>';
						} else {

							$td = '<td style="background-color: #FF6347">' . $dados['janela'] . '</td>';
						}
					} else if ($dados['fl_status'] == "S") {

						if ($dados['fl_tipo'] == "E") {

							$td = '<td style="background-color: #FF6347">' . $dados['janela'] . " (EXTRA)" . '</td>';
						} else {

							$td = '<td style="background-color: #FFFF00">' . $dados['janela'] . '</td>';
						}
					}

					echo $td;

					?>
					<td style="text-align: center;"> <?php echo $dados['cod_recebimento']; ?> </td>
					<td> <?php echo $dados['nm_fornecedor']; ?> </td>
					<td style="text-align: center;"> <?php echo $dados['nr_peso_previsto']; ?> </td>
					<td style="text-align: center;"> <?php echo $dados['nr_volume_previsto']; ?> </td>
					<td style="text-align: center; width: 400px">
						<?php
						if ($dados['fl_status'] == "A") {

							$btn = '<button type="submit" id="btnBlqJan" class="btn btn-danger btn-xs" value="' . $dados['id'] . '">FECHAR JANELA</button>';
						} else if ($dados['fl_status'] == "B") {

							$btn = '<button type="submit" id="btnReabJan" class="btn btn-primary btn-xs" value="' . $dados['id'] . '">REABRIR JANELA</button>';
						} else {

							$btn = '<button type="submit" id="btnBlqJan" class="btn btn-danger btn-xs" value="' . $dados['id'] . '" disabled>FECHAR JANELA</button>';
						}

						echo $btn;
						?>
						<!--button type="submit" id="btnDelRec" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_recebimento']; ?>" data-st="<?php echo $dados['fl_status']; ?>">EXCLUIR</button>
									<button type="submit" id="btnLibRec" class="btn btn-success btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">LIBERAR</button>
									<button type="submit" id="btnPrintRec" class="btn btn-default btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">IMPRIMIR</button-->
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$('#btnRecebJanExcel').on('click', function() {
		event.preventDefault();
		$('#btnRecebJanExcel').prop("disabled", true);
		var today = new Date();
		$(".tabRecebJan").table2excel({
			name: "Relatório de janelas do recebimento",
			filename: "Relatório de janelas do recebimento"
		});
		$('#btnRecebJanExcel').prop("disabled", false);

	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#example2").dataTable({
			"aLengthMenu": [5000]
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {

		pageSetUp();
		var responsiveHelper_dt_basic12 = undefined;

		var breakpointDefinition = {
			tablet: 1024,
			phone: 480
		};
	});
</script>