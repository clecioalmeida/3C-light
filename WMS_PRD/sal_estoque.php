<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_local = "select * from tb_armazem";
$res_local = mysqli_query($link, $sql_local);

$link->close();
?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Relatórios</li><li>Saldos de estoque</li>
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
						Relatórios
					<span>|
						Saldos de estoque
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
													<h2>Relatório de saldos de estoque </h2>
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
														<form method="POST" class="form-inline" id="formSalEstoque" action=""><br><br>
												            <fieldset>
																<div class="col-sm-12" style="text-align: left;">
																	<div class="form-group">
																		<label>Produto</label>
																		<input type="text" id="CodProduto" class="form-control" name="cod_produto" aria-describedby="basic-addon2" placeholder="Digite o código do produto">
																		<label>Armazém</label>
																		<select class="form-control" id="ds_armazem" name="ds_armazem" required="true">
																			<option value="">Todos</option>
																			<?php
while ($row_select_local = mysqli_fetch_assoc($res_local)) {
	echo '<option value="' . $row_select_local['id'] . '">' . $row_select_local['nome'] . '</option>';
}?>
																		</select>
																		<label>Tipo</label>
																		<select class="form-control" id="tipoMovimento" name="tipoMovimento">
																			<option value="1">Todos</option>
																			<option value="2">Sem saldo</option>
																		</select>
																		<input type="submit" class="btn-info form-control" id="btnPesquisaSaldo" value="Pesquisar">
																	</div>
																</div>
															</fieldset>
												        </form>
														<div id="relatorio" class="row"></div>
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