<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Movimentação</li><li>Expedição</li>
		</ol>
	</div>
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa-fw fa fa-home"></i> 
					Movimentação 
					<span>|  
						Expedição
					</span>
				</h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
			</div>
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
												<h2>Expedição </h2>															
											</header>														
											<div>
												<div class="jarviswidget-editbox">
												</div>
												<div class="widget-body no-padding" id="dados">
													<div id="retorno"></div>
													<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<form method="POST" id="" action="">
															<fieldset>
																<div class="row"><br><br>
																	<div class="col-sm-8" style="text-align: right;width: 300px">
																		<div class="input-group">
																			<input type="btn" id="expede" class="form-control" aria-describedby="basic-addon2">
																			<span class="input-group-addon" id="btnFormExpede">Pesquisar</span>
																		</div>
																	</div>
																	<div class="col-sm-4" style="text-align: left;width: 150px">
																		<div class="form-group">
																			<input type="submit" class="btn-info form-control" id="btnGerarMinuta" value="Gerar minuta">
																		</div>
																	</div>
																	<div class="col-sm-4" style="text-align: left;width: 200px">
																		<div class="form-group">
																			<input type="submit" class="btn-success form-control" id="btnConsVeic" value="Veículos disponíveis">
																		</div>
																	</div>
																</div> 
															</fieldset>
														</form>
														<div id="info" class="row">
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
		<script type="text/javascript">
			
			function expedir(expedicao)
			{
				var page = "data/movimento/expede_list_sql.php";
				$.ajax
				({
					type: 'POST',
					dataType: 'html',
					url: page,
					beforeSend: function () {
						$("#info").html("Carregando...");
					},
					data: {expedicao: expedicao},
					success: function (msg)
					{
						$("#info").html(msg);
					}
				});
			}

			$('#btnFormExpede').click(function () {
				expedir($("#expede").val())
			});

		</script>