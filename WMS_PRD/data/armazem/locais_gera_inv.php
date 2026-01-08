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

$cod_prd = $_POST['cod_prd'];

?>

<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

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
			<h1 class="font-200">Controle de inventário rotativo</h1>
		</div>
		<div class="clearfix"></div>
		<br>
		<br>
		<table class="display responsive nowrap" id="example12" style="width:100%">
			<thead>
				<tr>
					<th> CÓDIGO </th>
					<th> DESCRIÇÃO </th>
					<th> COD. ESTOQUE</th>
					<th> ETIQUETA </th>
					<th> LOCAL </th>
					<th> ENDEREÇO </th>
					<th> ETIQ. PRODUTO</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($cod_prd as $value) {

					$sql_local = "SELECT t1.produto, t2.nm_produto, t3.cod_estoque, t5.id as id_etq, t4.nome, t3.ds_prateleira, t3.ds_coluna, t3.ds_altura
					from tb_pedido_coleta_produto t1
					left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
					left join tb_posicao_pallet t3 on t1.produto = t3.produto
					left join tb_armazem t4 on t3.ds_galpao = t4.id
					left join tb_etiqueta t5 on t3.cod_estoque = t5.cod_estoque
					where t1.produto = '" . $value . "' and t3.ds_galpao <> '7' and t3.nr_qtde > 0
					group by t3.cod_estoque
					order by t3.ds_galpao, t3.ds_prateleira, t3.ds_coluna";
					$res_local = mysqli_query($link, $sql_local);
					$tr_local = mysqli_num_rows($res_local);
					while ($dados_local = mysqli_fetch_assoc($res_local)) { ?>
						<tr class="odd gradeX">
							<td style="text-align: right; width: 5px;"><?php echo $dados_local['produto']; ?> </td>
							<td style="text-align: left; width: 5px;"><?php echo $dados_local['nm_produto']; ?> </td>
							<td style="text-align: right; width: 5px"> <?php echo $dados_local['cod_estoque']; ?> </td>
							<td style="text-align: right; width: 5px"> <?php echo $dados_local['id_etq']; ?> </td>
							<td style="text-align: right; width: 5px"> <?php echo $dados_local['nome']; ?> </td>
							<td style="text-align: right; width: 5px"> <?php echo $dados_local['ds_prateleira'] . "-" . $dados_local['ds_coluna'] . "-" . $dados_local['ds_altura']; ?> </td>
							<td style="text-align: center; width: 100px">

								<?php if ($dados_local['id_etq']) { ?>

									<svg id="barcode" class="barcode" jsbarcode-format="auto" jsbarcode-height="50" jsbarcode-displayValue="false" jsbarcode-value="<?php echo $dados_local['produto'] . "-" . $dados_local['id_etq']; ?>" jsbarcode-textmargin="0" jsbarcode-fontoptions="bold">
									</svg>

								<?php } else {

									echo "";
								} ?>
							</td>
						</tr>
				<?php }
				}
				$link->close(); ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#example12").dataTable({
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
			name: "Controle de inventário rotativo",
			filename: "Controle de inventário rotativo " + today
		});
		$('#RepEstoqGenExcel').prop("disabled", false);

	});
</script>