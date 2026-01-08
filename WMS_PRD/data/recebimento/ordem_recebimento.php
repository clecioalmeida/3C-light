<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec = $_POST['cod_rec'];

$big_select="set sql_big_selects=1";
$res_select = mysqli_query($link,$big_select);

$SQL = "select t1.nm_cliente, t2.dt_recebimento_real, t2.dt_create
from tb_recebimento t2 
left join tb_cliente t1 on t1.cod_cliente = t2.cod_cli
where t2.cod_recebimento = '$cod_rec'";
$res_saldo = mysqli_query($link,$SQL);
while ($dados=mysqli_fetch_assoc($res_saldo)) {
	$nm_cliente = $dados['nm_cliente'];
	$dt_recebimento_real = $dados['dt_recebimento_real'];
	$dt_user_criado_por = $dados['dt_user_criado_por'];
}

$SQL_prod = "select t1.nr_qtde as qtd_item, t1.nr_volume, t1.cod_nf_entrada_item, t1.fl_status, t2.cod_produto, t2.cod_prod_cliente, t2.nm_produto, t3.nr_fisc_ent,
 t3.qtd_vol_ent, t3.tp_vol_ent
from tb_nf_entrada_item t1
left join tb_produto t2 on t1.produto = t2.cod_produto or t1.produto = t2.cod_prod_cliente
left join tb_nf_entrada t3 on t1.cod_nf_entrada = t3.cod_nf_entrada
where t3.cod_rec = '$cod_rec' and t1.fl_status <> 'E'
group by t1.produto";
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
											<h1 class="font-10">Ordem de recebimento <?php echo $cod_rec;?></h1>
											<strong>Criada em:</strong>
														<span> <i class="fa fa-calendar"></i> 
															<?php 
																if($dt_user_criado_por > 0){
																	echo date('d/m/Y', strtotime($dt_user_criado_por));
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
														<strong>Cliente :</strong>
														<span><i class="fa fa-calendar"></i> <?php echo $nm_cliente;?> |</span>
														<strong>Data do recebimento :</strong>
														<span> <i class="fa fa-calendar"></i> 
															<?php 
																if($dt_recebimento_real > 0){
																	echo date('d/m/Y', strtotime($dt_recebimento_real));
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
														
														<span class="pull-right"><i class="fa fa-calendar"></i> 
															<?php
																if($dt_recebimento_real >0){
																	 echo date('d/m/Y', strtotime("+4 days",strtotime($dt_recebimento_real)));
																}else{
																	echo '';
																}
															?>
														</span>
														<strong class="pull-right">Prazo para recebimento :</strong>	
													</div>
												</div>
												<br><br>
											</div>
										</div>
										<table class="table table-hover" style="width: 100%">
											<thead>
												<tr>
													<th>COD CLIENTE</th>
													<th>PRODUTO</th>
													<th style="text-align: right;">NOTA FISCAL</th>
													<th style="text-align: center;">VOLUME</th>
													<th style="text-align: right;">QTD</th>
													<th style="text-align: center;">QTDE NF</th>
													<!--th>CÓDIGO</th-->
												</tr>
											</thead>
											<tbody>
												<?php 
													while ($dados=mysqli_fetch_assoc($res_prod)) {
												?>
												<tr>
													<td><?php echo $dados['cod_prod_cliente'];?></td>
													<td><?php echo $dados['nm_produto'];?></td>
													<td style="text-align: right;"><?php echo $dados['nr_fisc_ent'];?></td>
													<td style="text-align: center;"><?php echo $dados['nr_volume'];?></td>
													<td style="text-align: right;"><?php echo number_format($dados['qtd_item'], 0, ',', ' ');?></td>
													<td style="text-align: center;"><input type="text" id="" name="" style="border: 1px solid"></td>
													<!--td style="text-align: center;"><svg id="barcode" 
															  class="barcode"
															  jsbarcode-format="auto"
															  jsbarcode-height="20"
															  jsbarcode-displayValue="true"
															  jsbarcode-value="<?php echo $dados['cod_prod_cliente'];?>"
															  jsbarcode-textmargin="0"
															  jsbarcode-fontoptions="bold">
													</svg></td-->
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