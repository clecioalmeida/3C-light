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

$nmForn = $_POST['nmForn'];

$big_select = "set sql_big_selects=1";
$res_select = mysqli_query($link, $big_select);

$SQL = "SELECT c.id as id_col, c.ds_data, c.nm_fornecedor, c.fl_status, c.usr_create, c.dt_create, p.cod_produto, 
n.id, n.id_produto, n.n_serie, n.status_sap, p.nm_produto, u.nm_user, n.ds_emb_primaria
from tb_nserie_col c
left join tb_nserie n on c.id = n.id_col
left join tb_produto p on n.id_produto = p.cod_prod_cliente
left join tb_usuario u on n.usr_update = u.id or n.usr_create = u.id
where (c.fl_status = 'A' or c.fl_status = 'P') and n.fl_status <> 'E' and c.nm_fornecedor = '$nmForn'
order by c.ds_data desc";
$res = mysqli_query($link, $SQL);

$sql_query = "SELECT date_format(c.ds_data, '%d/%m/%Y') as ds_data, count(n.n_serie) as total_col
from tb_nserie_col c
left join tb_nserie n on c.id = n.id_col
where (c.fl_status = 'A' or c.fl_status = 'P') and n.fl_status <> 'E' and c.nm_fornecedor = '$nmForn'
group by c.id
order by c.ds_data";
$res_query = mysqli_query($link, $sql_query);

$sql_query_total = "SELECT count(n.n_serie) as total_col
from tb_nserie_col c
left join tb_nserie n on c.id = n.id_col
where (c.fl_status = 'A' or c.fl_status = 'P') and n.fl_status <> 'E' and c.nm_fornecedor = '$nmForn'
group by c.nm_fornecedor";
$res_query_total = mysqli_query($link, $sql_query_total);

$subTotal = '';
while($dados_querys = mysqli_fetch_assoc($res_query)) {

	$subTotal .= "<div class='col-sm-3'>
                <h5 style='font-weight: bold'>" . $dados_querys['ds_data'] . ": <span class='txt-color-blue'>" . $dados_querys['total_col'] . "</span></h5>
            </div>";

}

$totalGeral = '';
while($dados_querys = mysqli_fetch_assoc($res_query_total)) {

	$subTotal .= "<div class='col-sm-3'>
                <h5 style='font-weight: bold'>Total Geral: <span class='txt-color-red'>" . $dados_querys['total_col'] . "</span></h5>
            </div>";

}

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
<button type="submit" class="btn btn-success" id="RepFornExcel" style="float:right;width: 100px">Excel</button>
<br><br>

<section>
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="retSumDesp">
			<?= $subTotal ?>
		</article>
	</div>
</section>

<br><br>

<div id="reportSalForn">
	<table class="display responsive nowrap" id="example19" style="width: 100%">
		<thead>
			<tr>
				<th> NÚMERO DE SÉRIE </th>
				<th> PRODUTO </th>
				<th> PALLET </th>
				<th> DESCRIÇÃO </th>
				<th> FORNECEDOR</th>
				<th> DATA DE INCLUSÃO</th>
				<th> RESPONSÁVEL</th>
				<th> STATUS </th>
				<th> ETIQUETA </th>
				<th> AÇÕES </th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($dados = mysqli_fetch_array($res)) {
			?>
				<tr>
					<td style="text-align: right; width: 10px"> <?php echo $dados['n_serie']; ?> </td>
					<td style="text-align: right; width: 10px"> <?php echo $dados['id_produto']; ?> </td>
					<td style="text-align: right; width: 10px"> <?php echo $dados['ds_emb_primaria']; ?> </td>
					<td style="text-align: left;"><?php echo $dados['nm_produto']; ?></td>
					<td> <?php echo $dados['nm_fornecedor']; ?> </td>
					<td> <?php echo $dados['dt_create']; ?> </td>
					<td> <?php echo $dados['nm_user']; ?> </td>
					<td>
						<?php if ($dados['fl_status'] == 'A' || $dados['fl_status'] == 'K') { ?>
							DISPONÍVEL
						<?php } else if ($dados['fl_status'] == 'E') { ?>
							EXCLUÍDO
						<?php } else if ($dados['fl_status'] == 'F') { ?>
							EXPEDIDO
						<?php } ?>
					</td>
					<td></td>
					<td>
						<button type="submit" id="btnDelSeriePrd" class="btn btn-primary btn-xs" value="<?php echo $dados['n_serie']; ?>">EXCLUIR</button>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div id="retListSeriePrd"></div>

<script type="text/javascript">
	$('#RepFornExcel').on('click', function() {
		event.preventDefault();
		$('#RepFornExcel').prop("disabled", true);
		var today = new Date();
		$("#reportSalForn").table2excel({
			name: "Relatório de números de série",
			filename: "Relatório de números de série"
		});
		$('#RepFornExcel').prop("disabled", false);

	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#example19").dataTable({
			"aLengthMenu": [5000]
		});
	});
</script>