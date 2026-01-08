<?php
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$query_conf = "SELECT id, nome from tb_armazem where fl_situacao = 'A'";
$res_conf = mysqli_query($link, $query_conf);

$sql_material = "SELECT cod_recebimento, ds_enr FROM tb_recebimento_ag WHERE fl_status = 'A'";
$res_material = mysqli_query($link, $sql_material);

//$link->close();
?>

<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white;font-size: 12px;">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="recebimento.php" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header>
						<h4>NOVO RECEBIMENTO</h4>
						<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
						<span id="retRec"></span>
					</header>
					<div role="content">
						<div class="widget-body">
							<form id="form_conf_end" method="" action="">
								<fieldset>
									<div class="form-group">
										<label>FORNECEDOR:</label>
										<div class="col-md-12">
											<div class="form-group">
												<input type="text" id="nm_fornecedor" name="nm_fornecedor" class="form-control">
											</div>
										</div>
										<div class="col-md-12">
											<label>VEÍCULO:</label>
											<div class="col-md-6">
												<div class="form-group">
													<input type="text" id="nr_placa" name="nr_placa" class="form-control">
												</div>
											</div>
											<label>MOTORISTA:</label>
											<div class="col-md-6">
												<div class="form-group">
													<input type="text" id="nm_mot" name="nm_mot" class="form-control">
												</div>
											</div>
											<label>DATA:</label>
											<div class="col-md-6">
												<div class="form-group">
													<input type="date" id="dt_recebimento" name="dt_recebimento" class="form-control" required="true">
												</div>
											</div>
										</div>
									</div>
									<div class="produto">
										<div class="row" id="confPpPick">
											<form id="form_conf_PP" method="" action="">
												<div class="col-md-12">
													<div class="form-group">
														<label>ENDEREÇO:</label>
														<select class="form-control" name="ds_galpao" id="ds_galpao">
															<?php

															while ($dados = mysqli_fetch_assoc($res_conf)) { ?>

																<option value="<?php echo $dados['id']; ?>"><?php echo $dados['nome']; ?></option>

															<?php } ?>
														</select>
														<input type="text" id="ds_endereco" name="ds_endereco" class="form-control" required="true" style="text-align: right;">
														<label id="retNmPrd">LOTE:</label>
														<input type="text" id="cod_produto" name="cod_produto" class="form-control" required="true" style="text-align: right;">
														<label>MATERIAL:</label>
														<select class="form-control" name="ds_material" id="ds_material">
															<option value="FERRO">FERRO</option>
															<option value="VIDRO">VIDRO</option>
															<option value="ALUMÍNIO">ALUMÍNIO</option>
															<option value="CABO">CABO</option>
															<option value="SOBRA">SOBRA</option>
														</select>
														<label>LP:</label>
														<input type="text" id="ds_lp" name="ds_lp" class="form-control" autofocus="true" style="text-align: right;">
														<label>QUANTIDADE:</label>
														<input type="text" id="nr_qtde" name="nr_qtde" class="form-control nr_qtde" style="text-align: right;">
														<div class="ui-grid-b">
															<div class="ui-block-a"><input type="text" id="ds_kva" name="ds_kva" value="" placeholder="KVA" style="text-align: right;"></div>
															<div class="ui-block-b"><input type="text" id="nr_serial" name="nr_serial" value="" placeholder="SERIAL" style="text-align: right;"></div>
															<div class="ui-block-c"><input type="text" id="ds_fabr" name="ds_fabr" value="" placeholder="FABRICANTE"></div>
														</div>
														<div class="ui-grid-a">
															<div class="ui-block-a"><input type="text" id="ds_ano" name="ds_ano" value="" placeholder="ANO" style="text-align: right;"></div>
															<div class="ui-block-b"><input type="text" id="ds_enr" name="ds_enr" value="" placeholder="ENROLAMENTO"></div>
															<!--div class="ui-block-c"><input type="text" id="ds_oleo" name="ds_oleo" value="" placeholder="Oleo/litro"></div-->
														</div>
														<label>OBERVAÇÕES:</label>
														<div class="col-md-12">
															<div class="form-group">
																<textarea id="ds_obs" name="ds_obs" class="form-control"></textarea>
															</div>
														</div>
														<button class="btn btn-primary" type="button" id="btnSaverec">SALVAR</button>
														<hr>
														<button type="submit" class="ui-btn ui-shadow-icon ui-btn-a" id="btnFinOR" value="" style="float: right;margin-left: 5px;background-color: #16a085;text-shadow: none;color:white;border-color: #fdfbfb">FINALIZAR</button>

													</div>
												</div>
											</form>
										</div>
									</div>
								</fieldset>
								<fieldset>
									<div id="retConsPp"></div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</article>
		</div>
		<div data-role="footer" data-position="fixed" data-tap-toggle="false" class="jqm-footer">
			<p>Argus Soluções para logística</p>
			<p>Copyright <?= date('Y') ?> - Argus</p>
		</div>
	</div>
</div>