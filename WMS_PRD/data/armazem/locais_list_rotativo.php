<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;
} else {

	$id = $_SESSION["id"];
	$cod_cli = $_SESSION["cod_cli"];
}

?>
<?php
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_local = "SELECT t1.produto, count(t1.produto) as total_rot, t2.nm_produto
from tb_pedido_coleta_produto t1
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
where t1.fl_status = 'F' and t1.produto > '0' and month(t1.dt_create) >= '12'
group by t1.produto
order by count(t1.produto) DESC
limit 100";
$res_local = mysqli_query($link, $sql_local);
$tr_local = mysqli_num_rows($res_local);

$link->close();
?>
<?php
if ($tr_local) {
?>

	<script type="text/javascript">
		function printContent(el) {
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
		}
	</script>
	<div class="col-sm-12 text-align-right">
		<div class="btn-group">
			<button type="submit" class="btn btn-success" id="RepEstoqGenExcel" style="float:right;width: 100px">Excel</button>
			<button onclick="printContent('reportSalEstoque')" type="submit" class="btn btn-primary" id="RepEstoqGenPdf" style="float:right;width: 100px">Imprimir</button>
		</div>
	</div>
	<div id="reportSalEstoque">
		<div class="padding-10">
			<div class="pull-left">
				<img src="img/logo3c2.png" width="80" height="32" alt="Gisis">
				<address>
					<br>
					<strong>3C Services</strong>
				</address>
			</div>
			<div class="pull-right">
				<h1 class="font-200">Relatório de saldo de estoque por produto</h1>
			</div>
			<div class="clearfix"></div>
			<br>
			<br>
			<table class="display responsive nowrap" id="example11" style="width:80%">
				<thead>
					<tr>
						<th class="hasinput" style="width: 20px;display: none">
							<div class="form-group">
								<label class="checkbox-inline">
									<input type="checkbox" id="checkboxTodos" class="checkbox style-0">
									<span></span>
								</label>
							</div>
						</th>
						<th> CÓDIGO </th>
						<th> DESCRIÇÃO </th>
						<th> ROTATIVIDADE</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($dados_local = mysqli_fetch_assoc($res_local)) {
					?>
						<tr class="odd gradeX">
							<td style="display: none">
								<div class="form-group">
									<label class="checkbox-inline">
										<input type="checkbox" class="checkbox style-0 checkPrdRot" id="checkPrdRot" value="<?php echo $dados_local['produto']; ?>" checked>
										<span></span>
									</label>
								</div>
							</td>
							<td style="text-align: right; width: 5px;"><?php echo $dados_local['produto']; ?> </td>
							<td style="text-align: left; width: 5px;"><?php echo $dados_local['nm_produto']; ?> </td>
							<td style="text-align: right; width: 5px"> <?php echo $dados_local['total_rot']; ?> </td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#example11").dataTable({
				"aLengthMenu": [5000]
			});
		});
	</script>
	<script type="text/javascript" src="./js/JsBarcode.all.min.js"></script>
	<script type="text/javascript">
		JsBarcode(".barcode").init();
	</script>
	<script type="text/javascript">
		$('#RepEstoqGenExcel').on('click', function() {
			event.preventDefault();
			$('#RepEstoqGenExcel').prop("disabled", true);
			var today = new Date();
			$("#reportSalEstoque").table2excel({
				exclude: ".noExl",
				name: "Consulta fechamento de inventário - Analítico",
				filename: "Relatório de saldo de estoque detalhado" + today
			});
			$('#RepEstoqGenExcel').prop("disabled", false);

		});
	</script>
<?php } else { ?>

	<h4>Nao foram encontrados produtos com esta descrição.</h4>

<?php }
?>