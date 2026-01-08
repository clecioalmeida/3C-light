<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$id_inv = $_POST['id_inv'];
$id_rua = $_POST['id_rua'];
$id_col = $_POST['id_col'];
$id_alt = $_POST['id_alt'];

$query="SET SQL_BIG_SELECTS=1";
$res_query=mysqli_query($link, $query);

$SQL = "select t1.*, t2.nome, t2.ds_apelido
from tb_inv_prog t1
left join tb_armazem t2 on t1.id_galpao = t2.id
where t1.id = '$id_inv'";
$res = mysqli_query($link,$SQL);
while ($dados=mysqli_fetch_assoc($res)) {
	$id 		= $dados['id'];
	$dt_inicio 	= $dados['dt_inicio'];
	$dt_fim 	= $dados['dt_fim'];
	$ds_galpao 	= $dados['nome'];
	$dt_create 	= $dados['data_create'];
	$ds_apelido = $dados['ds_apelido'];
}

$SQL_prod = "select t1.*, t2.nm_produto, t2.cod_prod_cliente
from tb_inv_tarefa t1
left join tb_produto t2 on t1.id_produto = t2.cod_prod_cliente
where t1.id_inv = '$id_inv' and t1.id_rua = '$id_rua' and t1.id_coluna = '$id_col' and t1.id_altura = '$id_alt' order by t1.id_rua, t1.id_coluna, t1.id_altura asc";
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
										<div class="btn-group">
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
										<h1 class="font-10">Listagem de tarefas inventário: <?php echo $id;?></h1>
										<strong>Criada em:</strong>
										<span> <i class="fa fa-calendar"></i> 
											<?php echo date('d/m/Y', strtotime($dt_create));?> 
										</span><br />
									</div>
									<div class="clearfix"></div>
									<br>
									<br>
									<div class="row">
										<div class="col-sm-12">
											<div>
												<div class="col-sm-8">
													<strong>Armazém :</strong>
													<span><i class="fa fa-calendar"></i> <?php echo $ds_galpao;?> |</span>
													<strong>Rua:</strong>
													<span> <i class="fa fa-calendar"></i> 
														<?php echo $id_rua;?> |
													</span>
													<strong>Período:</strong>
													<span> <i class="fa fa-calendar"></i> 
														<?php echo date('d/m/Y', strtotime($dt_inicio))." - ".date('d/m/Y', strtotime($dt_fim));?> 
													</span>
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
												<th>TAREFA</th>
												<th>COD ESTOQUE</th>
												<th>ETIQ</th>
												<th>COD SAP</th>
												<th>PRODUTO</th>
												<th style="text-align: center;">QTDE</th>
												<th style="text-align: center;">1 CONTAGEM</th>
												<th style="text-align: center;">2 CONTAGEM</th>
												<th style="text-align: center;">3 CONTAGEM</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											while ($dados=mysqli_fetch_assoc($res_prod)) {
												$local=$ds_apelido.$dados['id_rua'].$dados['id_coluna'].$dados['id_altura'];
												?>
												<tr>
													<td style="text-align: center;width: 100px">
														<svg id="barcode" 
														class="barcode"
														jsbarcode-format="auto"
														jsbarcode-height="20"
														jsbarcode-displayValue="true"
														jsbarcode-value="<?php echo $local;?>"
														jsbarcode-textmargin="0"
														jsbarcode-fontoptions="bold">
													</svg>
												</td>
												<td><?php echo $dados['id'];?></td>
												<td><?php echo $dados['id_estoque'];?></td>
												<td><?php echo $dados['id_etq'];?></td>
												<td><?php echo $dados['cod_prod_cliente'];?></td>
												<td><?php echo $dados['nm_produto'];?></td>
												<td style="text-align: center;"><?php echo $dados['nr_qtde'];?></td>
												<td style="text-align: center;"><input type="text" id="cont_1" name="" style="height: 50px"></td>
												<td style="text-align: center;"><input type="text" id="cont_2" name="" style="height: 50px"></td>
												<td style="text-align: center;"><input type="text" id="cont_3" name="" style="height: 50px"></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>

								<div style="page-break-after: always;"></div>
								<div class="invoice-footer">

									<div class="row">

										<div class="col-sm-4">
											<p>Primeiro conferente:</p><br /><br /><br />
											<p>Nome: ___________________________________________________</p><br />
											<p>Data da conferência: ______/______/________</p>
										</div>
										<div class="col-sm-4">
											<p>Segundo conferente:</p><br /><br /><br />
											<p>Nome: ___________________________________________________</p><br />
											<p>Data da conferência: ______/______/________</p>
										</div>
										<div class="col-sm-4">
											<p>Terceiro conferente:</p><br /><br /><br />
											<p>Nome: ___________________________________________________</p><br />
											<p>Data da conferência: ______/______/________</p></div>
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