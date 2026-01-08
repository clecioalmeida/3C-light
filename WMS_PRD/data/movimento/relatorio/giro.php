<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$CodProduto = $_POST['CodProduto'];
$CodProdCliente = $_POST['CodProdCliente'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

if ($CodProduto != '') {

	$sql_prd = "select cod_prod_cliente, nm_produto from tb_produto where cod_produto = '$CodProduto' and fl_status <> 'E'";
	$res_prd = mysqli_query($link, $sql_prd);
	while ($prd = mysqli_fetch_assoc($res_prd)) {
		$nm_produto = $prd['nm_produto'];
		$cod_prod_cliente = $prd['cod_prod_cliente'];
	}

	$SQL = "select produto, nr_mes, qtd_rec, qtd_ped, nr_saldo, (total/media) as giro, tempo, cod_produto, cod_prod_cliente, nm_produto
		from (select t1.produto, t1.nr_mes, sum(t1.qtd_rec) as qtd_rec, sum(t1.qtd_ped) as qtd_ped, t1.nr_saldo,
		sum(t1.qtd_ped) as total, avg(t1.nr_saldo) as media,
		(TIMESTAMPDIFF(DAY,min(dt_mes),max(dt_mes))/(sum(t1.qtd_ped)/avg(t1.nr_saldo))) as tempo, t2.cod_produto,
    	t2.cod_prod_cliente, t2.nm_produto
		from tb_giro t1
    	left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
		WHERE  (produto = '$CodProduto' or produto = '$CodProdCliente') and nr_mes >=  DAY(now()) - 395) virtual
		where total > 0
		order by giro desc
		limit 0,10";
	$res_saldo = mysqli_query($link, $SQL);
	while ($dados = mysqli_fetch_assoc($res_saldo)) {
		//$cod_prod_cliente = $dados['cod_prod_cliente'];
		$nm_produto = $dados['nm_produto'];
		$giro = $dados['giro'];
		$tempo = $dados['tempo'];
	}

} else {

	$sql_prd = "select cod_produto, nm_produto from tb_produto where cod_prod_cliente = '$CodProdCliente' and fl_status <> 'E'";
	$res_prd = mysqli_query($link, $sql_prd);
	while ($prd = mysqli_fetch_assoc($res_prd)) {
		$nm_produto = $prd['nm_produto'];
		$cod_produto = $prd['cod_produto'];
	}

	$SQL = "select produto, nr_mes, qtd_rec, qtd_ped, nr_saldo, (total/media) as giro, tempo, cod_produto, cod_prod_cliente, nm_produto
		from (select t1.produto, t1.nr_mes, sum(t1.qtd_rec) as qtd_rec, sum(t1.qtd_ped) as qtd_ped, t1.nr_saldo, sum(t1.qtd_ped) as total, avg(t1.nr_saldo) as media,
		(TIMESTAMPDIFF(DAY,min(dt_mes),max(dt_mes))/(sum(t1.qtd_ped)/avg(t1.nr_saldo))) as tempo, t2.cod_produto,
    t2.cod_prod_cliente, t2.nm_produto
		from tb_giro t1
    left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
		WHERE (produto = '$cod_produto' or produto = '$CodProdCliente') and nr_mes >=  DAY(now()) - 395) virtual
		where total > 0
		order by giro desc
		limit 0,10";
	$res_saldo = mysqli_query($link, $SQL);
	while ($dados = mysqli_fetch_assoc($res_saldo)) {
		$cod_prod_cliente = $dados['cod_prod_cliente'];
		$nm_produto = $dados['nm_produto'];
		$giro = $dados['giro'];
		$tempo = $dados['tempo'];
	}

}

$query = "select t1.*, t2.nm_produto, t2.cod_produto, t2.cod_prod_cliente
from tb_giro t1
left join tb_produto t2 on t1.produto = t2.cod_produto or t1.produto = t2.cod_prod_cliente
where (produto = '$CodProduto' or produto = '$cod_prod_cliente')
order by t1.nr_mes asc";
$res = mysqli_query($link, $query);

$link->close();

?>
<div id="content">
	<section id="widget-grid" class="">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget well jarviswidget-color-darken" id="wid-id-0" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-colorbutton="false">
					<div>
						<div class="jarviswidget-editbox">
							</div>
								<div class="widget-body no-padding">
									<div class="widget-body-toolbar" id="toolbar">
										<div class="row">
											<div class="col-sm-4">
											</div>
											<div class="col-sm-8 text-align-right">
												<!--div class="btn-group">
													<button class="btn btn-sm btn-primary" id="" style="width: 100px">PDF</button>
												</div-->
												<div class="btn-group">
													<button type="submit" class="btn btn-success" id="RepEstoqGenExcel" style="float:right;width: 100px">Excel</button>
												</div>
											</div>

											<div id="retorno"></div>
										</div>
									</div>

								<div id="reportSalEstoque">
									<div class="padding-10">
										<div class="pull-left">
											<img src="img/Logo3C.jpg" width="80" height="32" alt="Gisis">
											<address>
												<br>
												<strong>3C Services</strong>
											</address>
										</div>
										<div class="pull-right">
											<h1 class="font-200">Relatório de giro de estoque por produto</h1>
										</div>
										<div class="clearfix"></div>
										<br>
										<br>
										<div class="row">
											<div class="col-sm-12">
												<div>
													<div class="col-sm-8">
														<strong>Produto:</strong>
														<span> <?php echo $nm_produto; ?> </span><span> <?php echo " | "; ?> </span>
														<strong>Giro:</strong>
														<span style="background-color: #B0E0E6"> <?php echo $giro; ?> </span><span> <?php echo " vezes no período | "; ?> </span>
														<strong>Tempo médio (dias):</strong>
														<span style="background-color: #B0E0E6"> <?php echo $tempo; ?> </span><span> <?php echo " | "; ?> </span>
														<strong>Período:</strong>
														<span > Ultimos 12 meses </span>
													</div>
													<div class="col-sm-4 ">
													</div>
												</div>
												<br><br>
											</div>
										</div>
										<table class="table table-hover">
											<thead>
												<tr>
													<th class="text-center">CÓDIGO</th>
													<th>PRODUTO</th>
													<th>MÊS</th>
													<th>ENTRADAS</th>
													<th>SAÍDAS</th>
													<th>SALDO</th>
												</tr>
											</thead>
											<tbody>
												<?php
while ($dados = mysqli_fetch_assoc($res)) {
	?>
												<tr>
													<td class="text-center"><?php echo $dados['cod_prod_cliente']; ?></td>
													<td><?php echo $dados['nm_produto']; ?></td>
													<td><?php echo $dados['nr_mes']; ?></td>
													<td style="text-align: right;"><?php echo $dados['qtd_rec']; ?></td>
													<td style="text-align: right;"><?php echo $dados['qtd_ped']; ?></td>
													<td style="text-align: right;"><?php echo $dados['nr_saldo']; ?></td>
												</tr>
												<?php }?>
											</tbody>
										</table>

										<div class="invoice-footer">

											<div class="row">

												<div class="col-sm-7"></div>
												<div class="col-sm-5"></div>

											</div>

											<div class="row">
												<div class="col-sm-12"></div>
											</div>

										</div>
									</div>
								</div>
								</div>
							</div>
						</div>
					</article>

				</div>
			</section>
		</div>

<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src="data/movimento/relatorio/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.2/jspdf.plugin.autotable.js"></script>
<script type="text/javascript">

	function pdfToHTML(){
		var pdf = new jsPDF('l', 'pt', 'a4');
		source = $('#reportSalEstoque')[0];
		hide = {
			'#toolbar': function(element, renderer){
				return true
			}
		}
		margins = {
		    top: 15,
		    left: 15,
		    width: 180
		  };

		pdf.fromHTML(
		  	source // HTML string or DOM elem ref.
		  	, margins.left // x coord
		  	, margins.top // y coord
		  	, {
		  		'width': margins.width // max width of content on PDF
		  		, 'elementHandlers': hide
		  	},
		  	function (dispose) {
		  	  // dispose: object with X, Y of the last line add to the PDF
		  	  //          this allow the insertion of new lines after html
		        pdf.save('Relatorio_de_saldo_de_estoque.pdf');
		      }
		  )
		}
</script-->
<!--script type="text/javascript">
	function PDFId() {
    var div = document.getElementById("reportSalEstoque").innerHTML;
    //document.getElementById("hiddenhtml").value = elem;
}
</script-->
<?php

/*
use Dompdf\Dompdf;

$dompdf = new DOMPDF();

$dompdf->load_html('div');

$dompdf->render();

$dompdf->stream(
array(

"attachment" => false
)

);
 */
?>