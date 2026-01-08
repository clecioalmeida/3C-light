<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Cadastros</li><li>Produtos</li>
		</ol>
	</div>
	<div id="content">
		<section id="widget-grid" class="">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div>
						<div class="jarviswidget-editbox">
							<input class="form-control" type="text">	
						</div>
						<div class="widget-body">
							<section id="widget-grid" class="">
								<div class="row">														
									<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
										<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
											<header>
												<span class="widget-icon"> <i class="fa fa-cog"></i> </span>
												<h2>Cadastro de Produtos </h2>				
												<button type="submit" id="btnNovoProduto" class="btn btn-default btn-xs" style="float:right; margin-top: 4px; margin-right: 12px">Novo</button>
											</header>
											<div>
												<div class="jarviswidget-editbox">
												</div>
												<div class="widget-body no-padding" id="dados">
													<div id="retorno"></div>
													<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<form method="POST" id="formPesquisaProduto" action=""><br><br>
															<fieldset>
																<div class="row">
																	<div class="col-sm-4" style="text-align: right;">
																		<div class="form-group">
																			<input type="btn" id="codigo" name="codigo" class="form-control" aria-describedby="basic-addon2" placeholder="Código SAP">
																			<input type="submit" class="form-control btn-info" id="btnPesquisaCodigo" value="Pesquisar">
																		</div>
																	</div>
																	<div class="col-sm-4" style="text-align: right;">
																		<div class="form-group">
																			<input type="btn" id="produtos" name="produtos" class="form-control" aria-describedby="basic-addon2" placeholder="Nome do produto">
																			<input type="submit" class="form-control btn-info" id="btnPesquisaNome" value="Pesquisar">
																		</div>
																	</div>
																</div> 
															</fieldset>
														</form>
														<div id="info_produtos" class="row"></div>
														<div id="retornoInsert" class="row"></div>
													</article>														
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
</div>