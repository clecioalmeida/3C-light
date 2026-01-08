<?php
require_once 'data/movimento/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_torre = "select * from tb_tipo_torre where fl_status <> 'E'";
$res_torre = mysqli_query($link, $sql_torre);

$link->close();
?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Cadastros</li><li>Torres</li>
		</ol>
	</div>
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa-fw fa fa-home"></i>
						Consulta
					<span>|
						Torres
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
													<h2>Relatório de saldo de torres</h2>
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
																	<div class="col-sm-8" style="text-align: left;">
																		<div class="form-group form-inline">
																			<select class="form-control" id="id_torre_rel" name="id_torre_rel">
											                                    <option value="">Escolha a Torre</option>
											                                    <?php
while ($torre = mysqli_fetch_assoc($res_torre)) {
	echo '<option value="' . $torre['id'] . '">' . $torre['id'] . ' ' . $torre['ds_tensao'] . ' ' . 'KV ' . ' ' . $torre['ds_torre'] . ' ' . $torre['ds_tipo'] . ' ' . $torre['ds_linhao'] . ' ' . $torre['ds_circuito'] . '</option>';
}?>
											                                </select>
																		</div>
																	</div>
																	<div>
																		<button type="submit" class="btn btn-success" id="RelSintTorGenExcel" style="float:right;margin-right: 10px;width: 100px">Excel</button>
                            											<button type="submit" class="btn btn-primary" id="RelSaldoTorre" value="" style="float:right;margin-right: 10px;width: 100px">Consultar</button>
                            										</div>
                            										</div>
                            										<div class="row">
                            											<div id="tabela"></div>
                            											<div id="retReport"></div>
                            										</div>

																</div>
															</fieldset>
														</form>
													</article>

													<div class="page-content-wrapper">											<div id="tabelaItem"></div>
													</div>
													<!-- end widget content -->

												</div>
												<!-- end widget div -->

											</div>
										<!-- end widget -->
									</div>

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
					<!-- end widget -->

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