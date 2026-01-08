<?php
session_start();
?>
<?php

if (!isset($_SESSION["id"]) || !isset($_SESSION["usuario"])) {

	header("Location:../index.php");
	exit;

} else {

	$id = $_SESSION["id"];
}
?>
<?php
require_once "bd_class.php";

$objDb = new db();
$link = $objDb->conecta_mysql();

$sql = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'C' and fl_status = 1" or die(mysqli_error($sql));

$sql_usr = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'U' and fl_status = 1" or die(mysqli_error($sql));
$res_usr = mysqli_query($link, $sql_usr);

$select_cliente = mysqli_query($link, $sql);

$sql_fornecedor = "select cod_cliente, nm_cliente from tb_cliente where fl_tipo = 'D' and fl_status = 1" or die(mysqli_error($sql));

$select_fornecedor = mysqli_query($link, $sql_fornecedor);

$sql_tp = "select cod_tipo, nm_tipo from tb_tipo where ds_tipo = 1";
$res_tp = mysqli_query($link, $sql_tp);

$sql_tipo2 = "select t1.* from tb_tipo t1
left join tb_recebimento t2 on t1.cod_tipo = t2.tp_rec
where ds_tipo = 1";
$res_tipo2 = mysqli_query($link, $sql_tipo2);

?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Movimentação</li><li>Recebimento</li>
		</ol>
	</div>
	<div id="content">
		<section id="widget-grid" class="">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12"">
					<div>
						<div class="widget-body">
							<section id="widget-grid" class="">
								<div class="row">
									<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
											<header>
												<span class="widget-icon"> <i class="fa fa-cog"></i> </span>
												<h2 id="novaOR">Novo recebimento</h2>
											</header>
											<div class="row">
												<div class="widget-body no-padding" id="dados">
													<div id="retorno"></div>
													<article class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
														<div class="portlet-body"><br><br>
															<fieldset>
																<button type="submit" class="btn btn-primary" id="btnInsRec" style="width: 100px">Salvar</button>														
															</fieldset>
															<hr>
															<fieldset>
																<div class="col-xs-12">
																	<label class="col-xs-2 control-label" for="cod_cli">Cliente</label>
																	<select class="form-control" name="cod_cli" id="cod_cli">
																		<?php
																		while ($row_select_cliente = mysqli_fetch_assoc($select_cliente)) {?>
																			<option value="<?php echo $row_select_cliente['cod_cliente']; ?>"><?php echo $row_select_cliente['nm_cliente']; ?>
																		</option> 
																	<?php }?>
																</select>
																<input type="hidden" name="nm_user_criado_por" id="nm_user_criado_por" value="<?php echo $id; ?>">
															</div>
														</fieldset>
														<fieldset>
															<div class="col-xs-12">
																<div class="form-group">
																	<label class="control-label" for="nm_fornecedor">Fornecedor</label>
																	<input type="text" class="form-control" name="nm_fornecedor" placeholder="Fornecedor" id="nm_fornecedor" required="true">
																</div>
															</div>
														</fieldset>
														<fieldset>
															<div class="col-xs-6">
																<label class="col-xs-4 control-label" for="tp_rec">Tipo</label>
																<select class="form-control" name="tp_rec" id="tp_rec">
																	<option>Selecione</option>
																	<?php while ($row_select_tipo = mysqli_fetch_assoc($res_tp)) {?>
																		<option value="<?php echo $row_select_tipo['cod_tipo']; ?>"><?php echo $row_select_tipo['nm_tipo']; ?></option> 
																	<?php }?>
																</select>
															</div>
															<div class="col-xs-6">
																<div class="insumo">
																	<div class="form-group">
																		<label class="control-label" for="nr_insumo">Pedido de compra</label>
																		<input type="text" class="form-control" name="nr_insumo" placeholder="Pedido de compra" id="nr_insumo">
																	</div>
																</div>
															</div>
														</fieldset>
														<fieldset>
															<div class="col-xs-4">
																<div class="form-group">
																	<label class="control-label" for="nr_peso_previsto">Peso previsto</label>
																	<input type="text" class="form-control" name="nr_peso_previsto" placeholder="Peso previsto" id="nr_peso_previsto">
																</div>
															</div>
															<div class="col-xs-4">
																<div class="form-group">
																	<label class="control-label" for="dt_recebimento_previsto">Data prevista</label>
																	<input type="date" class="form-control" name="dt_recebimento_previsto" placeholder="Data prevista" id="dt_recebimento_previsto">
																</div>
															</div>
															<div class="col-xs-4">
																<div class="form-group">
																	<label class="control-label" for="nr_volume_previsto">Volume previsto</label>
																	<input type="text" class="form-control" name="nr_volume_previsto" placeholder="Volume previsto" id="nr_volume_previsto">
																</div>
															</div>
														</fieldset>
														<fieldset>
															<div class="col-xs-6">
																<div class="form-group">
																	<label class="control-label" for="nm_transportadora">Transportador</label>
																	<input type="text" class="form-control" name="nm_transportadora" placeholder="Transportador" id="nm_transportadora">
																</div>
															</div>
															<div class="col-xs-6">
																<div class="form-group">
																	<label class="control-label" for="nm_motorista">Motorista</label>
																	<input type="text" class="form-control" name="nm_motorista" placeholder="Motorista" id="nm_motorista">
																</div>
															</div>
														</fieldset>
														<fieldset>
															<div class="col-xs-6">
																<div class="form-group">
																	<label class="control-label" for="nm_placa">Placa</label>
																	<input type="text" class="form-control" name="nm_placa" placeholder="Placa" id="nm_placa">
																</div>
															</div>
															<div class="col-xs-6">
																<div class="form-group">
																	<label class="control-label" for="dt_recebimento_real">Data real</label>
																	<input type="date" class="form-control" name="dt_recebimento_real" placeholder="Data real" id="dt_recebimento_real">
																</div>
															</div>
														</fieldset>
														<fieldset>
															<div class="col-xs-12">
																<div class="form-group">
																	<label class="control-label" for="ds_obs">Observações</label>
																	<textarea class="form-control" rows="5" type="text" id="ds_obs" name="ds_obs" placeholder="Observações"></textarea>
																</div>
															</div>
														</fieldset>
													</div>
												</article>
												<article class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<div id="insNfRec">
														<div class="portlet-body"><br><br>
															<fieldset>
																<button type="submit" class="btn btn-primary" id="btnFormNovoNfRec" style="width: 100px">Salvar</button>

																<button type="button" class="btn btn-green btn-outline" id="btnModalXml" value="<?php echo $id_rec; ?>">
																	<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
																	Importar Xml
																</button>								
															</fieldset>
															<hr>
															<legend>Inserir notas fiscais</legend>
															<form method="post" class="form-inline" action="" id="formNovoNfRec">
																<fieldset>
																	<div class="col-xs-12">
																		<select class="form-control" name="id_rem" id="id_rem" style="width: 355px">
																			<option>Emitente</option>
																			<?php while ($row = mysqli_fetch_assoc($res_emit)) {?>
																				<option value="<?php echo $row['cod_cliente']; ?>"><?php echo $row['nm_cliente']; ?></option> 
																			<?php }?>
																		</select>
																	</div>
																</fieldset><br />
																<fieldset>
																	<div class="col-xs-12">
																		<select class="form-control" name="id_dest" id="id_dest" style="width: 355px">
																			<option>Destinatário</option>
																			<?php while ($dados_dest = mysqli_fetch_assoc($res_dest)) {?>
																				<option value="<?php echo $dados_dest['cod_cliente']; ?>"><?php echo $dados_dest['nm_cliente']; ?></option> 
																			<?php }?>
																		</select>
																	</div>
																</fieldset><br />
																<fieldset>
																	<div class="col-xs-12">
																		<input type="hidden" class="form-control" id="cod_rec" name="cod_rec" value="<?php echo $id_rec; ?>" >
																		<input type="hidden" class="form-control" id="fl_status" name="fl_status" value="<?php echo $fl_status; ?>" >
																		<input type="text" class="form-control" id="nr_fisc_ent" name="nr_fisc_ent" placeholder="Nota fiscal" required="true">
																		<input type="date" class="form-control" id="dt_emis_ent" name="dt_emis_ent" placeholder="Emissão" required="true">
																	</div>
																</fieldset><br />
																<fieldset>
																	<div class="col-xs-12">
																		<input type="text" class="form-control" id="tp_vol_ent" name="tp_vol_ent" placeholder="Tipo de volumes" required="true">
																		<input type="text" class="form-control" id="qtd_vol_ent" name="qtd_vol_ent" placeholder="Total de volume">
																	</div>
																</fieldset><br />
																<fieldset>
																	<div class="col-xs-12">
																		<input type="text" class="form-control" id="nr_cfop_ent" name="nr_cfop_ent" placeholder="Cfop">
																		<input type="text" class="form-control" id="nr_peso_ent" name="nr_peso_ent" placeholder="Peso total (kg)">
																	</div>
																</fieldset><br />
																<fieldset>
																	<div class="col-xs-12">
																		<input type="text" class="form-control" id="vl_tot_nf_ent" name="vl_tot_nf_ent" placeholder="Valor total" required="true">
																		<input type="text" class="form-control" id="base_icms_ent" name="base_icms_ent" placeholder="Base ICMS">
																	</div>
																</fieldset><br />
																<fieldset>
																	<div class="col-xs-6">
																		<input type="text" class="form-control" id="vl_icms_ent" name="vl_icms_ent" placeholder="Valor ICMS">
																	</div>
																</fieldset><br />
																<fieldset>
																	<div class="col-xs-12">
																		<input type="text" class="form-control" id="chavenfe" name="chavenfe" placeholder="Chave Nfe" style="width: 450px">
																	</div>
																</fieldset><br />
																<fieldset>
																	<div class="col-xs-12">
																		<textarea class="form-control" rows="3" id="ds_obs_nf" name="ds_obs_nf" id="ds_obs_nf" placeholder="Observação" style="width: 450px"></textarea>
																	</div>
																</fieldset>
															</form>
														</div>
													</div>
												</article>												
											</div>
										</div>
										<div class="row">
											<article class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<div class="portlet-body"><br>
													<legend>Notas fiscais</legend>
													<fieldset id="listNfRec">
														<div class="table-responsive">
															<table class="table table-bordered">
																<thead>
																	<tr style="font-size: 10px">
																		<th></th>
																		<th> N.F. </th>
																		<th> Fornecedor </th>
																		<th> Peso (Kg)</th>
																		<th > Volumes </th>
																		<th> Tipo </th>
																		<th> Valor  </th>
																	</tr>
																</thead>
																<tbody id="retNfRec">

																</tbody>
															</table>
														</div>
													</fieldset>
												</div>
											</article>
											<article class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<div class="portlet-body"><br>
													<legend>Inserir produtos</legend>
													<fieldset id="insPrdNfRec">
													</fieldset>
												</div>
											</article>
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
<script type="text/javascript">
	$(document).ready(function(){
		function fetch_data()  
		{
			//var cod_rec = j.cod_rec;
			$.ajax
			({  
				url:"data/recebimento/select.php",  
				method:"POST",
				success:function(data){  
					$('#insPrdNfRec').html(data);  
				}  
			});  
		}  
		fetch_data();

		$('#btn_add').on('click', function(){  
			var nr_fisc_ent 	= $('#nr_fisc_ent').val();  
			var produto 		= $('#produto').text();
			var estado_produto 	= $('#estado_produto').text();
			var nr_qtde 		= $('#nr_qtde').text();
			var vl_unit 		= $('#vl_unit').text();
			var nr_peso_unit 	= $('#nr_peso_unit').text();
			var ds_uni_med 		= $('#ds_uni_med').text();
			if(nr_fisc_ent == '' || produto == '' || estado_produto == '' || nr_qtde == '' || vl_unit == '' || nr_peso_unit == '' || ds_uni_med == '')  
			{  
				alert("Todos os campos são obrigatórios");  
				return false;  
			}  
			$.ajax
			({  
				url:"insert.php",  
				method:"POST",  
				data:{
					nr_fisc_ent 	:nr_fisc_ent, 
					produto 		:produto,
					estado_produto 	:estado_produto,
					nr_qtde 		:nr_qtde,
					vl_unit 		:vl_unit,
					nr_peso_unit 	:nr_peso_unit,
					ds_uni_med 		:ds_uni_med
				},  
				dataType:"text",  
				success:function(data)  
				{  
					alert(data);
					fetch_data();  
				}  
			})  
		});   

		$('#btnInsRec').on('click', function(){
			event.preventDefault();
			if(confirm("Confirma a criação do recebimento?")){
				var cod_cli 					= $('#cod_cli').val();
				var nm_user_criado_por 			= $('#nm_user_criado_por').val();
				var nm_fornecedor 				= $('#nm_fornecedor').val();
				var tp_rec 						= $('#tp_rec').val();
				var nr_peso_previsto 			= $('#nr_peso_previsto').val();
				var dt_recebimento_previsto 	= $('#dt_recebimento_previsto').val();
				var nr_volume_previsto 			= $('#nr_volume_previsto').val();
				var nm_transportadora 			= $('#nm_transportadora').val();
				var nm_motorista 				= $('#nm_motorista').val();
				var nm_placa 					= $('#nm_placa').val();
				var dt_recebimento_real 		= $('#dt_recebimento_real').val();
				var ds_obs 						= $('#ds_obs').text();
				var nr_insumo 					= $('#nr_insumo').val();
				$.ajax
				({
					url:"data/recebimento/ins_recebimento_new.php",
					method:"POST",
					dataType:'json',
					data:{
						cod_cli 					:cod_cli,
						nm_user_criado_por 			:nm_user_criado_por,
						nm_fornecedor 				:nm_fornecedor,
						tp_rec 						:tp_rec,
						nr_peso_previsto 			:nr_peso_previsto,
						dt_recebimento_previsto 	:dt_recebimento_previsto,
						nr_volume_previsto 			:nr_volume_previsto,
						nm_transportadora 			:nm_transportadora,
						nm_motorista 				:nm_motorista,
						nm_placa 					:nm_placa,
						dt_recebimento_real 		:dt_recebimento_real,
						ds_obs 						:ds_obs,
						nr_insumo 					:nr_insumo
					},
					success:function(j)
					{
						if(j.info == 0){
							alert("OR cadastrada com sucesso!");
							$('#cod_cli').val(j.cod_cli);
							$('#nm_fornecedor').val(j.nm_fornecedor);
							$('#tp_rec').val(j.tp_rec);
							$('#nr_peso_previsto').val(j.nr_peso_previsto);
							$('#dt_recebimento_previsto').val(j.dt_recebimento_previsto);
							$('#nr_volume_previsto').val(j.nr_volume_previsto);
							$('#nm_transportadora').val(j.nm_transportadora);
							$('#nm_motorista').val(j.nm_motorista);
							$('#nm_placa').val(j.nm_placa);
							$('#dt_recebimento_real').val(j.dt_recebimento_real);
							$('#ds_obs').text(j.ds_obs);
							$('#novaOR').html('Novo recebimento: '+j.cod_rec);

						}else{
							alert("Erro no cadastro!");
						}
					}
				});
			}
		});
	});
</script>