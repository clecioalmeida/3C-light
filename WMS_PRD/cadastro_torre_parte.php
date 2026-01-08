<?php
require_once 'data/movimento/bd_class_dsv.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_torre = "select * from tb_tipo_torre where fl_status <> 'E'";
$res_torre = mysqli_query($link, $sql_torre);

?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Cadastros</li><li>Partes de torre</li>
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
					Cadastros
					<span>|
						Partes de torre
					</span>
				</h1>
			</div>
			<!-- end col -->

			<!-- right side of the page with the sparkline graphs -->
			<!-- col -->
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
			</div>
			<!-- end col -->

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
												<span class="widget-icon"> <i class="fa fa-cog"></i> </span>
												<h2>Cadastro partes de Torre</h2>

											</header>

											<div>

												<!-- widget edit box -->
												<div class="jarviswidget-editbox">
													<!-- This area used as dropdown edit box -->

												</div>
												<!-- end widget edit box -->

												<!-- widget content -->
												<div class="widget-body no-padding" id="dados"><br><br>
													<div id="retorno"></div>
													<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

														<form class="form-inline" method="POST" id="formCadTipo" action="">
															<div class="form-group">
																<label for="tags" style="color: white"> Torre</label>
																<select class="form-control" id="btnConsConjunto" name="btnConsConjunto">
																	<option value="">Escolha a Torre</option>
																	<?php
																	while ($torre = mysqli_fetch_assoc($res_torre)) {
																		echo '<option value="' . $torre['id'] . '">' . $torre['id'] . ' ' . $torre['ds_tensao'] . ' ' . 'KV ' . ' ' . $torre['ds_torre'] . ' ' . $torre['ds_tipo'] . ' ' . $torre['ds_circuito'] . ' ' . $torre['ds_linhao'] . '</option>';
																	}?>
																</select>
															</div>
															<button type="submit" class="btn btn-info" id="btnCadParte" style="float:right;">Cadastrar Conjunto</button>
															<button type="submit" class="btn btn-primary" id="consultaConjunto" style="float:right;">Consultar Conjunto</button>
														</form>
														<div class="row" id="tabela"></div>
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
<script>
	$(document).ready(function(){
		$('#consultaConjunto').click(function(){
			$('#formCadTipo').ajaxForm({
				target:'#tabela',
				url:'data/torre/consulta_conjunto_sql.php',
				beforeSend:function(e){
					$("#tabela").html("<img src='includes/torres/js/loading9.gif'>");
				}
			});
		});
		$('#CadastraConjunto').click(function(){
			$('#formCadTipo').ajaxForm({
				target:'#tabela',
				url:'includes/torres/consulta_conjunto_sql2.php',
				beforeSend:function(e){
					$("#tabela").html("<img src='includes/torres/js/loading9.gif'>");
				}
			});
		});
	});
</script>