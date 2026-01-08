<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="consulta.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header>
						<h4>Consulta saldo por produto</h4>
						<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
					</header>
					<div role="content">
						<div class="widget-body">
							<fieldset>
								<div class="produto">
									<legend>Selecione o produto</legend>
									<div class="row" id="confProdPick">
										<form id="form_conf_prod" method="" action="">
											<div class="col-md-12">
												<div class="form-group">
													<input tabindex="1" type="text" id="barcodeConsLocPrd" name="barcodeConsLocPrd" class="form-control" required="true">
													<button class="btn btn-primary" type="button" id="btnConsPrd">CONSULTAR</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</fieldset>
							<fieldset>
								<div id="retConsPrd"></div>
							</fieldset>
						</div>
					</div>
				</div>
			</article>
		</div>
		<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
			<p>Growup Soluções para logística</p>
			<p>Copyright 2018 - Growup</p>
		</div>
	</div>
</div>