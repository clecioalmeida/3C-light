<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

 $cod_pedido = $_POST['cod_pedido'];

$SQL = "select t1.dt_pedido, t1.dt_limite, t2.nm_cliente 
from tb_pedido_coleta t1
left join tb_cliente t2 on t1.cod_cliente = t2.cod_cliente
where t1.nr_pedido = '$cod_pedido'";
$res = mysqli_query($link,$SQL);
while ($dados=mysqli_fetch_assoc($res)) {
	$dt_pedido = $dados['dt_pedido'];
	$nm_cliente = $dados['nm_cliente'];
	$dt_limite = $dados['dt_limite'];
}

$SQL_prod = "select t2.nome, t3.cod_produto, t3.cod_prod_cliente, t3.nm_produto, t1.*
from tb_coleta_pedido t1
left join tb_armazem t2 on t1.ds_galpao = t2.id
left join tb_produto t3 on t1.produto = t3.cod_produto
where t1.nr_pedido = '$cod_pedido'
group by t1.produto, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura
order by t1.ds_prateleira, t1.ds_coluna, t1.ds_altura asc";
$res_prod = mysqli_query($link,$SQL_prod);

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
											<h1 class="font-10">Picking list: <?php echo $cod_pedido;?></h1>
											<strong>Criada em:</strong>
														<span> <i class="fa fa-calendar"></i> 
															<?php 
																if($dt_pedido > 0){
																	echo date('d/m/Y', strtotime($dt_pedido));
																}else{
																	echo '';
																}
															?> 
														</span>
										</div>
										<div class="clearfix"></div>
										<br>
										<br>
										<div class="row">
											<div class="col-sm-12">
												<div>
													<div class="col-sm-8">
														<strongCliente :</strong>
														<span><i class="fa fa-calendar"></i> <?php echo $nm_cliente;?> |</span>
														<strong>Data limite para entrega:</strong>
														<span> <i class="fa fa-calendar"></i> 
															<?php 
																if($dt_limite > 0){
																	echo date('d/m/Y', strtotime($dt_limite));
																}else{
																	echo '';
																}
															?> 
														</span>
														<!--strong>Armazém :</strong>
														<span> <?php echo $ds_armazem;?> |</span>
														<strong>Produto :</strong>
														<span> <?php echo $cod_produto;?> </span-->
													</div>
													<div class="col-sm-4 ">
														
														<!--span class="pull-right"><i class="fa fa-calendar"></i> 
															<?php 
																if($dt_limite > 0){
																	echo date('d/m/Y', strtotime($dt_limite));
																}else{
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
										<table class="table table-hover" style="width: 100%">
											<thead>
												<tr>
													<th>COD PRODUTO</th>
													<th>COD CLIENTE</th>
													<th>PRODUTO</th>
													<th style="text-align: right;">ARMAZÉM</th>
													<th style="text-align: center;">RUA</th>
													<th style="text-align: right;">COLUNA</th>
													<th style="text-align: center;">ALTURA</th>
													<th style="text-align: center;">QTDE</th>
													<th style="text-align: center;">CÓDIGO</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													while ($dados=mysqli_fetch_assoc($res_prod)) {
												?>
												<tr>
													<td id="cod_produto" style="text-align: center;"><?php echo $dados['cod_produto'];?></td>
													<td><?php echo $dados['cod_prod_cliente'];?></td>
													<td><?php echo $dados['nm_produto'];?></td>
													<td style="text-align: right;"><?php echo $dados['nome'];?></td>
													<td style="text-align: center;"><?php echo $dados['ds_prateleira'];?></td>
													<td style="text-align: right;"><?php echo $dados['ds_coluna'];?></td>
													<td style="text-align: center;"><?php echo $dados['ds_altura'];?></td>
													<td style="text-align: center;"><?php echo $dados['nr_qtde_col'];?></td>
													<td style="text-align: center;"><svg id="barcode" 
															  class="barcode"
															  jsbarcode-format="auto"
															  jsbarcode-height="20"
															  jsbarcode-displayValue="true"
															  jsbarcode-value="<?php echo $dados['cod_produto'];?>"
															  jsbarcode-textmargin="0"
															  jsbarcode-fontoptions="bold">
													</svg></td>
												</tr>
												<?php } ?>
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
											<div class="page-footer">
											<div class="row">
												<div class="col-xs-12 col-sm-6">
													<span class="txt-color-white">GrowUp <span class="hidden-xs"> - Web Application</span> © 2016-2017</span>
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
<script type="text/javascript" src="js/JsBarcode.all.min.js"></script>
<script type="text/javascript">
		JsBarcode(".barcode").init();
	
</script>