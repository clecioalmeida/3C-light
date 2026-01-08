<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php include 'data/movimento/chart.php';?>
<?php
$width = 120;
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title> GrowUp </title>
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- #CSS Links -->
		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.min.css">

		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/demo.min.css">

		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="img/logo8_1.png" type="image/x-icon">
		<link rel="icon" href="img/logo8_1.png" type="image/x-icon">

		<!-- #GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<!-- #APP SCREEN / ICONS -->
		<!-- Specifying a Webpage Icon for Web Clip
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="img/splash/touch-icon-ipad-retina.png">

		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="img/splash/iphone.png" media="screen and (max-device-width: 320px)">

	</head>
	<body class="desktop-detected pace-done mobile-view-activated smart-style-1 fixed-header fixed-navigation">

		<!-- #HEADER -->
		<header id="header">
			<?php include "header.php";?>

		</header>
		<!-- END HEADER -->

		<!-- #NAVIGATION -->
		<!-- Left panel : Navigation area -->
		<!-- Note: This width of the aside area can be adjusted through LESS variables -->
		<aside id="left-panel" style="width: 230px">

			<?php include "menu.php";?>

		</aside>
		<div id="conteudo">
			<div id="main" role="main">
		    	<div id="content">
		    		<section id="widget-grid" class="">
						<div class="row">
							<article class="col-sm-12">
								<div class="jarviswidget" id="wid-id-0" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
								<header>
									<span class="widget-icon"> <i class="glyphicon glyphicon-stats txt-color-darken"></i> </span>
									<h2>Indicadores | Atalhos</h2>

									<ul class="nav nav-tabs pull-right in" id="myTab">
										<li class="active">
											<a data-toggle="tab" href="#s1"><i class="fa fa-clock-o"></i> <span class="hidden-mobile hidden-tablet">Pedidos-tempo médio por operação</span></a>
										</li>

										<li>
											<a data-toggle="tab" href="#s2"><i class="fa fa-clock-o"></i> <span class="hidden-mobile hidden-tablet">Recebimento-tempo médio por operação</span></a>
										</li>

										<li>
											<a data-toggle="tab" href="#s3"><i class="fa fa-gear"></i> <span class="hidden-mobile hidden-tablet">Entregas</span></a>
										</li>
									</ul>

								</header>

								<!-- widget div-->
								<div class="no-padding">
									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
									</div>
									<!-- end widget edit box -->

									<div class="widget-body">
										<!-- content -->
										<div id="myTabContent" class="tab-content">
											<div class="tab-pane fade active in padding-10 no-padding-bottom" id="s1">
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
																	<a href="javascript:void(0);" class="btn bg-color-blueDark txt-color-white" id="linkCol" style="width: <?php echo $width; ?>px">Coletas</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-orange txt-color-white" id="linkExp" style="width: <?php echo $width; ?>px">Expedição</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-blueDark txt-color-white" id="linkConf" style="width: <?php echo $width; ?>px">Conferência</a>
																</li>
														<h6 class="SmartAdmin heading" style="color:black">Torres</h6>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-teal txt-color-white" id="linkCadTor" style="width: <?php echo $width; ?>px">Torres</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-teal txt-color-white" id="linkCadPart" style="width: <?php echo $width; ?>px">Partes</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-teal txt-color-white" id="linkCadPeca" style="width: <?php echo $width; ?>px">Peças</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-redLight txt-color-white" id="linkConsAnalit" style="width: <?php echo $width; ?>px">Consulta</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-blueDark txt-color-white" id="linkTorPed" style="width: <?php echo $width; ?>px">Pedidos</a>
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
															</ul>
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 show-stats">
														<div class="row">
															<?php while ($dados_b = mysqli_fetch_assoc($tempo_b)) {?>
															<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Tempo médio até o início da coleta: <span class="pull-right"><?php echo number_format($dados_b['inicio_coleta'], 2, ',', ' '); ?> Dias</span> </span>
																<div class="progress">
																	<div class="progress-bar bg-color-blueDark" style="width: <?php echo number_format($dados_b['inicio_coleta'], 2, ',', ' '); ?>"></div>
																</div> </div>
															<?php }?>
															<?php while ($dados_c = mysqli_fetch_assoc($tempo_c)) {?>
															<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Tempo médio de coleta: <span class="pull-right"><?php echo number_format($dados_c['tempo_coleta'], 2, ',', ' '); ?> Dias</span> </span>
																<div class="progress">
																	<div class="progress-bar bg-color-blueDark" style="width: <?php echo number_format($dados_c['tempo_coleta'], 2, ',', ' '); ?>"></div>
																</div> </div>
															<?php }?>
															<?php while ($dados_a = mysqli_fetch_assoc($tempo_a)) {?>
															<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Tempo médio até a expedição: <span class="pull-right"><?php echo number_format($dados_a['tempo_total'], 2, ',', ' '); ?> Dias</span> </span>
																<div class="progress">
																	<div class="progress-bar bg-color-blueDark" style="width: <?php echo number_format($dados_a['tempo_total'], 2, ',', ' '); ?>"></div>
																</div> </div>
															<?php }?>
														</div>

													</div>
												</div>

												<div class="show-stat-microcharts">
												<?php while ($status = mysqli_fetch_assoc($res_status)) {?>

													<div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
														<input type="hidden" name="tr_status" id="tr_status" value="<?php echo $status['tr_status']; ?>">
														<div class="easy-pie-chart txt-color-orangeDark" data-percent="<?php echo ($status['total_status'] / $status['total']) * 100; ?>" data-pie-size="50">
															<span class="percent percent-sign"><?php echo ($status['total'] / $status['total_status']) * 100; ?></span>
														</div>
														<span class="easy-pie-title"> <?php echo $status['tr_status']; ?> <i class="fa fa-caret-up icon-color-bad"></i> </span>
													</div>
												<?php }?>
												</div>

											</div>
											<!-- end s1 tab pane -->

											<div class="tab-pane in padding-10 no-padding-bottom fade" id="s2">
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
																	<a href="javascript:void(0);" class="btn bg-color-blueDark txt-color-white" id="linkCol" style="width: <?php echo $width; ?>px">Coletas</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-orange txt-color-white" id="linkExp" style="width: <?php echo $width; ?>px">Expedição</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-blueDark txt-color-white" id="linkConf" style="width: <?php echo $width; ?>px">Conferência</a>
																</li>
														<h6 class="SmartAdmin heading" style="color:black">Torres</h6>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-teal txt-color-white" id="linkCadTor" style="width: <?php echo $width; ?>px">Torres</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-teal txt-color-white" id="linkCadPart" style="width: <?php echo $width; ?>px">Partes</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-teal txt-color-white" id="linkCadPeca" style="width: <?php echo $width; ?>px">Peças</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-redLight txt-color-white" id="linkConsAnalit" style="width: <?php echo $width; ?>px">Consulta</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-blueDark txt-color-white" id="linkTorPed" style="width: <?php echo $width; ?>px">Pedidos</a>
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
															</ul>
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 show-stats">
														<div class="row">
															<?php while ($dados_rec_a = mysqli_fetch_assoc($rec_a)) {?>
															<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Tempo médio entre registro e chegada recebimento: <span class="pull-right"><?php echo number_format($dados_rec_a['tempo_total'], 2, ',', ' '); ?> Dias</span> </span>
																<div class="progress">
																	<div class="progress-bar bg-color-blueDark" style="width: <?php echo number_format($dados_rec_a['tempo_total'], 2, ',', ' '); ?>"></div>
																</div> </div>
															<?php }?>
															<?php while ($dados_rec_b = mysqli_fetch_assoc($rec_b)) {?>
															<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Tempo médio entre registro e efetivação do recebimento: <span class="pull-right"><?php echo number_format($dados_rec_b['tempo_rec'], 2, ',', ' '); ?> Dias</span> </span>
																<div class="progress">
																	<div class="progress-bar bg-color-blueDark" style="width: <?php echo number_format($dados_rec_b['tempo_rec'], 2, ',', ' '); ?>"></div>
																</div> </div>
															<?php }?>
														</div>

													</div>
												</div>

												<div class="show-stat-microcharts">
												<?php while ($status_rec = mysqli_fetch_assoc($res_status_rec)) {?>

													<div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
														<input type="hidden" name="tr_status" id="tr_status" value="<?php echo $status['tr_status_rec']; ?>">
														<div class="easy-pie-chart txt-color-orangeDark" data-percent="<?php echo ($status_rec['total_status_rec'] / $status_rec['total_rec']) * 100; ?>" data-pie-size="50">
															<span class="percent percent-sign"><?php echo ($status_rec['total_rec'] / $status_rec['total_status_rec']) * 100; ?></span>
														</div>
														<span class="easy-pie-title"> <?php echo $status_rec['tr_status_rec']; ?> <i class="fa fa-caret-up icon-color-bad"></i> </span>
													</div>
												<?php }?>
												</div>

											</div>
											<!-- end s2 tab pane -->

											<div class="tab-pane in padding-10 no-padding-bottom fade" id="s3">
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
																	<a href="javascript:void(0);" class="btn bg-color-blueDark txt-color-white" id="linkCol" style="width: <?php echo $width; ?>px">Coletas</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-orange txt-color-white" id="linkExp" style="width: <?php echo $width; ?>px">Expedição</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-blueDark txt-color-white" id="linkConf" style="width: <?php echo $width; ?>px">Conferência</a>
																</li>
														<h6 class="SmartAdmin heading" style="color:black">Torres</h6>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-teal txt-color-white" id="linkCadTor" style="width: <?php echo $width; ?>px">Torres</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-teal txt-color-white" id="linkCadPart" style="width: <?php echo $width; ?>px">Partes</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-teal txt-color-white" id="linkCadPeca" style="width: <?php echo $width; ?>px">Peças</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-redLight txt-color-white" id="linkConsAnalit" style="width: <?php echo $width; ?>px">Consulta</a>
																</li>
																<li>
																	<a href="javascript:void(0);" class="btn bg-color-blueDark txt-color-white" id="linkTorPed" style="width: <?php echo $width; ?>px">Pedidos</a>
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
															</ul>
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 show-stats">
														<div class="row">
															<?php while ($dados_media_a = mysqli_fetch_assoc($ped_media_a)) {?>
															<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Tempo médio entre emissão do pedido e data limite: <span class="pull-right"><?php echo number_format($dados_media_a['tempo_a'], 2, ',', ' '); ?> Dias</span> </span>
																<div class="progress">
																	<div class="progress-bar bg-color-blueDark" style="width: <?php echo number_format($dados_media_a['tempo_a'], 2, ',', ' '); ?>"></div>
																</div> </div>
															<?php }?>
															<?php while ($dados_media_b = mysqli_fetch_assoc($ped_media_b)) {?>
															<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Tempo médio entre data limite de expedição  e efetivação da entrega: <span class="pull-right"><?php echo number_format($dados_media_b['tempo_b'], 2, ',', ' '); ?> Dias</span> </span>
																<div class="progress">
																	<div class="progress-bar bg-color-blueDark" style="width: <?php echo number_format($dados_media_b['tempo_b'], 2, ',', ' '); ?>"></div>
																</div> </div>
															<?php }?>
														</div>

													</div>
												</div>

												<div class="show-stat-microcharts">
												</div>

											</div>
											<!-- end s3 tab pane -->
										</div>

										<!-- end content -->
									</div>

								</div>
								<!-- end widget div -->
							</div>
							<!-- end widget -->

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
							</article>
						</div>
						<div class="row">
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
						</div>
					</section>
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
		<?php include "script.php";?>
		<?php include "script_portaria.php";?>
		<?php include "script_gerenciamento.php";?>
		<!-- SmartChat UI : plugin -->
		<script src="js/smart-chat-ui/smart.chat.ui.min.js"></script>
		<script src="js/smart-chat-ui/smart.chat.manager.min.js"></script>

		<script type="text/javascript" src="script_torre.js"></script>
		<!--script type="text/javascript" src="script.js"></script-->
		<script type="text/javascript" src="script_empresa.js"></script>
		<script type="text/javascript" src="script_report.js"></script>
		<script type="text/javascript" src="script_qualidade.js"></script>
		<!--script type="text/javascript" src="script_acessos.js"></script-->
		<script type="text/javascript" src="jquery.table2excel.js"></script>
		<!-- ChartJs Dependencies -->
	    <!-- Morris Chart Dependencies -->
		<script src="js/plugin/morris/raphael.min.js"></script>
		<script src="js/plugin/morris/morris.min.js"></script>
		<!--script src="js/plugin/chartjs/chart.min.js"></script-->
		<!--script src="chart.js"></script-->

		<script src="js/plugin/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
		<?php
