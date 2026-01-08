<?php
require_once('data/movimento/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_local = "select * from tb_armazem";
$res_local = mysqli_query($link, $sql_local);

?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Movimentação</li><li>Consulta histórico de produto</li>
		</ol>
	</div>
	<div id="content">
		<section id="widget-grid" class="">
			<div class="row">
				<div>
					<div class="jarviswidget-editbox">
						<input class="form-control" type="text">	
					</div>
					<div class="widget-body">
						<section id="widget-grid" class="">
							<div class="row">														
								<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
									</div>														
									<div>
										<div class="jarviswidget-editbox">
										</div>
										<div class="widget-body no-padding" id="dados">
											<div id="retorno"></div>
											<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<form method="POST" class="form-inline" id="formListHistProd" action=""><br><br>
													<fieldset>
														<div class="col-sm-8" style="text-align: left;">
															<div class="form-group">
																<!--input type="btn" class="form-control" aria-describedby="basic-addon2" name="histProd" id="histProdWms" placeholder="Digite o código WMS" style="text-align: right;"-->
																<input type="btn" class="form-control" aria-describedby="basic-addon2" name="histProd" id="histProd" placeholder="Digite o código SAP do produto" style="text-align: right;">
																<!--input type="date" class="form-control" aria-describedby="basic-addon2" name="listHistProd" id="dtInitHistProd" >
																<input type="date" class="form-control" aria-describedby="basic-addon2" name="listHistProd" id="dtFinHistProd"-->
																<input type="button" class="btn-info form-control" id="btnFormHistProduto" value="Pesquisar">
															</div>
														</div>
													</fieldset><br><br>
													<fieldset>														
														<div id="retornoHistorico"></div>
													</fieldset>
												</form>
											</article><br /><br />
										</div>
									</div>
								</div>														
							</article>	
						</div>		
					</section>
				</div>
			</div>
		</article>
	</div>
	<div class="row">
		<div class="col-sm-12">
		</div>							
	</div>
</section>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#btnFormHistProduto').on('click', function(){
			var histProdWms = $('#histProdWms').val();
			var histProd = $('#histProd').val();
			//var dtInitHistProd = $('#dtInitHistProd').val();
			//var dtFinHistProd = $('#dtFinHistProd').val();

			if(histProd != '' || histProdWms != ''){

				$.ajax
				({
					url:"data/movimento/list_hist_prod.php",
					method:"POST",
					data:{
						histProdWms:histProdWms,
						histProd:histProd
						//dtInitHistProd:dtInitHistProd,
						//dtFinHistProd:dtFinHistProd
					},
					beforeSend:function(e){
						$("#retornoHistorico").html("<img src='css/loading9.gif'>");
					},
					success:function(data)
					{
						$('#retornoHistorico').html(data);
					},
				});

			}else{

				alert("Por favor preencha todos os campos.");

			}
		});
		return false;
	});
</script>