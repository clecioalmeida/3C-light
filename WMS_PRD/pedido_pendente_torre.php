<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$query = "SET SQL_BIG_SELECTS=1";
$res_query = mysqli_query($link, $query);

$SQL1 = "select count(nr_pedido) as pedidos from tb_pedido_coleta where fl_status = 'A' and fl_tipo = 'T'";
$res1 = mysqli_query($link, $SQL1);
while ($dados1 = mysqli_fetch_assoc($res1)) {
	$aberto = $dados1['pedidos'];
}

$SQL2 = "select count(nr_pedido) as coleta
from tb_pedido_coleta
where fl_status = 'P' or fl_status = 'M' or fl_status = 'C' or fl_status = 'F' and fl_tipo = 'T'";
$res2 = mysqli_query($link, $SQL2);
while ($dados2 = mysqli_fetch_assoc($res2)) {
	$coleta = $dados2['coleta'];
}

$SQL3 = "select count(nr_pedido) as expede
from tb_pedido_coleta
where fl_status = 'X' and fl_tipo = 'T'";
$res3 = mysqli_query($link, $SQL3);
while ($dados3 = mysqli_fetch_assoc($res3)) {
	$expede = $dados3['expede'];
}

$SQL4 = "select count(nr_pedido) as expede
from tb_pedido_coleta
where fl_status = 'I' and fl_tipo = 'T'";
$res4 = mysqli_query($link, $SQL4);
while ($dados4 = mysqli_fetch_assoc($res4)) {
	$pendente = $dados4['expede'];
}

$link->close();
?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Torres</li><li>Pedidos de distribuição</li>
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
						Torres
					<span>|
						Pedidos de distribuição
					</span>
				</h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
				<ul id="sparks" class="">
					<li class="sparks-info">
						<h5> Pedidos abertos <span class="txt-color-blue"><i class="fa fa-arrow-circle-down"></i>&nbsp;<?php echo $aberto; ?></span></h5>
						<!--div class="sparkline txt-color-blue hidden-mobile hidden-md hidden-sm">
							1300, 1877, 2500, 2577, 2000, 2100, 3000, 2700, 3631, 2471, 2700, 3631, 2471
						</div-->
					</li>
					<li class="sparks-info">
						<h5> Pedidos pendentes <span class="txt-color-blue"><i class="fa fa-arrow-circle-down"></i>&nbsp;<?php echo $pendente; ?></span></h5>
						<!--div class="sparkline txt-color-blue hidden-mobile hidden-md hidden-sm">
							1300, 1877, 2500, 2577, 2000, 2100, 3000, 2700, 3631, 2471, 2700, 3631, 2471
						</div-->
					</li>
					<li class="sparks-info">
						<h5> Pedidos em coleta <span class="txt-color-purple"><i class="fa fa-arrow-circle-up"></i>&nbsp;<?php echo $coleta; ?></span></h5>
						<!--div class="sparkline txt-color-purple hidden-mobile hidden-md hidden-sm">
							110,150,300,130,400,240,220,310,220,300, 270, 210
						</div-->
					</li>
					<li class="sparks-info">
						<h5> Pedidos em expedição <span class="txt-color-greenDark"><i class="fa fa-arrow-circle-up"></i></i>&nbsp;<?php echo $expede; ?></span></h5>
						<!--div class="sparkline txt-color-greenDark hidden-mobile hidden-md hidden-sm">
							110,150,300,130,400,240,220,310,220,300, 270, 210
						</div-->
					</li>
				</ul>
			</div>
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
													<span class="widget-icon"> <i class="fa fa-table"></i> </span>
													<h2>Pedidos de distribuição </h2>

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
														<form method="POST" class="form-inline" id="formAlocCod" action=""><br><br>
												            <fieldset>
																<div class="col-sm-8" style="text-align: left;">
																	<div class="form-group">
																		<input type="text" id="nr_pedido" class="form-control" name="nr_pedido" aria-describedby="basic-addon2" placeholder="Digite o pedido">
																	</div>
																	<div class="form-group">
																		<div class="radio">
																			<label class="radio-inline" style="vertical-align: center">
																				<input type="radio" class="radio" value="A" name="pesqStatus" id="PesqStatusAberto" checked="true" style="width: 18px;height: 18px">
																				<span>Abertos</span>
																			</label>
																			<label class="radio-inline" style="vertical-align: center">
																				<input type="radio" class="radio" value="I" name="pesqStatus" id="PesqStatusPendente" style="width: 18px;height: 18px">
																				<span>Pendentes</span>
																			</label>
																			<label class="radio-inline" style="vertical-align: center">
																				<input type="radio" class="radio" value="C" name="pesqStatus" id="PesqStatusColeta" style="width: 18px;height: 18px">
																				<span>Coletando</span>
																			</label>
																			<label class="radio-inline" style="vertical-align: center">
																				<input type="radio" class="radio" value="E" name="pesqStatus" id="PesqStatusExpede" style="width: 18px;height: 18px">
																				<span>Expedição</span>
																			</label>
																		<input type="submit" class="btn-info form-control" id="btnPesqPedidoTorre" value="Pesquisar">
																		</div>
																	</div>
																</div>
															</fieldset><br><br>
												        </form>
														<div id="info_pedidos" class="row"></div>
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