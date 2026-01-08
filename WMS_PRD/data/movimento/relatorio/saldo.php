<?php 
require_once('bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

 $dt_inicial = "";
 $dt_final = "";
 $cod_produto = $_POST['cod_produto'];
 $tipoMovimento = $_POST['tipoMovimento'];
 $ds_armazem = $_POST['ds_armazem'];
 $dt_relatorio = date('d/m/Y');

 $query="SET SQL_BIG_SELECTS=1";
 $res_query=mysqli_query($link, $query);

 $query_galpao="select ds_apelido, nome from tb_armazem where id = '$ds_armazem'";
 $res_galpao=mysqli_query($link, $query_galpao);
 while ($galpao=mysqli_fetch_assoc($res_galpao)) {
 	$ds_apelido = $galpao['ds_apelido'];
 	$nome = $galpao['nome'];
 }


  if($tipoMovimento == '1'){

 	if($cod_produto != ''){

 		 $sql_prd="select cod_produto from tb_produto where cod_prod_cliente = '$cod_produto' and fl_status <> 'E'";
		 $res_prd = mysqli_query($link,$sql_prd); 
		 while ($prd=mysqli_fetch_assoc($res_prd)) {
			 $produto = $prd['cod_produto'];
		 }

		 echo $produto;

		 $SQL = "select t1.cod_estoque as codigo, t4.cod_prod_cliente, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura,
		 t1.nr_qtde, t2.nr_qtde_col as reservado, t4.nm_produto, t5.ds_apelido
		 from tb_posicao_pallet t1
		 left join vw_pedido_teste t2 on t1.cod_estoque = t2.cod_estoque
		 left join tb_produto t4 on t1.produto = t4.cod_produto
		 left join tb_armazem t5 on t1.ds_galpao = t5.id
		 where t1.produto = '$produto' and t1.ds_galpao > 1 and t1.ds_galpao = '$ds_armazem' and t1.nr_qtde > 0
		 group by t1.produto,t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura";
		 $res_saldo = mysqli_query($link,$SQL);

 	}else{

 		 $SQL = "select t1.cod_estoque as codigo, t4.cod_prod_cliente, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura,
		 t1.nr_qtde, t2.nr_qtde_col as reservado, t4.nm_produto, t5.ds_apelido
		 from tb_posicao_pallet t1
		 left join vw_pedido_teste t2 on t1.cod_estoque = t2.cod_estoque
		 left join tb_produto t4 on t1.produto = t4.cod_produto
		 left join tb_armazem t5 on t1.ds_galpao = t5.id
		 where t1.ds_galpao > 1 and t1.nr_qtde > 0 and t1.ds_galpao = '$ds_armazem'
		 group by t1.produto,t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura";
		 $res_saldo = mysqli_query($link,$SQL); 

 	} 	


 }else{

 	$SQL = "select t1.cod_estoque as codigo, t1.produto, t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura,
	t1.nr_qtde, t2.nr_qtde_col as reservado, t4.nm_produto, t5.ds_apelido
	from tb_posicao_pallet t1
	left join vw_pedido_teste t2 on t1.cod_estoque = t2.cod_estoque
	left join tb_produto t4 on t1.produto = t4.cod_produto
	left join tb_armazem t5 on t1.ds_galpao = t5.id
	where t1.ds_galpao > 1 and t1.nr_qtde = 0 and t1.ds_galpao = '$ds_armazem'
	group by t1.produto,t1.ds_galpao, t1.ds_prateleira, t1.ds_coluna, t1.ds_altura";
	$res_saldo = mysqli_query($link,$SQL); 

 }

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
														<span> <?php echo $nome." - ".$ds_apelido;?> |</span>
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
													<th>QTDE</th>
													<th>RESERVADO</th>
													<th>SALDO</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													while ($dados=mysqli_fetch_assoc($res_saldo)) {
												?>
												<tr>
													<td class="text-center"><?php echo $dados['cod_prod_cliente'];?></td>
													<td><?php echo $dados['nm_produto'];?></td>
													<td></td>
													<td><?php echo $dados['ds_apelido'];?></td>
													<td><?php echo $dados['ds_prateleira'];?></td>
													<td><?php echo $dados['ds_coluna'];?></td>
													<td><?php echo $dados['ds_altura'];?></td>
													<td style="text-align: right;"><?php echo number_format($dados['nr_qtde'], 0, ',', ' ');?></td>
													<td style="text-align: right;"><?php echo $dados['reservado'];?></td>
													<td style="text-align: right;"><?php echo $saldo = $dados['nr_qtde']-$dados['reservado'];?></td>
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