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

$SQL = "SELECT  r.cod_recebimento, DATE_FORMAT(r.dt_recebimento_real, '%d/%m/%Y') AS dt_recebimento, r.fl_empresa, 
r.fl_status, r.nm_placa, r.nm_fornecedor, r.nm_motorista, SUM(r.nr_qtde) as nr_qtde, r.id_end, r.ds_galpao, r.ds_rua, 
r.ds_coluna, r.ds_altura, r.ds_kva, r.ds_lp, r.ds_ano, r.ds_enr, r.ds_fabr, r.cod_produto, r.nr_serial, r.ds_obs, 
COALESCE(p.unid,'S/INFO') as unid, r.ds_enr
FROM tb_recebimento_ag r
left join tb_produto p on r.cod_produto = p.cod_prod_cliente
WHERE r.fl_empresa = '$cod_cli' and r.fl_status <> 'E'
group by r.cod_recebimento
order by r.cod_recebimento desc";

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
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet" />
<!--script src="https://code.jquery.com/jquery-3.5.1.js"></script-->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="jquery.table2excel.js"></script>
<button type="submit" class="btn btn-success" id="btnRecebEntExcel" style="float:right;width: 100px">Excel</button>
<br><br>
<div class="jarviswidget jarviswidget-color-blueDark tabRecebEnt" id="wid-id-1" data-widget-editbutton="false">
	<div>
		<div class="jarviswidget-editbox">
		</div>
		<div id="retCte"></div>
		<div id="retNf"></div>
		<div class="widget-body no-padding" id="tabela_cte_pend">
			<div class="tableFixHead">
				<table class="display responsive nowrap" id="example10" style="width:100%">
					<thead>
						<tr>
							<th> AÇÕES </th>
							<th> O.R. </th>
							<th> DATA</th>
							<th> VEÍCULO </th>
							<th> MOTORISTA </th>
							<th> FORNECEDOR </th>
							<th> ENDEREÇO </th>
							<th style="text-align: right;"> LOTE </th>
							<th style="text-align: right;"> QTDE </th>
							<th> LP </th>
							<th> KVA </th>
							<th> SERIAL </th>
							<th> FABRICANTE </th>
							<th> ANO </th>
							<th> ENROLAMENTO </th>
							<th> OBSERVAÇÃO </th>
							<th> SITUAÇÃO </th>
						</tr>
					</thead>
					<tbody>
						<?php
						while ($dados = mysqli_fetch_array($res)) {
						?>
							<tr class="status" data-status="<?php echo $dados['fl_status']; ?>">
								<td style="text-align: center; width: 400px">
									<button type="submit" id="btnUpdRec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">DETALHE</button>
									<button type="submit" id="btnDelRec" class="btn btn-danger btn-xs" value="<?php echo $dados['cod_recebimento']; ?>" data-st="<?php echo $dados['fl_status']; ?>">EXCLUIR</button>
									<button type="submit" id="btnGeraEtq" class="btn btn-default btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">ETIQUETA</button>
									<button type="submit" id="btnPrintRec" class="btn btn-default btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">IMPRIMIR</button>
									<button type="submit" id="btnLibRec" class="btn btn-success btn-xs" value="<?php echo $dados['cod_recebimento']; ?>" data-vl="<?php //echo $dados['nr_volume']; ?>">LIBERAR</button>
								</td>
								<td style="text-align: center; width: 10px"> <?php echo $dados['cod_recebimento']; ?> </td>
								<td style="text-align: left;">
									<?php
									if ($dados['dt_recebimento'] < 1) {
										echo '';
									} else {
										echo $dados['dt_recebimento'];
									}
									?>
								</td>
								<td style="text-align: left;"> <?php echo $dados['nm_placa']; ?> </td>
								<td style="text-align: left;"> <?php echo $dados['nm_motorista']; ?> </td>
								<td style="text-align: left;"> <?php echo $dados['nm_fornecedor']; ?> </td>
								<td style="text-align: left;"> <?php echo $dados['id_end'] . '-' . $dados['ds_rua'] . '-' . $dados['ds_coluna'] . '-' . $dados['ds_altura']  ?> </td>
								<td style="text-align: right;"> <?php echo $dados['cod_produto']; ?> </td>
								<td style="text-align: right;">
									<?php

									if ($dados['unid'] == "KG" && strlen($dados['nr_qtde']) <= 7) {

										echo str_replace(".", ",", $dados['nr_qtde']) . " kg";
									} else if ($dados['unid'] == "KG" && strlen($dados['nr_qtde']) > 7) {

										echo $dados['nr_qtde'] / 1000 . " t";
									} else {

										echo number_format($dados['nr_qtde'], 0) . " " . $dados['unid'];
									}

									?>
								</td>
								<td style="text-align: right;"> <?php echo $dados['ds_lp']; ?> </td>
								<td style="text-align: right;"> <?php echo $dados['ds_kva']; ?> </td>
								<td style="text-align: right;"> <?php echo $dados['nr_serial']; ?> </td>
								<td style="text-align: right;"> <?php echo $dados['ds_fabr']; ?> </td>
								<td style="text-align: right;"> <?php echo $dados['ds_ano']; ?> </td>
								<td style="text-align: right;"> <?php echo $dados['ds_enr']; ?> </td>
								<td style="text-align: right;"> <?php echo $dados['ds_obs']; ?> </td>
								<?php
								if ($dados['fl_status'] == 'A' || $dados['fl_status'] == 'K') {

									$td = '<td style="background-color: #F4A460">ABERTA</td>';
									echo $td;
								} else if ($dados['fl_status'] == 'C') {

									$td = '<td style="background-color: #9AFF9A">CONFERÊNCIA FINALIZADA</td>';
									echo $td;
								} else if ($dados['fl_status'] == 'F') {

									$td = '<td style="background-color: #B0C4DE">OR FINALIZADA</td>';
									echo $td;
								} else if ($dados['fl_status'] == 'S') {

									$td = '<td style="background-color: #FFFF00">AGUARDANDO CONFIRMAÇÃO</td>';
									echo $td;
								} else if ($dados['fl_status'] == 'AG') {

									$td = '<td style="background-color:#FFFF00">AGENDADA</td>';
									echo $td;
								} else if ($dados['fl_status'] == 'L') {

									$td = '<td style="background-color: #9AFF9A">LIBERADA</td>';
									echo $td;
								} else if ($dados['fl_status'] == 'CR') {

									$td = '<td style="background-color: #FFFF00">AGUARDANDO LIBERAÇÃO</td>';
									echo $td;
								} else if ($dados['fl_status'] == 'AT') {

									$td = '<td style="background-color: #9AFF9A">ENTRADA AUTORIZADA</td>';
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
	$('#btnRecebEntExcel').on('click', function() {
		event.preventDefault();
		$('#btnRecebEntExcel').prop("disabled", true);
		var today = new Date();
		$(".tabRecebEnt").table2excel({
			name: "Relatório de entradas no recebimento",
			filename: "Relatório de entradas no recebimento"
		});
		$('#btnRecebEntExcel').prop("disabled", false);

	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		//$('#example').DataTable();
		$("#example10").dataTable({
			"aLengthMenu": [5000]
		});
	});
</script>