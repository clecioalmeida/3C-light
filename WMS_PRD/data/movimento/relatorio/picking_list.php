<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_pedido = $_GET['cod_ped'];

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$SQL = "select t1.dt_pedido, t1.ds_destino as ds_almox, t1.doc_material, case coalesce(t1.ds_tipo,0) WHEN '0' THEN 'NORMAL' else t1.ds_tipo END as fl_tipo, case coalesce(t1.ds_frete,0) WHEN '0' THEN 'ENTREGA' else t1.ds_frete END as ds_frete, t1.ds_obs_sac as ds_obs, date_format(t1.dt_limite, '%d/%m/%Y') as dt_limite
from tb_pedido_coleta t1
where t1.nr_pedido = '$cod_pedido'";
$res = mysqli_query($link, $SQL);
while ($dados = mysqli_fetch_assoc($res)) {
	$dt_limite 		= $dados['dt_limite'];
	$ds_almox 		= $dados['ds_almox'];
	$doc_material 	= $dados['doc_material'];
	$fl_tipo 		= $dados['fl_tipo'];
	$ds_frete 		= $dados['ds_frete'];
	$ds_obs 		= $dados['ds_obs'];
}
$select_produto = "select t1.produto, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, sum(t1.nr_qtde_col) as nr_qtde_col, sum(coalesce(t1.nr_qtde_conf,0)) as nr_qtde_conf, t2.nm_produto, t2.unid
from tb_coleta_pedido t1 
left join tb_produto t2 on t1.produto = t2.cod_prod_cliente
where t1.nr_pedido = '$cod_pedido' and t1.fl_status <> 'E' and t2.fl_status <> 'E'
group by t1.produto
order by t1.ds_prateleira, t1.ds_coluna, t1.ds_altura";
$res_produto = mysqli_query($link,$select_produto);

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
										<div class="btn-group">
											<button onclick="printContent('reportSalEstoque')" type="submit" class="btn btn-primary" id="RepEstoqGenPdf" style="float:right;width: 100px">IMPRIMIR</button>
											<button type="button" class="btn btn-success" id="btnRetPed" style="float:right;width: 100px">VOLTAR</button>
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
										<h1 class="font-8">Picking list: <?php echo $cod_pedido; ?></h1>
									</div>
									<div class="row">
										<div>
											<div class="col-sm-12">
												<strong>Destino :</strong>
												<span><i class=""></i> <h3><?php echo $ds_almox." - ".$doc_material." | TIPO DE ENTREGA: ".$fl_tipo." | MODAL: ".$ds_frete; ?></h3></span>
												<strong>Data limite para entrega:</strong>
												<!--span style="background-color: #FF7F50"> <i class=""></i><strong>
													<?php echo $dt_limite;?></strong>
												</span-->
											</div>
										</div>
									</div>
									<hr>
									<table class="table" id="sample_1">
										<thead>
											<tr>
												<th> Código SAP</th>
												<th> Descrição </th>
												<th> Qtde Pedida </th>
												<th> Qtde encontrada </th>
												<th> UMB </th>
												<th> Local </th>
											</tr>
										</thead>
										<tbody id="retPrdPedido">
											<?php 
											while($dados_produto=mysqli_fetch_assoc($res_produto)){
												$produto = $dados_produto['nm_produto'];

												$sql_saldo = "select nr_qtde from tb_pedido_coleta_produto where nr_pedido = '".$cod_pedido."' and produto = '".$dados_produto['produto']."'";
												$res_saldo = mysqli_query($link,$sql_saldo);
												while ($dados_saldo=mysqli_fetch_assoc($res_saldo)) {
													$nr_qtde=$dados_saldo['nr_qtde'];
												}

												?>
												<tr class="odd gradeX">
													<td class=""> <?php echo $dados_produto['produto']; ?> </td>
													<td class=""> <?php echo $dados_produto['nm_produto']; ?> </td>
													<td class="" style="text-align: center;"> <?php echo $nr_qtde; ?> </td>
													<td class="" style="text-align: center;"> <?php echo $dados_produto['nr_qtde_col']; ?> </td>
													<td class=""> <?php echo $dados_produto['unid']; ?> </td>
													<td class="" style="text-align: left;"> <?php echo $dados_produto['ds_prateleira'].$dados_produto['ds_coluna'].$dados_produto['ds_altura']; ?> </td>
													<!--td class="" style="text-align: center;"> <?php echo $dados_produto['nr_qtde_conf']; ?> </td-->
												</tr>
											<?php } 
											$link->close();?> 
										</tbody>
									</table>
									<div class="row">
										<div>
											<div class="col-sm-12">
												<strong>Observações :</strong>
												<span><i class=""></i> <h3><?php echo $ds_obs; ?></h3></span>
											</div>
										</div>
									</div>
									<hr>
									<div class="invoice-footer">

										<div class="row">

											<div class="col-sm-12">
												<p>Separador:</p><br /><br /><br />
												<p>Nome: ___________________________________________________</p><br />
												<p>Data da conferência: ______/______/________</p>
											</div>

										</div>

										<div class="row">

											<div class="col-sm-12">
												<p>Conferente:</p><br /><br /><br />
												<p>Nome: ___________________________________________________</p><br />
												<p>Data da conferência: ______/______/________</p>
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