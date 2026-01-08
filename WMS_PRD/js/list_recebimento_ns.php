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

$nserie = $_POST['nserie'];

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$SQL = "select n.id, n.id_produto, n.n_serie, n.status_sap, n.fl_status, p.nm_produto, n.nm_fornecedor, date(n.dt_create) as dt_create
from tb_nserie n 
left join tb_produto p on n.id_produto = p.cod_prod_cliente
where n.n_serie = '$nserie'";
$res = mysqli_query($link, $SQL);

$link->close();
?>

<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet" />
<!--script src="https://code.jquery.com/jquery-3.5.1.js"></script-->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

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

	/* CAMPO INPUT DENTRO DA TD */

	table td {
		position: relative;
	}

	table td input {
		position: absolute;
		display: block;
		top: 0;
		left: 0;
		margin: 0;
		height: 100%;
		width: 100%;
		border: none;
		padding: 10px;
		box-sizing: border-box;
		font-size: 12px;
		text-align: right;

	}

	table td select {
		position: absolute;
		display: block;
		top: 0;
		left: 0;
		margin: 0;
		height: 100%;
		width: 300px;
		border: none;
		padding: 10px;
		box-sizing: border-box;
		font-size: 12px;
		text-align: right;
	}
</style>
<button type="submit" class="btn btn-success" id="RepNserieGenExcel" style="float:right;width: 100px">Excel</button>
<br><br>
<div id="reportSalNserie">
	<table class="display responsive nowrap" id="example19" style="width: 100%">
		<thead>
			<tr>
				<th> NÚMERO DE SÉRIE </th>
				<th> PRODUTO </th>
				<th> DESCRIÇÃO </th>
				<th> FORNECEDOR</th>
				<th> DATA DE INCLUSÃO</th>
				<th> STATUS </th>
				<th> AÇÕES </th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($dados = mysqli_fetch_array($res)) {
			?>
				<tr>
					<td style="text-align: right; width: 10px"> <?php echo $dados['n_serie']; ?> </td>
					<td style="text-align: right; width: 10px"> <?php echo $dados['id_porduto']; ?> </td>
					<td style="text-align: left;"><?php echo $dados['nm_produto']; ?></td>
					<td> <?php echo $dados['nm_fornecedor']; ?> </td>
					<td> <?php echo $dados['dt_create']; ?> </td>
					<?php
					if ($dados['fl_status'] == 'A' || $dados['fl_status'] == 'K') {

						$td = '<td>DISPONÍVEL</td>';
						echo $td;
					} else if ($dados['fl_status'] == 'E') {

						$td = '<td>EXCLUÍDO</td>';
						echo $td;
					} else if ($dados['fl_status'] == 'F') {

						$td = '<td>EXPEDIDO</td>';
						echo $td;
					}
					?>
					<td>
						<button type="submit" id="btnDelNs" class="btn btn-primary btn-xs" value="<?php echo $dados['n_serie']; ?>">EXCLUIR</button>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#example19").dataTable({
			"aLengthMenu": [5000]
		});
	});
</script>
<script type="text/javascript">
	$('#RepNserieGenExcel').on('click', function() {
		event.preventDefault();
		$('#RepNserieGenExcel').prop("disabled", true);
		var today = new Date();
		$("#reportSalNserie").table2excel({
			exclude: ".noExl",
			name: "Relatório de números de série",
			filename: "Relatório de números de série" + today
		});
		$('#RepNserieGenExcel').prop("disabled", false);

	});
</script>