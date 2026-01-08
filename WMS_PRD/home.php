<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"])) {

	header("Location:../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php
$width = 120;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title> WMS ARGUS </title>
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production-plugins.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-skins.min.css">

	<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="css/demo.min.css"> 
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">


	<link rel="shortcut icon" href="img/logo8.png" type="image/x-icon">
	<link rel="icon" href="img/logo8.png" type="image/x-icon">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
	<link rel="stylesheet" type="text/css" media="screen" href="css/autocomplete.css">
</head>
<body class="desktop-detected pace-done mobile-view-activated smart-style-1 fixed-header fixed-navigation minified">
	<header id="header">
		<?php include "header.php";?>
	</header>
	<aside id="left-panel">
		<?php include "menu.php";?>
	</aside>
	<div id="conteudo">
		<div id="main" role="main">
			<div id="content">
				<div class="row">
					<article class="col-sm-12">
						<div class="no-padding">
							<div class="jarviswidget-editbox">
							</div>
							<div class="widget-body">
								<div class="row no-space">
									<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
										<div id="updating-chart" class="chart-large txt-color-blue">
											<ul class="demo-btns">
												<h6 class="SmartAdmin heading" style="color:black">Operação</h6>
												<li>
													<a href="javascript:void(0);" class="btn bg-color-greenDark txt-color-white" id="linkPed" style="width: <?php echo $width; ?>px">Pedidos</a>
												</li>
												<li>
													<a href="javascript:void(0);" class="btn bg-color-greenDark txt-color-white" id="linkRec" style="width: <?php echo $width; ?>px">Recebimento</a>
												</li>
												<li>
													<a href="javascript:void(0);" class="btn bg-color-teal txt-color-white" id="linkTransf" style="width: <?php echo $width; ?>px">Transferência</a>
												</li>
												<li>
													<a href="javascript:void(0);" class="btn bg-color-teal txt-color-white" id="linkAloca" style="width: <?php echo $width; ?>px">Alocação</a>
												</li>
												<li>
													<a href="javascript:void(0);" class="btn bg-color-greenDark txt-color-white" id="linkAlca" style="width: <?php echo $width; ?>px">Laudos e CA</a>
												</li>
												<h6 class="SmartAdmin heading" style="color:black">Consulta</h6>
												<li>
													<a href="javascript:void(0);" class="btn bg-color-magenta txt-color-white" id="linkConsEstoq" style="width: <?php echo $width; ?>px">Estoque</a>
												</li>
												<li>
													<a href="javascript:void(0);" class="btn bg-color-blueLight txt-color-white" id="linkHistProd" style="width: <?php echo $width; ?>px">Histórico</a>
												</li>
												<li>
													<a href="javascript:void(0);" class="btn bg-color-redLight txt-color-white" id="linkHistInv" style="width: <?php echo $width; ?>px">Inventário</a>
												</li>
												<li>
													<a href="javascript:void(0);" class="btn bg-color-blueDark txt-color-white" id="linkConsSaldo" style="width: <?php echo $width; ?>px">Saldos</a>
												</li>
												<li>
													<a href="javascript:void(0);" class="btn bg-color-blueLight txt-color-white" id="linkConsInd" style="width: <?php echo $width; ?>px">Indicadores</a>
												</li>
												<li>
													<a href="javascript:void(0);" class="btn bg-color-redLight txt-color-white" id="linkPrd" style="width: <?php echo $width; ?>px">Produtos</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 show-stats">


									</div>
								</article>
							</div>
							<div class="row">
								<article class="col-sm-8 col-md-8 col-lg-4">
									<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
										<header role="heading" style=";background-color: #2F4F4F">
											<span class="" style="margin-left: 5px;color: white;padding: center">Total de recebimentos emitidos por mês</span>
										</header>
										<div class="row">
											<fieldset>
												<div class="row">
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<fieldset>
														<div class="widget-body no-padding">
															<div id="recebimentoMes" class="chart no-padding"></div>
														</div>
													</fieldset>
												</div>
											</fieldset>
										</div>
									</div>
								</article>
								<article class="col-sm-8 col-md-8 col-lg-4">
									<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
										<header role="heading" style="background-color: #2F4F4F">
											<span class="" style="margin-left: 5px;color: white">Total de pedidos emitidos por mês</span>
										</header>
										<div class="row">
											<fieldset>
												<div class="widget-body no-padding">
													<div id="pedidoMes" class="chart no-padding"></div>
												</div>
											</fieldset>
										</div>
									</div>
								</article>
								<article class="col-sm-8 col-md-8 col-lg-4">
									<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
										<header role="heading" style=";background-color: #2F4F4F">
											<span class="" style="margin-left: 5px;color: white;padding: center">Pedidos não finalizados por dia</span>
										</header>
										<div class="row">
											<fieldset>
												<div class="row">
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<fieldset>
														<div class="widget-body no-padding">
															<div id="pedidoOpen" class="chart no-padding"></div>
														</div>
													</fieldset>
												</div>
											</fieldset>
										</div>
									</div>
									<div id="retornoPedOpen"></div>
								</article>
								<!--article class="col-sm-8 col-md-8 col-lg-4">
									<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
										<header role="heading" style=";background-color: #2F4F4F">
											<span class="" style="margin-left: 5px;color: white;padding: center">Nível de estoque - Produtos por curva: 90 dias</span>
										</header>
										<div class="row">
											<fieldset>
												<div class="row">
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<fieldset>
														<div class="widget-body no-padding">
															<div id="pedidosStatus" class="chart no-padding"></div>
														</div>
													</fieldset>
												</div>
											</fieldset>
										</div>
									</div>
								</article-->
							</div>
							<!--div class="row">
								<article class="col-sm-8 col-md-8 col-lg-4">
									<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
										<header role="heading" style=";background-color: #2F4F4F">
											<span class="" style="margin-left: 5px;color: white;padding: center">Pedidos por tempo de expedição (dias)</span>
										</header>
										<div class="row">
											<fieldset>
												<div class="row">
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<fieldset>
														<div class="widget-body no-padding">
															<div id="pedidosExpede" class="chart no-padding"></div>
														</div>
													</fieldset>
												</div>
											</fieldset>
										</div>
									</div>
								</article>
								<article class="col-sm-8 col-md-8 col-lg-4">
									<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
										<header role="heading" style=";background-color: #2F4F4F">
											<span class="" style="margin-left: 5px;color: white;padding: center">Pedidos por tempo de entrega (dias)</span>
										</header>
										<div class="row">
											<fieldset>
												<div class="row">
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<fieldset>
														<div class="widget-body no-padding">
															<div id="pedidosEntrega" class="chart no-padding"></div>
														</div>
													</fieldset>
												</div>
											</fieldset>
										</div>
									</div>
								</article>
								<article class="col-sm-8 col-md-8 col-lg-4">
									<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
										<header role="heading" style=";background-color: #2F4F4F">
											<span class="" style="margin-left: 5px;color: white;padding: center">OTIF - Pedidos entregues com divergência</span>
										</header>
										<div class="row">
											<fieldset>
												<div class="row">
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<fieldset>
														<div class="widget-body no-padding">
															<div id="pedidosOcorrencia" class="chart no-padding"></div>
														</div>
													</fieldset>
												</div>
											</fieldset>
										</div>
									</div>
								</article>
								<article class="col-sm-8 col-md-8 col-lg-4">
									<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
										<header role="heading" style=";background-color: #2F4F4F">
											<span class="" style="margin-left: 5px;color: white;padding: center">Acuracidade de inventário</span>
										</header>
										<div class="row">
											<fieldset>
												<div class="row">
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<fieldset>
														<div class="widget-body no-padding">
															<div id="AcInventario" class="chart no-padding"></div>
														</div>
													</fieldset>
												</div>
											</fieldset>
										</div>
									</div>
								</article>
								<article class="col-sm-8 col-md-8 col-lg-4">
									<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
										<header role="heading" style=";background-color: #2F4F4F">
											<span class="" style="margin-left: 5px;color: white;padding: center">Giro de estoque</span>
										</header>
										<div class="row">
											<fieldset>
												<div class="row">
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<fieldset>
														<div class="widget-body no-padding">
															<div id="giroEstoque" class="chart no-padding"></div>
														</div>
													</fieldset>
												</div>
											</fieldset>
										</div>
									</div>
								</article>
								<article class="col-sm-8 col-md-8 col-lg-4">
									<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
										<header role="heading" style=";background-color: #2F4F4F">
											<span class="" style="margin-left: 5px;color: white;padding: center">Tempo médio de giro de estoque</span>
										</header>
										<div class="row">
											<fieldset>
												<div class="row">
												</div>
											</fieldset>
											<fieldset>
												<div class="row">
													<fieldset>
														<div class="widget-body no-padding">
															<div id="tempoEstoque" class="chart no-padding"></div>
														</div>
													</fieldset>
												</div>
											</fieldset>
										</div>
									</div>
								</article>
							</div-->
						</div>
					</div>
				</div>
				<div id="consulta"></div>
				<div id="consultaRetorno"></div>
				<!-- END MAIN PANEL -->

				<!-- PAGE FOOTER -->
				<div class="page-footer">
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<span class="txt-color-white">GrowUp <span class="hidden-xs"> - Web Application </span> © 2014-2017</span>
						</div>
						<!--================================================== -->
						<?php include "script_global.php";?>
						<!-- SmartChat UI : plugin -->
						<script src="js/smart-chat-ui/smart.chat.ui.min.js"></script>
						<script src="js/smart-chat-ui/smart.chat.manager.min.js"></script>

						<!--script type="text/javascript" src="script.js"></script-->
						<script type="text/javascript" src="script_report.js"></script>
						<script type="text/javascript" src="script_qualidade.js"></script>
						<!--script type="text/javascript" src="script_acessos.js"></script-->
						<script type="text/javascript" src="jquery.table2excel.min.js"></script>
						<!-- ChartJs Dependencies -->
						<!-- Morris Chart Dependencies -->
						<script src="js/plugin/morris/raphael.min.js"></script>
						<script src="js/plugin/morris/morris.min.js"></script>
						<!--script src="js/plugin/chartjs/chart.min.js"></script-->
						<!--script src="chart.js"></script-->

						<script src="js/plugin/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
						<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
						<script src="script.js"></script>
						<script src="js/ca.js"></script>
						<script src="js/consulta_estoque.js"></script>
						<?php include "script.php";?>
						<script type="text/javascript">
							$(document).ready(function(){

								var timer = setInterval(function(){
									$('#conteudo').load('logout.php');
								}, 7200000);
								return false;
							});
						</script>
					</body>
					</html>