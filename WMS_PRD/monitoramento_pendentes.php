<?php include 'header.php'; ?>
	<body class="">
		<header id="header">
		</header>
			<aside id="left-panel">
				<?php include 'page_aside.php'; ?>
			</aside>
			<div>
				<form class="navbar-form navbar-left" role="search">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">
						Submit
					</button>
				</form>
			</div>
		
		<div id="main" role="main">
			<div id="ribbon">
				<span class="ribbon-button-alignment"> <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true"> <i class="fa fa-refresh"></i> </span> </span>
		</div>
			<div id="content">
				<section id="widget-grid" class="">
					<div class="row">
						<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
								<header>
									<span class="widget-icon"> <i class="fa fa-table"></i> </span>
									<h2>Monitoramento de entregas | Pendentes </h2>
								</header>
								<div>
									<div class="jarviswidget-editbox">
									</div>
									<div class="widget-body no-padding">
										<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%" style="font-size: x-small;">
											<thead>			                
												<tr>
													<th style="width: 70px"></th>
													<th data-hide="phone" style="width: 10px">Cte</th>
													<th data-class="expand"><i class="fa fa-fw fa-calendar text-muted hidden-md hidden-sm hidden-xs"></i> Data</th>
													<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Cliente</th>
													<th data-hide="phone"><i class="fa fa-fw fa-exclamation-circle text-muted hidden-md hidden-sm hidden-xs"></i>Cnpj</th>
													<th  data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i>Cidade</th>
													<th  data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i>UF</th>
													<th data-hide="phone,tablet"><i class="fa fa-fw fa-user txt-color-blue hidden-md hidden-sm hidden-xs"></i> Destino</th>
													<th  data-hide="phone,tablet"><i class="fa fa-fw fa-exclamation-circle txt-color-blue hidden-md hidden-sm hidden-xs"></i>Cnpj</th>
													<th  data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i>Cidade</th>
													<th  data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i>UF</th>
													<th data-hide="phone,tablet"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i> Previsto</th>
													<th data-hide="phone,tablet"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i> Saída</th>
													<th data-hide="phone,tablet"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i> Entregue</th>
												</tr>
											</thead>
											<tbody>
												<tr>
												<td>
													<ul class="demo-btns">
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comprovante de entrega" data-target="#comprovante" style="font-size: x-small;"><i class="fa fa-download"></i></a>
														</li>
													</ul>
												</td>
												<td>101</td>
												<td>10/01/2017</td>
												<td>Cliente 1</td>
												<td>00.000.000/0000-00</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>Destino 1</td>
												<td>11.111.111/1111-11</td>
												<td>Cajamar</td>
												<td>SP</td>
												<td>11/01/2017</td>
												<td>11/01/2017</td>
												<td></td>
											</tr>
											<tr>
												<td>
													<ul class="demo-btns">
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comprovante de entrega" data-target="#comprovante" style="font-size: x-small;"><i class="fa fa-download"></i></a>
														</li>
													</ul>
												</td>
												<td>102</td>
												<td>10/01/2017</td>
												<td>Cliente 2</td>
												<td>00.000.000/0000-00</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>Destino 2</td>
												<td>11.111.111/1111-11</td>
												<td>São Paulo</td>
												<td>SP</td>
												<td>11/01/2017</td>
												<td>11/01/2017</td>
												<td></td>
											</tr>
											<tr>
												<td>
													<ul class="demo-btns">
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comprovante de entrega" data-target="#comprovante" style="font-size: x-small;"><i class="fa fa-download"></i></a>
														</li>
													</ul>
												</td>
												<td>103</td>
												<td>10/01/2017</td>
												<td>Cliente 3</td>
												<td>00.000.000/0000-00</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>Destino 3</td>
												<td>11.111.111/1111-11</td>
												<td>Santos</td>
												<td>SP</td>
												<td>11/01/2017</td>
												<td>11/01/2017</td>
												<td></td>
											</tr>
											<tr>
												<td>
													<ul class="demo-btns">
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comprovante de entrega" data-target="#comprovante" style="font-size: x-small;"><i class="fa fa-download"></i></a>
														</li>
													</ul>
												</td>
												<td>104</td>
												<td>10/01/2017</td>
												<td>Cliente 4</td>
												<td>00.000.000/0000-00</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>Destino 4</td>
												<td>11.111.111/1111-11</td>
												<td>Curitiba</td>
												<td>PR</td>
												<td>11/01/2017</td>
												<td>11/01/2017</td>
												<td></td>
											</tr>
											<tr>
												<td>
													<ul class="demo-btns">
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comprovante de entrega" data-target="#comprovante" style="font-size: x-small;"><i class="fa fa-download"></i></a>
														</li>
													</ul>
												</td>
												<td>105</td>
												<td>10/01/2017</td>
												<td>Cliente 5</td>
												<td>00.000.000/0000-00</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>Destino 5</td>
												<td>11.111.111/1111-11</td>
												<td>São Paulo</td>
												<td>SP</td>
												<td>11/01/2017</td>
												<td>11/01/2017</td>
												<td></td>
											</tr>
											<tr>
												<td>
													<ul class="demo-btns">
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comprovante de entrega" data-target="#comprovante" style="font-size: x-small;"><i class="fa fa-download"></i></a>
														</li>
													</ul>
												</td>
												<td>106</td>
												<td>10/01/2017</td>
												<td>Cliente 6</td>
												<td>00.000.000/0000-00</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>Destino 6</td>
												<td>11.111.111/1111-11</td>
												<td>Cajamar</td>
												<td>SP</td>
												<td>11/01/2017</td>
												<td>11/01/2017</td>
												<td></td>
											</tr>
											<tr>
												<td>
													<ul class="demo-btns">
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comprovante de entrega" data-target="#comprovante" style="font-size: x-small;"><i class="fa fa-download"></i></a>
														</li>
													</ul>
												</td>
												<td>107</td>
												<td>10/01/2017</td>
												<td>Cliente 7</td>
												<td>00.000.000/0000-00</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>Destino 7</td>
												<td>11.111.111/1111-11</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>11/01/2017</td>
												<td>11/01/2017</td>
												<td></td>
											</tr>
											<tr>
												<td>
													<ul class="demo-btns">
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comprovante de entrega" data-target="#comprovante" style="font-size: x-small;"><i class="fa fa-download"></i></a>
														</li>
													</ul>
												</td>
												<td>108</td>
												<td>10/01/2017</td>
												<td>Cliente 8</td>
												<td>00.000.000/0000-00</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>Destino 8</td>
												<td>11.111.111/1111-11</td>
												<td>São Bernardo do Campo</td>
												<td>SP</td>
												<td>11/01/2017</td>
												<td>11/01/2017</td>
												<td></td>
											</tr>
											<tr>
												<td>
													<ul class="demo-btns">
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comprovante de entrega" data-target="#comprovante" style="font-size: x-small;"><i class="fa fa-download"></i></a>
														</li>
													</ul>
												</td>
												<td>109</td>
												<td>10/01/2017</td>
												<td>Cliente 9</td>
												<td>00.000.000/0000-00</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>Destino 9</td>
												<td>11.111.111/1111-11</td>
												<td>Itu</td>
												<td>SP</td>
												<td>11/01/2017</td>
												<td>11/01/2017</td>
												<td></td>
											</tr>
											<tr>
												<td>
													<ul class="demo-btns">
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comprovante de entrega" data-target="#comprovante" style="font-size: x-small;"><i class="fa fa-download"></i></a>
														</li>
													</ul>
												</td>
												<td>110</td>
												<td>10/01/2017</td>
												<td>Cliente 10</td>
												<td>00.000.000/0000-00</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>Destino 10</td>
												<td>11.111.111/1111-11</td>
												<td>São Paulo</td>
												<td>SP</td>
												<td>11/01/2017</td>
												<td>11/01/2017</td>
												<td></td>
											</tr>
											<tr>
												<td>
													<ul class="demo-btns">
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comprovante de entrega" data-target="#comprovante" style="font-size: x-small;"><i class="fa fa-download"></i></a>
														</li>
													</ul>
												</td>
												<td>111</td>
												<td>10/01/2017</td>
												<td>Cliente 11</td>
												<td>00.000.000/0000-00</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>Destino 11</td>
												<td>11.111.111/1111-11</td>
												<td>Lins</td>
												<td>SP</td>
												<td>11/01/2017</td>
												<td>11/01/2017</td>
												<td></td>
											</tr>
											<tr>
												<td>
													<ul class="demo-btns">
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal" title="Notas fiscais" data-target="#consulta_nf" style="font-size: x-small;""><i class="fa fa-barcode"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="modal tooltip" title="Ocorrências" data-target="#inativar_ocorrencia" style="font-size: x-small;"><i class="fa fa-exclamation-circle"></i></a>
														</li>
														<li>
															<a href="javascript:void(0);" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comprovante de entrega" data-target="#comprovante" style="font-size: x-small;"><i class="fa fa-download"></i></a>
														</li>
													</ul>
												</td>
												<td>112</td>
												<td>10/01/2017</td>
												<td>Cliente 12</td>
												<td>00.000.000/0000-00</td>
												<td>Barueri</td>
												<td>SP</td>
												<td>Destino 12</td>
												<td>11.111.111/1111-11</td>
												<td>São Paulo</td>
												<td>SP</td>
												<td>11/01/2017</td>
												<td>11/01/2017</td>
												<td></td>
											</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</article>
					</div>
					<div>
						<ul class="demo-btns">
							<li>
								<a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#inserir_ocorrencia"><i class="fa fa-plus"></i> Inserir </a>
							</li>
						</ul>
					</div>

				</div>
			</div>
