<?php
require_once 'bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_local = "select * from tb_armazem";
$res_local = mysqli_query($link, $sql_local);

?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Relatórios</li><li>Giro de estoque</li>
		</ol>
	</div>
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa-fw fa fa-home"></i>
						Relatórios
					<span>|
						Saldos de estoque
					</span>
				</h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
			</div>
		</div>
		<section id="widget-grid" class="">
			<div class="row">
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
											<h2>Relatório de saldos de estoque </h2>
										</header>
										<div>
											<div class="jarviswidget-editbox"></div>
											<div class="widget-body no-padding" id="dados">
												<div id="retorno"></div>
												<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<form method="POST" class="form-inline" id="formGiroEstoque" action=""><br><br>
												        <fieldset>
															<div class="col-sm-12" style="text-align: left;">
																<div class="form-group">
																	<label>Produto</label>
																	<input type="text" id="CodProduto" class="form-control" name="CodProduto" aria-describedby="basic-addon2" placeholder="Digite o código WMS">
																	<input type="text" id="CodProdCliente" class="form-control" name="CodProdCliente" aria-describedby="basic-addon2" placeholder="Digite o código SAP">
																	<input type="submit" class="btn-info form-control" id="btnPesquisaGiro" value="Pesquisar">
																</div>
															</div>
														</fieldset>
												    </form>
													<div id="relatorio" class="row"></div>
												</article>
											</div>
										</div>
									</div>
								</article>
							</div>
						</section>
					</div>
				</div>
			</div>
		</section>
	</div>
	<div class="row">
		<div class="col-sm-12">
		</div>
	</div>
</div>