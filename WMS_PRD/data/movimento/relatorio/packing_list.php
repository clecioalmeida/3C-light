<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_pedido = $_POST['nr_pedido'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$SQL = "select t1.dt_pedido, t1.dt_limite, t2.nm_cliente, t3.ds_doca, t3.fl_tipo
from tb_pedido_coleta t1
left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente
left join tb_doca t3 on t1.id_doca = t3.id
where t1.nr_pedido = '$cod_pedido'";
$res = mysqli_query($link, $SQL);
while ($dados = mysqli_fetch_assoc($res)) {
	$dt_pedido = $dados['dt_pedido'];
	$nm_cliente = $dados['nm_cliente'];
	$dt_limite = $dados['dt_limite'];
	$ds_doca = $dados['ds_doca'];
	$fl_tipo = $dados['fl_tipo'];
}

$SQL_prod = "select t1.*, count(t1.nr_pedido) as embalagens, t2.cod_prod_cliente, t2.nm_produto, t3.ds_tipo
from tb_pedido_manuseio t1
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_embalagem t3 on t1.id_embalagem = t3.id
where t1.nr_pedido = '$cod_pedido'
order by t1.produto asc";
$res_prod = mysqli_query($link, $SQL_prod);

$link->close();

?>
<script type="text/javascript" src="./js/jspdf.min.js"></script>
<script type="text/javascript">
	function printContent(el){
		var restorepage = document.body.innerHTML;
		var printcontent = document.getElementById(el).innerHTML;
		document.body.innerHTML = printcontent;
		window.print();
		document.body.innerHTML = restorepage;
}
</script>
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
													<!--a href="javascript:demoFromHTML()" class="button">JsPdf</a-->
													<button onclick="printContent('reportSalEstoque')" type="submit" class="btn btn-primary" id="RepEstoqGenPdf" style="float:right;width: 100px">Imprimir</button>
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
											<h1 class="font-10">Packing list: <?php echo $cod_pedido; ?></h1>
											<strong>Criada em:</strong>
												<span> <i class="fa fa-calendar"></i>
												<?php
if ($dt_pedido > 0) {
	echo date('d/m/Y', strtotime($dt_pedido));
} else {
	echo '';
}
?>
												</span><br />
											<strong><h3 style="background-color: #FF7F50">Doca:<?php echo $ds_doca . " - " . $fl_tipo; ?></h3></strong>
										</div>
										<div class="clearfix"></div>
										<br>
										<br>
										<div class="row">
											<div class="col-sm-12">
												<div>
													<div class="col-sm-8">
														<strongCliente :</strong>
														<span><i class="fa fa-calendar"></i> <?php echo $nm_cliente; ?> |</span>
														<strong>Data limite para entrega:</strong>
														<span style="background-color: #FF7F50"> <i class="fa fa-calendar"></i>
															<?php
if ($dt_limite > 0) {
	echo date('d/m/Y', strtotime($dt_limite));
} else {
	echo '';
}
?>
														</span>
														<!--strong>Armazém :</strong>
														<span> <?php echo $ds_armazem; ?> |</span>
														<strong>Produto :</strong>
														<span> <?php echo $cod_produto; ?> </span-->
													</div>
													<div class="col-sm-4 ">

														<!--span class="pull-right"><i class="fa fa-calendar"></i>
															<?php
if ($dt_limite > 0) {
	echo date('d/m/Y', strtotime($dt_limite));
} else {
	echo '';
}
?>
														</span>
														<strong class="pull-right">Data limite para entrega:</strong-->
													</div>
												</div>
												<br><br>
											</div>
										</div>
										<table class="table table-hover">
											<thead>
												<tr>
													<th style="width: 100px">PEDIDO</th>
													<th>COD SAP</th>
													<th>PRODUTO</th>
													<th>EMBALAGEM</th>
													<th style="text-align: right;">QTDE</th>
													<th style="text-align: center;">#</th>
												</tr>
											</thead>
											<tbody>
												<?php
while ($dados = mysqli_fetch_assoc($res_prod)) {?>
												<tr>
													<td style="text-align: center;width: 100px"><?php echo $dados['nr_pedido']; ?></td>
													<td><?php echo $dados['cod_prod_cliente']; ?></td>
													<td><?php echo $dados['nm_produto']; ?></td>
													<td><?php echo $dados['ds_tipo']; ?></td>
													<td style="text-align: right;"><?php echo $dados['qtd_vol']; ?></td>
													<td style="text-align: right;"><svg id="barcode"
															  class="barcode"
															  jsbarcode-format="auto"
															  jsbarcode-height="20"
															  jsbarcode-displayValue="true"
															  jsbarcode-value="<?php echo $dados['produto']; ?>"
															  jsbarcode-textmargin="0"
															  jsbarcode-fontoptions="bold">
													</svg></td>
												</tr>
												<?php }?>
											</tbody>
										</table>

										<div class="invoice-footer">

											<div class="row">

												<div class="col-sm-12">
													<p>Primeiro conferente:</p><br /><br /><br />
													<p>Nome: ___________________________________________________</p><br />
													<p>Data da conferência: ______/______/________</p>
												</div>

											</div>

											<div class="row">
												<div class="col-sm-12">
													<p>Segundo conferente:</p><br /><br /><br />
													<p>Nome: ___________________________________________________</p><br />
													<p>Data da conferência: ______/______/________</p></div>
											</div>
											<!--div class="page-footer">
											<div class="row">
												<div class="col-xs-12 col-sm-6">
													<span class="txt-color-white">GrowUp <span class="hidden-xs"> - Web Application</span> © 2016-2017</span>
												</div>
										</div>
									</div-->
								</div>
								</div>
							</div>
						</div>
	</article>

				</div>
			</section>
		</div>
<script type="text/javascript" src="js/JsBarcode.all.min.js"></script>
<script type="text/javascript">
		JsBarcode(".barcode").init();

</script>