<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

 $dt_inicial = $_POST['dt_inicial'];
 $dt_final = $_POST['dt_final'];
 $cod_produto = $_POST['cod_produto'];
 $tipoMovimento = $_POST['tipoMovimento'];
 $ds_armazem = $_POST['ds_armazem'];
 $dt_relatorio = date('d/m/Y');

$SQL = "select t1.cod_recebimento, t1.dt_recebimento_real, t5.dt_pedido, t2.fl_tipo, t5.fl_tipo as pedido, t2.produto, t2.nr_qtde, t3.nm_produto, t4.produto, t5.nr_pedido 
from tb_recebimento t1
inner join tb_saldo_produto t2 on t1.cod_recebimento = t2.cod_compra_venda
left join tb_produto t3 on t2.produto = t3.cod_produto
left join tb_pedido_coleta_produto t4 on t2.produto = t4.produto
left join tb_pedido_coleta t5 on t5.nr_pedido = t4.nr_pedido";
$res_estoq = mysqli_query($link,$SQL); 

$SQL_torre = "select * from tb_tipo_torre";
$res_torre = mysqli_query($link,$SQL_torre); 

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
									<div class="widget-body-toolbar">
										<div class="row">
											<div class="col-sm-4">
											</div>
											<div class="col-sm-8 text-align-right">
												<div class="btn-group">
													<button class="btn btn-sm btn-primary" id="btnRelEstPdf">PDF</button>
												</div>
												<div class="btn-group">
												</div>
											</div>
										</div>
									</div>
									<div class="padding-10" id="reportEstoque">
										<br>
										<div class="pull-left">
											<img src="img/Logo3C.jpg" width="80" height="32" alt="invoice icon">
											<address>
												<br>
												<strong>3C Services</strong>
											</address>
										</div>
										<div class="pull-right">
											<h1 class="font-200">Relatório de movimentação de estoque</h1>
										</div>
										<div class="clearfix"></div>
										<br>
										<br>
										<div class="row">
											<div class="col-sm-12">
												<div>
													<div class="col-sm-8">
														<strong>Data inicial :</strong>
														<span><i class="fa fa-calendar"></i> <?php echo $dt_inicial;?> |</span>
														<strong>Data final :</strong>
														<span> <i class="fa fa-calendar"></i> <?php echo $dt_final;?> |</span>
														<strong>Armazém :</strong>
														<span>< <?php echo $ds_armazem;?> |</span>
														<strong>Produto :</strong>
														<span> <?php echo $cod_produto;?> </span>
													</div>
													<div class="col-sm-4 ">
													
														<span class="pull-right"><i class="fa fa-calendar"></i> <?php echo $dt_relatorio;?></span>
														<strong class="pull-right">Data do relatório :</strong>
													</div>
												</div>
												<br>
												<br>
											</div>
										</div>
										<table class="table table-hover">
											<thead>
												<tr>
													<th class="text-center">TIPO</th>
													<th>CÓDIGO</th>
													<th>DATA</th>
													<th>PRODUTO</th>
													<th>DESCRIÇÃO</th>
													<th>QTDE</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													while ($dados=mysqli_fetch_assoc($res_estoq)) {
												?>
												<tr>
													<td class="text-center"><?php
														if($dados['fl_tipo']=='R'){
															echo "Recebimento";
														}else{
															echo "Expedição";
														}
													 ;?>														 	
													</td>
													<td class="text-center"><?php
														if($dados['fl_tipo']=='R'){
															echo $dados['cod_recebimento'];
														}else{
															echo $dados['nr_pedido'];
														}
													 ;?>														 	
													</td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<?php } ?>
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
				</article>
			</div>
		</section>
	</div>