<?php include 'includes/page_footer.php'; ?>
<?php include 'includes/monitoramento/notas_fiscais.php'; ?>

		
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="js/plugin/pace/pace.min.js"></script>

		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script>
			if (!window.jQuery) {
				document.write('<script src="js/libs/jquery-2.1.1.min.js"><\/script>');
			}
		</script>

		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script>
			if (!window.jQuery.ui) {
				document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');
			}
		</script>

		<!-- IMPORTANT: APP CONFIG -->
		<script src="js/app.config.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
		<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

		<!-- BOOTSTRAP JS -->
		<script src="js/bootstrap/bootstrap.min.js"></script>

		<!-- CUSTOM NOTIFICATION -->
		<script src="js/notification/SmartNotification.min.js"></script>

		<!-- JARVIS WIDGETS -->
		<script src="js/smartwidgets/jarvis.widget.min.js"></script>

		<!-- EASY PIE CHARTS -->
		<script src="js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

		<!-- SPARKLINES -->
		<script src="js/plugin/sparkline/jquery.sparkline.min.js"></script>

		<!-- JQUERY VALIDATE -->
		<script src="js/plugin/jquery-validate/jquery.validate.min.js"></script>

		<!-- JQUERY MASKED INPUT -->
		<script src="js/plugin/masked-input/jquery.maskedinput.min.js"></script>

		<!-- JQUERY SELECT2 INPUT -->
		<script src="js/plugin/select2/select2.min.js"></script>

		<!-- JQUERY UI + Bootstrap Slider -->
		<script src="js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

		<!-- browser msie issue fix -->
		<script src="js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

		<!-- FastClick: For mobile devices -->
		<script src="js/plugin/fastclick/fastclick.min.js"></script>

		<!--[if IE 8]>

		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->

		<!-- Demo purpose only -->
		<script src="js/demo.min.js"></script>

		<!-- MAIN APP JS FILE -->
		<script src="js/app.min.js"></script>

		<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
		<!-- Voice command : plugin -->
		<script src="js/speech/voicecommand.min.js"></script>

		<!-- SmartChat UI : plugin -->
		<script src="js/smart-chat-ui/smart.chat.ui.min.js"></script>
		<script src="js/smart-chat-ui/smart.chat.manager.min.js"></script>

		<!-- PAGE RELATED PLUGIN(S) -->
		<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

		<script type="text/javascript">
		
		// DO NOT REMOVE : GLOBAL FUNCTIONS!
		
		$(document).ready(function() {
			
			pageSetUp();
			
			/* // DOM Position key index //
		
			l - Length changing (dropdown)
			f - Filtering input (search)
			t - The Table! (datatable)
			i - Information (records)
			p - Pagination (paging)
			r - pRocessing 
			< and > - div elements
			<"#id" and > - div with an id
			<"class" and > - div with a class
			<"#id.class" and > - div with an id and class
			
			Also see: http://legacy.datatables.net/usage/features
			*/	
	
			/* BASIC ;*/
				var responsiveHelper_dt_basic = undefined;
				var responsiveHelper_datatable_fixed_column = undefined;
				var responsiveHelper_datatable_col_reorder = undefined;
				var responsiveHelper_datatable_tabletools = undefined;
				
				var breakpointDefinition = {
					tablet : 1024,
					phone : 480
				};
	
				$('#dt_basic').dataTable({
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth" : true,
			        "oLanguage": {
					    "sSearch": '<h5>Pesquisar nota fiscal</h5><span class="input-group-addon"><i class="fa fa-search"></i></span>'
					},
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});
	
			/* END BASIC */
			
			/* COLUMN FILTER  */
		    var otable = $('#datatable_fixed_column').DataTable({
		    	//"bFilter": false,
		    	//"bInfo": false,
		    	//"bLengthChange": false
		    	//"bAutoWidth": false,
		    	//"bPaginate": false,
		    	//"bStateSave": true // saves sort state using localStorage
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"oLanguage": {
					"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
				},
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_fixed_column) {
						responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_fixed_column.respond();
				}		
			
		    });
		    
		    // custom toolbar
		    $("div.toolbar").html('<div class="text-right"><img src="img/logo.png" alt="SmartAdmin" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');
		    	   
		    // Apply the filter
		    $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {
		    	
		        otable
		            .column( $(this).parent().index()+':visible' )
		            .search( this.value )
		            .draw();
		            
		    } );
		    /* END COLUMN FILTER */   
	    
			/* COLUMN SHOW - HIDE */
			$('#datatable_col_reorder').dataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
				"autoWidth" : true,
				"oLanguage": {
					"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
				},
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_col_reorder) {
						responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_col_reorder.respond();
				}			
			});
			
			/* END COLUMN SHOW - HIDE */
	
			/* TABLETOOLS */
			$('#datatable_tabletools').dataTable({
				
				// Tabletools options: 
				//   https://datatables.net/extensions/tabletools/button_options
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
				"oLanguage": {
					"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
				},		
		        "oTableTools": {
		        	 "aButtons": [
		             "copy",
		             "csv",
		             "xls",
		                {
		                    "sExtends": "pdf",
		                    "sTitle": "SmartAdmin_PDF",
		                    "sPdfMessage": "SmartAdmin PDF Export",
		                    "sPdfSize": "letter"
		                },
		             	{
	                    	"sExtends": "print",
	                    	"sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
	                	}
		             ],
		            "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
		        },
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_tabletools) {
						responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_tabletools.respond();
				}
			});
			
			/* END TABLETOOLS */
		
		})

		</script>

		<!-- Your GOOGLE ANALYTICS CODE Below -->
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
			_gaq.push(['_trackPageview']);
			
			(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
			})();
		</script>

	</body>

</html>