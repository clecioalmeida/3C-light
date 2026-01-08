<?php 
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$nr_onda = $_POST['nr_onda'];
$ds_galpao = $_POST['ds_galpao'];
$ds_prateleira = $_POST['ds_prateleira'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$SQL = "select dt_create from tb_onda where id = '$nr_onda'";
$res = mysqli_query($link,$SQL);
while ($dados=mysqli_fetch_assoc($res)) {
	$dt_create = $dados['dt_create'];
}

$SQL_prod = "select t1.cod_col, t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, sum(t1.nr_qtde_col) as nr_qtde_col, t2.cod_prod_cliente, t2.nm_produto, t3.nome, t3.ds_apelido
from tb_coleta_pedido t1
left join tb_produto t2 on t1.produto = t2.cod_produto
left join tb_armazem t3 on t1.ds_galpao = t3.id
where t1.nr_onda = '$nr_onda' and t1.ds_galpao = '$ds_galpao' and t1.ds_prateleira = '$ds_prateleira' and t1.nr_qtde_col > 0
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
											<h1 class="font-10">Onda:<?php echo $nr_onda;?></h1>
											<strong>Criada em:<?php echo date('d/m/Y',strtotime($dt_create));?></strong>
												<span> <i class="fa fa-calendar"></i> 
												
												</span><br />
											<strong><h3 style="background-color: #FF7F50">Doca: STAGE</h3></strong>
										</div>
										<div class="clearfix"></div>
										<br>
										<br>
										<div class="row">
											<div class="col-sm-12">
												<div>
													<div class="col-sm-8">
														<strong>PICKING POR ONDA</strong> |</span>
														<strong> <?php echo "Galpão: ".$ds_galpao." - Rua: ".$ds_prateleira;?></strong>
														<!--span> <i class="fa fa-calendar"></i> 
															
														</span-->
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
													<th style="width: 100px">ENDEREÇO</th>
													<!--th>COD PRODUTO</th-->
													<th>COD SAP</th>
													<th>PRODUTO</th>
													<!--th style="text-align: right;">ARMAZÉM</th>
													<th style="text-align: center;">ENDEREÇO</th-->
													<th style="text-align: center;">QTDE</th>
													<th style="text-align: center;">CÓDIGO</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													while ($dados=mysqli_fetch_assoc($res_prod)) {
														$local=$dados['ds_apelido'].$dados['ds_prateleira'].$dados['ds_altura'].$dados['ds_coluna'];
												?>
												<tr>
													<td style="text-align: center;width: 100px"><svg id="barcode" 
															  class="barcode"
															  jsbarcode-format="auto"
															  jsbarcode-height="20"
															  jsbarcode-displayValue="true"
															  jsbarcode-value="<?php echo $local;?>"
															  jsbarcode-textmargin="0"
															  jsbarcode-fontoptions="bold">
													</svg></td>
													<!--td id="cod_produto" style="text-align: center;"><?php echo $dados['cod_produto'];?></td-->
													<td><?php echo $dados['cod_prod_cliente'];?></td>
													<td><?php echo $dados['nm_produto'];?></td>
													<!--td style="text-align: right;"><?php echo $dados['nome'];?></td>
													<td style="text-align: center;"><?php echo $dados['ds_apelido'].$dados['ds_prateleira'].$dados['ds_altura'].$dados['ds_coluna'];?></td-->
													<td style="text-align: center;"><?php echo $dados['nr_qtde_col'];?></td>
													<td style="text-align: center;"><svg id="barcode" 
															  class="barcode"
															  jsbarcode-format="auto"
															  jsbarcode-height="20"
															  jsbarcode-displayValue="true"
															  jsbarcode-value="<?php echo $dados['produto'];?>"
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
				
											</div><br /><br /><br />
												
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