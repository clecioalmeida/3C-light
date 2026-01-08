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

$SQL = "select t1.produto, t2.cod_produto, t2.nm_produto, t3.nome, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura, t1.nr_qtde, t4.nr_qtde as reservado
from tb_posicao_pallet t1
inner join tb_produto t2 on t1.produto = t2.cod_produto
inner join tb_armazem t3 on t1.ds_galpao = t3.id
left join tb_pedido_coleta_produto t4 on t1.produto = t4.produto";
$res_saldo = mysqli_query($link,$SQL); 

$SQL_torre = "select * from tb_tipo_torre";
$res_torre = mysqli_query($link,$SQL_torre); 

$link->close();

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src="data/movimento/relatorio/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.2/jspdf.plugin.autotable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/jquery.canvasjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/jquery.canvasjs.min.js"></script>
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
													<button class="btn btn-sm btn-primary" id="btnSalEstPdf">PDF</button>
													<div id="retorno"></div>
												</div>
												<div class="btn-group">
													<a href="javascript:pdfToHTML()"  class="btn btn-sm btn-success" id=""> <i class="fa fa-plus"></i> Excel </a>
												</div>
											</div>
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
											<h1 class="font-200">Relatório de saldos de estoque</h1>
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
														<span> <?php echo $ds_armazem;?> |</span>
														<strong>Produto :</strong>
														<span> <?php echo $cod_produto;?> </span>
													</div>
													<div class="col-sm-4 ">
															
														<span class="pull-right"><i class="fa fa-calendar"></i> <?php echo $dt_relatorio;?></span>
														<strong class="pull-right">Data do relatório :</strong>
													</div>
												</div>
												<br><br>
											</div>
										</div>
										<table class="table table-hover">
											<thead>
												<tr>
													<th class="text-center">ID</th>
													<th>PRODUTO</th>
													<th>TIPO</th>
													<th>ARMAZÉM</th>
													<th>RUA</th>
													<th>COLUNA</th>
													<th>ALTURA</th>
													<th>RESERVADO</th>
													<th>SALDO</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													while ($dados=mysqli_fetch_assoc($res_saldo)) {
												?>
												<tr>
													<td class="text-center"><?php echo $dados['cod_produto'];?></td>
													<td><?php echo $dados['nm_produto'];?></td>
													<td></td>
													<td><?php echo $dados['nome'];?></td>
													<td><?php echo $dados['ds_prateleira'];?></td>
													<td><?php echo $dados['ds_coluna'];?></td>
													<td><?php echo $dados['ds_altura'];?></td>
													<td><?php echo $dados['reservado'];?></td>
													<td><?php echo $saldo = $dados['nr_qtde']-$dados['reservado'];?></td>
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
						</div>
					</article>

				</div>
			</section>
		</div>
<script type="text/javascript">
	function pdfToHTML(){
		html2canvas(document.getElementById("reportSalEstoque"),{
			onrendered: function(canvas){
				var pdf = canvas.toDataURL("img/jpeg, 1.0");
				var doc = new jsPDF("l", "mm", "a4");
				//var width = doc.internal.pageSize.width;
				//var height = doc.internal.pageSize.height;
				doc.addImage(pdf, 'JPEG',10,10,280,180);
				doc.save('Relatorio_estoque.pdf');
			}
		});
	}
</script>
<!--script type="text/javascript">

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