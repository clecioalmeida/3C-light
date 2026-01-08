<?php
require_once 'xhr/bd_class.php';

$objDb = new db();
$link = $objDb->conecta_mysql();

$dt_limite  	= $_GET['data'];
$cod_almox  	= $_GET['cod_almox'];
$nm_destino  	= $_GET['nm_destino'];
if ($_GET['qtd_flt'] != "0") {
	$qtd_falta = "FALTA";
} else {
	$qtd_falta = $_GET['qtd_flt'];
}
//$qtd_falta  	= $_GET['qtd_flt'];
echo $qtd_falta . "<br>";

$sql_ped = "SELECT v.id as id_volume, COALESCE(v.cod_etq,'SEM ETIQUETA') AS cod_etq, v.nr_total_volume 
from tb_volume v  
LEFT JOIN tb_rota_volume r on r.id = v.id_rota_volume  
where r.cod_almox = '$cod_almox' and r.dt_limite = '$dt_limite' and v.fl_status <> 'E'";
$res_ped = mysqli_query($link, $sql_ped);

$sql_serie = "SELECT SUM(nr_total_volume) as total_volume, r.nr_total, (r.nr_total-v.nr_total_volume) as total_faltante  
FROM tb_volume v 
LEFT JOIN tb_rota_volume r on r.id = v.id_rota_volume
WHERE r.cod_almox = '$cod_almox' and r.dt_limite = '$dt_limite' and v.fl_status <> 'E'";
$res_serie = mysqli_query($link, $sql_serie);
$dados_serie = mysqli_fetch_assoc($res_serie);
$total_volume 	= $dados_serie['total_volume'];
$nr_total    	= $dados_serie['nr_total'];
$total_faltante = $dados_serie['total_faltante'];

$link->close();

if ($qtd_falta != "FALTA") { ?>

	<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white;font-size: 12px;">
		<div data-role="header" class="jqm-header" style="height: 50px">
			<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
			<a href="expede_rota.php?data=<?php echo $dt_limite; ?>" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
			<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
		</div>
		<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
						<div role="content">
							<fieldset>
								<form id="form_conf_end" method="" action="">
									<fieldset>
										<h3 style="text-align: center;">CONTROLE DE VOLUMES DE EXPEDIÇÃO</h3>
										<h3 style="text-align: center;"><?php echo $nm_destino; ?></h3>
										<a id="reload_prd_rec" href="recebimento_or_qtde_dtl.php?cod_rec=<?php echo $cod_rec; ?>&nm_fornecedor=<?php echo $nm_fornecedor; ?>" style="display:none"></a>
										<div>
											<p id="retNmPrd" style='background-color: #98FB98'></p>
										</div>
										<div class="produto">
											<div class="row" id="confPpPick">
												<form id="form_conf_PP" method="" action="">
													<div class="col-md-12">
														<div class="form-group">
															<div class="ui-grid-a">
																<div class="ui-block-a">
																	<input type="text" id="nr_veiculo" name="nr_veiculo" value="" placeholder="VEÍCULO" style="text-align: left;" />
																</div>
																<div class="ui-block-b">
																	<input type="text" id="ds_motorista" name="ds_motorista" class="form-control" placeholder="MOTORISTA" style="text-align: left;">
																</div>
																<div class="ui-block-a">
																	<input type="text" id="qtd_vol" name="qtd_vol" class="form-control" value="1" placeholder="VOLUMES" style="text-align: right;" />
																</div>
																<div class="ui-block-b">
																	<input type="text" id="nr_total_volume	" name="nr_total_volume	" class="form-control" value="" placeholder="QUANTIDADE DE MATERIAIS" style="text-align: right;" />
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group">
															<textarea id="ds_obs" name="ds_obs" class="form-control" placeholder="OBSERVAÇÕES"></textarea>
															<button class="btn btn-primary" type="button" id="btnSaverecPrd" value="<?php echo $cod_rec; ?>">SALVAR</button>
															<div class="ui-grid-a">
																<div class="ui-block-a">
																	<button class="btn btn-primary" type="button" id="btnLibVol" value="<?php echo $cod_rec; ?>">GERAR ETIQUETA</button>
																</div>
																<div class="ui-block-b">
																	<button class="btn btn-primary" type="button" id="btnLibVol" value="<?php echo $cod_rec; ?>">LIBERAR EMBARQUE</button>
																</div>
															</div>
															<button class="btn btn-primary" type="button" id="btnFinVol" value="<?php echo $cod_rec; ?>" style="background-color: #16a085; color:white">FINALIZAR EMBARQUE</button>
														</div>
													</div>
												</form>
												<hr>
												<div class="row" id="retFinRecDtl">
													<div>
														<p id="total_coletado"><?php echo "<strong>Total da rota:</strong> " . $nr_total . " |<strong>Total com volumes:</strong> " . $total_volume . " | <strong>Quantidade sem volume:</strong> " . $total_faltante; ?></p>
													</div>
													<table data-role="table" id="" data-mode="" class="table" style="font-size: 10px;">
														<thead>
															<tr>
																<th data-priority="1">CÓDIGO</th>
																<th data-priority="2">ETIQUETA.</th>
																<th data-priority="3">QTDE</th>
																<th style="width:20%;text-align:center;">Ações</th>
															</tr>
														</thead>
														<tbody id="list_produtos">
															<?php while ($dados = mysqli_fetch_assoc($res_ped)) { ?>
																<tr style='background-color: #98FB98'>
																	<td><?php echo $dados['id_volume']; ?></td>
																	<td><?php echo $dados['cod_etq']; ?></td>
																	<td><?php echo $dados['nr_total_volume']; ?></td>
																	<td style='text-align:center'>
																		<button data-role="none" value="<?php echo $dados['id_volume']; ?>" id='btnDelVol'>EXCLUIR</button>
																	</td>
																</tr>
															<?php } ?>

														</tbody>
													</table>
												</div>
											</div>
										</div>
									</fieldset>
								</form>
							</fieldset>
							<fieldset>
								<div id="retConsPp"></div>
							</fieldset>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>


<?php } else if ($qtd_falta == "FALTA") { ?>

	<div data-role="page" id="one" class="jqm-demos jqm-home" style="background-color: white;font-size: 12px;">
		<div data-role="header" class="jqm-header" style="height: 50px">
			<h2><img src="_assets/img/logo12.png" alt="Conferência eletrônica" style="width: 100px"></h2>
			<a href="expede_rota.php?data=<?php echo $dt_limite; ?>" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-arrow-l ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
			<a href="" class="jqm-search-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-power ui-nodisc-icon ui-alt-icon ui-btn-right" id="btnLogout"></a>
		</div>
		<div role="main" class="ui-content jqm-content" id="retEntrega" style="padding-top: 1em">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="jarviswidget jarviswidget-sortable" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false" role="widget">
						<div role="content">
							<fieldset>
								<form id="form_conf_end" method="" action="">
									<fieldset>
										<h1 style="text-align: center;">HÁ PEDIDOS INCOMPLETOS PARA ESTA ROTA. FAVOR FINALIZAR TODAS AS CONFERÊNCIAS ANTES DE GERAR OS VOLUMES</h1>
									</fieldset>
								</form>
							</fieldset>
							<fieldset>
								<div id="retConsPp"></div>
							</fieldset>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>



<?php } ?>