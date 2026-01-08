<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Cadastro</li><li>Contratos</li>
		</ol>
	</div>
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa-fw fa fa-home"></i> 
						Cadastro 
					<span>|  
						Contratos
					</span>
				</h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8"></div>
		</div>
		<div class="row" style="margin-bottom: 10px">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8"></div>
		</div>
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
											</header>
											<div>
												<div class="jarviswidget-editbox"></div>
												<div class="widget-body no-padding" id="dados">
														<div id="retornoReg"></div>
														<div id="retornoNfRec"></div>
													<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<form method="POST" class="form-inline" id="formAlocCod" action=""><br><br>
												            <fieldset>
																<div class="col-sm-8" style="text-align: left;">
																	<div class="form-group">
																		<input type="text" id="cnpj" class="form-control" name="cnpj" aria-describedby="basic-addon2" placeholder="Digite o CNPJ do cliente">
																	</div>
																	<div class="form-group">
																		<input type="text" class="form-control" id="rSocial" name="rSocial" aria-describedby="basic-addon2" placeholder="Digite a razão social">
																		<input type="submit" class="btn-info form-control" id="btnPesqContrato" value="Pesquisar">
																	</div>
																</div>
																<div class="col-sm-4" style="text-align: right;">
																	<div class="form-group">
																		<input type="submit" class="btn-primary form-control" id="btnInsContrato" value="Novo" style="float: right;width: 200px">
																	</div>
																</div>
															</fieldset>
												        </form><br /><br />
														<div id="info_contrato" class="row"></div>
													</article>
														
													</div>
													<!-- end widget content -->
														
												</div>
												<!-- end widget div -->
														
												        <div id="retorno" class="row"></div>
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
<!--script type="text/javascript">
    $(document).ready(function(){
	    $(document).on('click', '#btnPesqPrt', function(){
	    	event.preventDefault();
	    	 $('#info_produtos').load('data/portaria/list_portaria.php'); 
		  	return false;
		 });		  
	});
</script-->