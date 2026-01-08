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
																<form class="form-inline" method="POST" id="formExpTorre" action="">
																	<div class="col-md-8">
																		<div class="form-group">
																			<label for="tags"> Torre</label>
																			<select class="form-control" id="id_torre_ex" name="id_torre_ex" style="width: 200px">
																				<option value="">Escolha a Torre</option>
																				<?php
																				while ($torre=mysqli_fetch_assoc($res_torre)) {
																					echo '<option value="'.$torre['id'].'">'.$torre['id'].' '.$torre['ds_tensao'].' '.'Kv'.' '.$torre['ds_circuito'].' '.$torre['ds_linhao'].' '.$torre['ds_torre'].' '.$torre['ds_tipo'].' '.$torre['ds_obs'].'</option>';
																				} ?>
																			</select>
																		</div>
																		<div class="form-group">
																			<label for="tags"> Parte</label>
																			<select class="form-control" id="id_parte_ex" name="id_parte_ex">
																				<option>Escolha a parte da Torre</option>

																			</select>
																		</div>
																	</div><br><br><br><br>
																	<div class="col-md-8">
																		<div class="form-group">
																			<label for="tags"> Peça</label>
																			<select class="form-control" id="id_item_ex" name="id_item_ex">
																				<option>Escolha a peça</option>

																			</select>
																		</div>
																		<div class="form-group">
																			<label for="tags"> Endereço</label>
																			<select class="form-control" id="id_rua_ex" name="id_rua_ex">
																				<option>Escolha o Endereço</option>
																			</select>
																		</div>
																		<div class="form-group form-inline" style="float:right; margin-right: 10px">
																			<button type="submit" class="btn btn-success" id="btnInsPedido">Incluir</button>
																		</div>
																		<div class="form-group form-inline">
																			<input type="btn" id="nr_qtde" name="nr_qtde" class="form-control" aria-describedby="basic-addon2" placeholder="Quantidade" style="width: 100px">
																		</div>

																		<br><br><br>

																		<div class="row" id="tabela">
																		</div>

																	</div>
																</form>
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
		</section>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
	</div>							
</div>