require_once 'data/movimento/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$select_nivel = "select fl_nivel from tb_cliente where cod_cliente = '$id'";
$nivel = mysqli_query($link, $select_nivel);

if ($nivel = "5") {

	include "script_cliente_consulta.php";
}
?>
	    <script type="text/javascript">
	    	var data =
		      <?php echo json_encode($array_pedido); ?>,
		    config = {
		      data: data,
		      xkey: 'mes',
		      ykeys: ['total'],
		      labels: ['Pedido emitidos'],
		      fillOpacity: 0.6,
		      hideHover: 'auto',
		      behaveLikeLine: true,
		      parseTime: false,
		      resize: true,
		      pointFillColors:['#ffffff'],
		      pointStrokeColors: ['black'],
		      lineColors:['gray','red']
		    };
			config.element = 'pedidoMes';
			Morris.Bar(config).on('click', function(i, row){
  				var thisTotal = row.total;
  				var thisMes = row.mes;
  				$.ajax({
				    url:"data/movimento/modal/m_dtl_pedido_mes.php",
				    method:"POST",
				    data:{thisTotal:thisTotal, thisMes:thisMes},
				    success:function(data)
				    {
				        $('#consulta').html(data);
				    }
			    });
  			});
	    </script>
	    <script type="text/javascript">
	    	var data =
		      <?php echo json_encode($array_rec); ?>,
		    config = {
		      data: data,
		      xkey: 'mesr',
		      ykeys: ['totalr'],
		      labels: ['Total de recebimentos'],
		      fillOpacity: 0.6,
		      hideHover: 'auto',
		      behaveLikeLine: true,
		      parseTime: false,
		      resize: true,
		      pointFillColors:['#ffffff'],
		      pointStrokeColors: ['black'],
		      lineColors:['gray','red']
		    };
			config.element = 'recebimentoMes';
			Morris.Bar(config).on('click', function(i, row){
  						var thisTotal = row.totalr;
  						var thisMes = row.mesr;
  						$.ajax({
				            url:"data/movimento/modal/m_dtl_recebimento_mes.php",
				            method:"POST",
				            data:{thisTotal:thisTotal, thisMes:thisMes},
				            success:function(data)
				          	{
				                $('#consulta').html(data);
				            }
			            });
  					});
	    </script>
	    <script type="text/javascript">
	    	var data =<?php echo json_encode($array_status); ?>,
		    config = {
		      data: data,
		      xkey: 'cod_prod_cliente',
		      ykeys: ['nivel', 'freq'],
		      labels: ['Nível de estoque', 'Curva'],hideHover: 'auto',
		      pointSize: 3,
		      parseTime: false,
		      resize: true
				};
			config.element = 'pedidosStatus';
			config.stacked = true;
			Morris.Line(config).on('click', function(i, row){
  						var thisProduto = row.cod_prod_cliente;
  						$.ajax({
				            url:"data/dashboard/modal/m_dtl_nivel.php",
				            method:"POST",
				            data:{thisProduto:thisProduto},
				            success:function(data)
				          	{
				                $('#consulta').html(data);
				            }
			            });
  					});
	    </script>
	    <script type="text/javascript">
	    	var data =<?php echo json_encode($array_entrega); ?>,
		    config = {
		      data: data,
		      xkey: 'ped_dia',
		      ykeys: ['tempo_b', 'prazo'],
		      labels: ['Tempo médio', 'Prazo'],hideHover: 'auto',
		      pointSize: 3,
		      parseTime: false,
		      resize: true
				};
			config.element = 'pedidosEntrega';
			config.stacked = true;
			Morris.Line(config);
	    </script>
	    <script type="text/javascript">
	    	var data =<?php echo json_encode($array_expede); ?>,
		    config = {
		      data: data,
		      xkey: 'ped_dia',
		      ykeys: ['tempo_a', 'prazo'],
		      labels: ['Tempo médio', 'Prazo'],hideHover: 'auto',
		      pointSize: 3,
		      parseTime: false,
		      resize: true
				};
			config.element = 'pedidosExpede';
			config.stacked = true;
			Morris.Line(config);
	    </script>
	    <script type="text/javascript">
	    	var data =<?php echo json_encode($array_ocor); ?>,
		    config = {
		      data: data,
		      xkey: 'dia',
		      ykeys: ['total', 'target'],
		      labels: ['Ocorrências', 'Objetivo'],hideHover: 'auto',
		      pointSize: 3,
		      parseTime: false,
		      resize: true
				};
			config.element = 'pedidosOcorrencia';
			config.stacked = true;
			Morris.Line(config);
	    </script>
	    <script type="text/javascript">
	    	var data =
		    <?php echo json_encode($array_giro); ?>,
		    config = {
		      data: data,
		      xkey: 'produto',
		      ykeys: ['giro'],
		      labels: ['Giro'],
		      fillOpacity: 0.6,
		      hideHover: 'auto',
		      behaveLikeLine: true,
		      parseTime: false,
		      resize: true,
		      pointFillColors:['#ffffff'],
		      pointStrokeColors: ['black'],
		      lineColors:['gray','red']
		    };
			config.element = 'giroEstoque';
			Morris.Bar(config);

	    </script>
	    <script type="text/javascript">
	    	var data =<?php echo json_encode($array_tempo); ?>,
		    config = {
		      data: data,
		      xkey: 'produto',
		      ykeys: ['giro','tempo'],
		      labels: ['Saldo médio', 'Tempo médio'],hideHover: 'auto',
		      pointSize: 3,
		      parseTime: false,
		      resize: true
				};
			config.element = 'tempoEstoque';
			config.stacked = true;
			Morris.Line(config);
	    </script>
	    <script type="text/javascript">
		    $(document).ready(function(){

		      var timer = setInterval(function(){
		           $('#consultaRetorno').load('fechamento.php');
		          }, 7200000);
		      return false;
		    });
		</script>
	</body>
</html>