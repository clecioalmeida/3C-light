<?php
require_once 'data/movimento/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_galpao = "select * from tb_armazem where id > 1";
$galpao = mysqli_query($link, $sql_galpao);
$tr = mysqli_num_rows($galpao);

$sql_rua = "select distinct ds_prateleira from tb_posicao_pallet where ds_galpao = 17";
$rua = mysqli_query($link, $sql_rua);

$link->close();
?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Movimentação</li><li>movimentação de produtos</li>
		</ol>
	</div>
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa-fw fa fa-home"></i>
					Movimentação
					<span>|
						movimentação de Torres
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
												<span class="widget-icon"> <i class="fa fa-table"></i> </span>
												<h2>Movimentação de Torres por feixe</h2>
											</header>
											<div>
												<div class="jarviswidget-editbox">
												</div>
												<div class="widget-body no-padding" id="dados">
													<div id="retorno"></div>
													<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<form method="POST" class="form-inline" id="formMovPrd" action=""><br><br>
															<fieldset>
																<div class="col-sm-12">
																	<div class="form-group" style="float: left;">
																		<select class="form-control" id="selRuaTorreFx" name="selRuaTorreFx">
																			<option>Selecione a rua</option>
																			<?php
																			while ($dados = mysqli_fetch_assoc($rua)) {?>
																				<option value="<?php echo $dados['ds_prateleira']; ?>"><?php echo $dados['ds_prateleira']; ?></option>
																			<?php }
																			$link->close();?>
																		</select>
																		<select class="form-control" id="selModTorreFx" name="selModTorreFx">
																			<option>Selecione a coluna</option>

																		</select>
																		<select class="form-control" id="selFeixeFx" name="selFeixeFx">
																			<option>Selecione o feixe</option>
																		</select>
																		<input type="submit" class="btn-success form-control" id="btnListProdFeixe" value="Pesquisar">
																	</div>
																</div>
															</fieldset>
														</form><br /><br />
														<div id="info_produtos" class="row"></div>
													</article>
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