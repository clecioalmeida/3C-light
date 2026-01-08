<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Portaria</li><li>Registros</li>
		</ol>
	</div>
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa-fw fa fa-home"></i> 
					Operacional 
					<span>|  
						Portaria | Registros
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
													<div id="retorno"></div>
													<div id="retornoReg"></div>
													<div id="retornoNfRec"></div>
													<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<form method="POST" class="form-inline" id="formAlocCod" action=""><br><br>
															<fieldset>
																<div class="col-sm-8" style="text-align: left;">
																	<div class="form-group">
																		<input type="text" id="codigo" class="form-control" name="codigo" aria-describedby="basic-addon2" placeholder="Digite o código SAP do produto">
																		<input type="submit" class="btn-info form-control" id="btnPesqPrt" value="Pesquisar">
																	</div>
																	<div class="form-group">
																		<input type="text" class="form-control" name="alocar" aria-describedby="basic-addon2" placeholder="Digite OR, nome ou parte do nome do produto">
																		<input type="submit" class="btn-info form-control" id="" value="Pesquisar">
																	</div>
																</div>
																<div class="col-sm-4" style="text-align: right;">
																	<div class="form-group">
																		<input type="submit" class="btn-primary form-control" id="insRegPtr" value="Novo" style="float: right;width: 200px">
																	</div>
																	<div class="form-group">
																		<input type="submit" class="btn-success form-control" id="consDoca" value="Docas" style="float: right;width: 200px">
																	</div>
																</div>
															</fieldset>
														</form><br /><br />
														<div id="info_produtos" class="row"></div>
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
	<!--script type="text/javascript">
		$(document).ready(function(){

			$(document).on('click', '#btnPesqPrt', function(){
				event.preventDefault();
				$('#info_produtos').load('data/portaria/list_portaria.php'); 
				var timer = setInterval(function(){
					$('#info_produtos').load('data/portaria/list_portaria.php'); 
				}, 10000);
				return false;
			});
		});
	</script-->