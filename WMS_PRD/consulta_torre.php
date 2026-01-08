<?php
require_once 'data/movimento/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_torre = "select * from tb_tipo_torre where fl_status <> 'E'";
$res_torre = mysqli_query($link, $sql_torre);

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
																			<select class="form-control" id="id_torre_con" name="id_torre">
																				<option value="">Escolha a Torre</option>
																				<?php
																				while ($torre = mysqli_fetch_assoc($res_torre)) {
																					echo '<option value="' . $torre['id'] . '">' . $torre['id'] . ' ' . $torre['ds_tensao'] . ' ' . 'KV ' . ' ' . $torre['ds_torre'] . ' ' . $torre['ds_tipo'] . ' ' . $torre['ds_linhao'] . ' ' . $torre['ds_circuito'] . '</option>';
																				}?>
																			</select>
																		</div>
																	</div>
																	<div>
																		<button type="submit" class="btn btn-success" id="SalSintTorGenExcel" style="float:right;margin-right: 10px;width: 100px">Excel</button>
																		<button type="submit" class="btn btn-secondary" id="ConsSaldoPecas" value="" style="float:right;margin-right: 10px;width: 150px">Saldo de peças</button>
																		<button type="submit" class="btn btn-primary" id="ConsSaldoTorre" value="" style="float:right;margin-right: 10px;width: 150px">Consultar torre</button>
																	</div>
																</div>
																<div class="row">
																	<div id="tabela"></div>
																</div>
															</div>
														</fieldset>
													</form>
												</article>
												<div class="page-content-wrapper">											
													<div id="tabelaItem"></div>
												</div>
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