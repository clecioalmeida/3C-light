<?php
require_once('data/torre/bd_class.php');

$objDb = new db();
$link = $objDb->conecta_mysql();

$tp_tipo = "select * from tb_tp_torre";
$res_tp_torre = mysqli_query($link, $tp_tipo);

$sql_torre = "select * from tb_tipo_torre";
$res_torre = mysqli_query($link, $sql_torre);

$sql_parte = "select t1.id as id1, t1.*, t2.* from tb_torre_tipo t1 left join tb_tp_torre t2 on t1.id_tipo = t2.id order by t2.parte";
$res_parte = mysqli_query($link, $sql_parte);

?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Torres</li><li>Expedição</li>
		</ol>
	</div>
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa-fw fa fa-home"></i> 
					Torres 
					<span>|  
						Expedição
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
											</header>
											<div>
												<div class="jarviswidget-editbox">
												</div>
												<div class="widget-body no-padding" id="dados">
													<div id="retorno"></div>
													<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<form method="POST" class="form-inline" id="formAlocCod" action=""><br><br>
															<fieldset>
																<div class="col-md-12">
																	<form class="form-inline" method="POST" id="formExpTorre" action="">
																		<div class="form-group">
																			<label for="tags"> Torre</label>
																			<select class="form-control" id="id_torre_ex_fx" name="id_torre_ex_fx">
																				<option value="">Escolha a Torre</option>
																				<?php
																				while ($torre=mysqli_fetch_assoc($res_torre)) {
																					echo '<option value="'.$torre['id'].'">'.$torre['id'].' '.$torre['ds_tensao'].' '.'Kv'.' '.$torre['ds_circuito'].' '.$torre['ds_linhao'].' '.$torre['ds_torre'].' '.$torre['ds_tipo'].' '.$torre['ds_obs'].'</option>';
																				} ?>
																			</select>
																		</div>
																		<div class="form-group">
																			<label for="tags"> Parte</label>
																			<select class="form-control" id="id_parte_ex_fx" name="id_parte_ex_fx">
																				<option>Escolha a parte da Torre</option>
																			</select>
																		</div>
																		<div class="form-group">
																			<label for="tags"> Peça</label>
																			<select class="form-control" id="id_fx_ex" name="id_fx_ex">
																				<option>Escolha o feixe</option>
																			</select>
																		</div>
																		<div class="form-group form-inline" style="float:right; margin-right: 10px">
																			<button type="submit" class="btn btn-success" id="btnInsPedidoFx">Incluir</button>
																		</div>
																	</form>
																	<br><br><br>

																	<div class="row" id="aviso">
																	</div>
																	<div class="row" id="tabela">
																	</div>
																</div>
															</fieldset>
														</form>
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
</div>