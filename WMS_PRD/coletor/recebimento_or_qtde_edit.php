<?php
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$cod_rec       = $_GET['cod_rec'];

$sql_ped = "SELECT cod_recebimento, nm_placa, nm_fornecedor, nm_motorista,
 nr_qtde as total_itens, nr_serial, cod_produto, coalesce(id_end,0) as id_end, ds_galpao, ds_rua, ds_coluna, ds_altura,
 ds_kva, ds_lp, ds_enr, ds_fabr, ds_ano, date(dt_recebimento_real) as dt_recebimento, ds_obs
 from tb_recebimento_ag 
 where cod_recebimento = '$cod_rec'";
$res_ped = mysqli_query($link, $sql_ped);

while ($dados_rec = mysqli_fetch_assoc($res_ped)) {

	$cod_recebimento 	= $dados_rec['cod_recebimento'];
	$nm_placa 			= $dados_rec['nm_placa'];
	$nm_fornecedor 		= $dados_rec['nm_fornecedor'];
	$nm_motorista 		= $dados_rec['nm_motorista'];
	$total_itens 		= $dados_rec['total_itens'];
	$nr_serial 			= $dados_rec['nr_serial'];
	$cod_produto 		= $dados_rec['cod_produto'];
	$id_end 			= $dados_rec['id_end'];
	$ds_galpao 			= $dados_rec['ds_galpao'];
	$ds_rua 			= $dados_rec['ds_rua'];
	$ds_coluna 			= $dados_rec['ds_coluna'];
	$ds_altura 			= $dados_rec['ds_altura'];
	$ds_kva 			= $dados_rec['ds_kva'];
	$ds_lp 				= $dados_rec['ds_lp'];
	$ds_enr 			= $dados_rec['ds_enr'];
	$ds_fabr 			= $dados_rec['ds_fabr'];
	$ds_ano 			= $dados_rec['ds_ano'];
	$dt_recebimento 	= $dados_rec['dt_recebimento'];
	$ds_obs             = $dados_rec['ds_obs'];

}

$query_conf = "select id, nome from tb_armazem where fl_situacao = 'A'";
$res_conf = mysqli_query($link, $query_conf);

$link->close();
?>
<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white;font-size: 12px;">
	<div data-role="header" class="jqm-header" style="height: 50px">
		<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
		<a href="recebimento_dtl.php?nm_placa=<?php echo $nm_placa; ?>&nm_fornecedor=<?php echo $nm_fornecedor; ?>" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
		<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
	</div>
	<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
					<header>
						<h4>EDITAR RECEBIMENTO</h4>
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
												<input type="text" id="nm_fornecedor" name="nm_fornecedor"  class="form-control" value="<?php echo $nm_fornecedor; ?>">
											</div>
										</div>
										<div class="col-md-12">
											<label>VEÍCULO:</label>
											<div class="col-md-6">
												<div class="form-group">
													<input type="text" id="nr_placa" name="nr_placa" class="form-control" value="<?php echo $nm_placa; ?>">
												</div>
											</div>
											<label>MOTORISTA:</label>
											<div class="col-md-6">
												<div class="form-group">
													<input type="text" id="nm_mot" name="nm_mot" class="form-control" value="<?php echo $nm_motorista; ?>">
												</div>
											</div>
											<label>DATA:</label>
											<div class="col-md-6">
												<div class="form-group">
													<input type="date" id="dt_recebimento" name="dt_recebimento" class="form-control" required="true" value="<?php echo $dt_recebimento; ?>">
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
														<input type="text" id="ds_endereco" name="ds_endereco" class="form-control" required="true" value="<?php echo $id_end."-". $ds_rua."-". $ds_coluna."-". $ds_altura; ?>" style="text-align: right;">
														<label id="retNmPrd">PRODUTO:</label>
														<input type="text" id="cod_produto" name="cod_produto" class="form-control" required="true" value="<?php echo $cod_produto; ?>" autofocus="true" style="text-align: right;">
														<label>LP:</label>
														<input type="text" id="ds_lp" name="ds_lp" class="form-control" value="<?php echo $ds_lp; ?>" style="text-align: right;">
														<label>QUANTIDADE (KG ou UND):</label>
														<input type="text" id="nr_qtde" name="nr_qtde" class="form-control" value="<?php echo $total_itens; ?>" style="text-align: right;">
														<div class="ui-grid-b">
															<div class="ui-block-a"><input type="text" id="ds_kva" name="ds_kva" value="<?php echo $ds_kva; ?>" placeholder="KVA" style="text-align: right;"></div>
															<div class="ui-block-b"><input type="text" id="nr_serial" name="nr_serial" value="<?php echo $nr_serial; ?>" placeholder="SERIAL" style="text-align: right;"></div>
															<div class="ui-block-c"><input type="text" id="ds_fabr" name="ds_fabr" value="<?php echo $ds_fabr; ?>" placeholder="FABRICANTE"></div>
														</div>
														<div class="ui-grid-a">
															<div class="ui-block-a"><input type="text" id="ds_ano" name="ds_ano" value="<?php echo $ds_ano; ?>" placeholder="ANO" style="text-align: right;"></div>
															<div class="ui-block-b"><input type="text" id="ds_enr" name="ds_enr" value="<?php echo $ds_enr; ?>" placeholder="ENROLAMENTO"></div>
														</div>
														<br>
														<label>OBERVAÇÕES:</label>
														<div class="col-md-12">
															<div class="form-group">
																<textarea id="ds_obs" name="ds_obs" class="form-control"><?= $ds_obs ?></textarea>
															</div>
														</div>
														<button class="btn btn-primary" type="button" value="<?php echo $cod_rec; ?>" id="btnSaverecDtl">SALVAR</button>
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
			<p>Copyright 2021 - Argus</p>
		</div>
	</div>
</div>