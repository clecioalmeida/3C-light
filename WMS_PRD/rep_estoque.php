<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Relatórios</li><li>Movimentação de estoque</li>
		</ol>
	</div>
	<!-- MAIN CONTENT -->
	<div id="content">

		<!-- row -->
		<div class="row">
					
			<!-- col -->
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
							
					<!-- PAGE HEADER -->
					<i class="fa-fw fa fa-home"></i> 
						Relatórios 
					<span>|  
						Estoque
					</span>
				</h1>
			</div>
			<!-- end col -->
					
			<!-- right side of the page with the sparkline graphs -->
			<!-- col -->
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
			</div>
			<!-- end col -->
					
		</div>
		<!-- end row -->
				
		<!--
			The ID "widget-grid" will start to initialize all widgets below 
			You do not need to use widgets if you dont want to. Simply remove 
			the <section></section> and you can use wells or panels instead 
			-->
				
		<!-- widget grid -->
		<section id="widget-grid" class="">
				
			<!-- row -->
			<div class="row">
						
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
						<!-- widget div-->
						<div>
									
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
								<input class="form-control" type="text">	
							</div>
							<!-- end widget edit box -->
									
							<!-- widget content -->
							<div class="widget-body">
								<section id="widget-grid" class="">
														
									<!-- row -->
									<div class="row">
														
										<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														
											<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
												<header>
													<h2>Relatório de movimentação de estoque </h2>		
												</header>
														
												<div>
														
													<!-- widget edit box -->
													<div class="jarviswidget-editbox">
														<!-- This area used as dropdown edit box -->
														
													</div>
													<!-- end widget edit box -->
														
													<!-- widget content -->
													<div class="widget-body no-padding" id="dados">

														<div id="retorno"></div>
													<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<form method="POST" class="form-inline" id="formRepEstoque" action=""><br><br>
												            <fieldset>
																<div class="col-sm-12" style="text-align: left;">
																	<div class="form-group">
																		<label>Data inicial</label>
																		<input type="date" id="dtIniMovEstoque" class="form-control" name="dt_inicial" aria-describedby="basic-addon2">
																	</div>
																	<div class="form-group">
																		<label>Data final</label>
																		<input type="date" id="dtFinMovEstoque" class="form-control" name="dt_final" aria-describedby="basic-addon2">
																		<label>Produto</label>
																		<input type="text" id="CodProduto" class="form-control" name="cod_produto" aria-describedby="basic-addon2" placeholder="Digite o código do produto">
																		<label>Armazém</label>
																		<select class="form-control" id="tipoMovimento" name="tipoMovimento">
																			<option value="1">Todos</option>
																		</select>
																		<label>Tipo</label>
																		<select class="form-control" id="tipoMovimento" name="ds_armazem">
																			<option value="1">Todos</option>
																			<option value="2">Recebimento</option>
																			<option value="3">Expedição</option>
																			<option value="4">Transferência</option>
																		</select>
																		<input type="submit" class="btn-info form-control" id="btnPesquisaData" value="Pesquisar">
																	</div>
																</div>
															</fieldset>
												        </form>
														<div id="relatorio" class="row"></div>
													</article>
														
													</div>
													<!-- end widget content -->
														
												</div>
												<!-- end widget div -->
														
											</div>
										<!-- end widget -->
														
									</article>
									<!-- WIDGET END -->
														
								</div>
														
								<!-- end row -->
														
								<!-- end row -->
														
								</section>
								<!-- end widget grid -->
								</div>
							<!-- end widget content -->
									
						</div>
						<!-- end widget div -->
				
				</article>
				<!-- WIDGET END -->
						
			</div>
				
			<!-- end row -->
				
			<!-- row -->
				
			<div class="row">
				
				<!-- a blank row to get started -->
				<div class="col-sm-12">
					<!-- your contents here -->
				</div>
							
			</div>
				
			<!-- end row -->
				
		</section>
		<!-- end widget grid -->

	</div>
	<!-- END MAIN CONTENT -->