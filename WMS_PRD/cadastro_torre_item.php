<?php
require_once 'data/movimento/bd_class.php';
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_torre = "select * from tb_tipo_torre where fl_status <> 'E'";
$res_torre = mysqli_query($link, $sql_torre);

?>
<style type="text/css">
.carregando{
	color:#ff0000;
	display:none;
}
</style>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Cadastros</li><li>Peças da torre</li>
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
						Peças da torre
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
												<h2>Cadastro peças de Torre</h2>

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

														<form class="form-inline" method="POST" id="formCadTorre" action="">
															<div class="form-group">
																<label for="tags" style="color: white"> Torre</label>
																<select class="form-control" id="id_torre_item" name="id_torre_item">
																	<option value="">Escolha a Torre</option>
																	<?php
																	while ($torre = mysqli_fetch_assoc($res_torre)) {
																		echo '<option value="' . $torre['id'] . '">' . $torre['id'] . ' ' . $torre['ds_tensao'] . ' ' . 'KV ' . ' ' . $torre['ds_torre'] . ' ' . $torre['ds_tipo'] . ' ' . $torre['ds_circuito'] . ' ' . $torre['ds_linhao'] . '</option>';
																	}?>
																</select>
															</div>
															<div class="form-group">
																<label for="tags" style="color: white"> Parte</label>
																<select class="form-control" id="id_parte_item" name="id_parte_item">
																	<option>Escolha a parte da Torre</option>

																</select>
															</div>
															<div class="form-group form-inline" style="float:right">
																<button type="submit" class="btn btn-success" id="btnCadItem" value="Pedido">Cadastrar Peça</button>
															</div>
															<div class="form-group form-inline" style="float:right; margin-right: 60px">
																<input type="btn" id="ConsItemTorre" name="id_item" class="form-control" aria-describedby="basic-addon2" placeholder="Digite a posição ou a peça">
																<input type="submit" class="form-control btn-info" id="btnPesquisaItemTorre" value="Pesquisar">
															</div>
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
<!--script type="text/javascript">

	$(document).on('click','#btnFormCadPeca', function(){
		event.preventDefault();
		$('#btnFormCadPeca').prop("disabled", true);
		var id_torre 			= $('#id_torre').val();
		var id_parte 			= $('#id_parte').val();
		var ds_descricao 		= $('#ds_descricao').val();
		var nr_identificacao 	= $('#nr_identificacao').val();
		var nr_comprimento 		= $('#nr_comprimento').val();
		var nr_peso_unit 		= $('#nr_peso_unit').val();
		var cod_cliente 		= $('#cod_cliente').val();
		var nr_posicao 			= $('#nr_posicao').val();
		var nr_qtde 			= $('#nr_qtde').val();
		$.ajax
		({
			url:"data/torre/ins_item_torre.php",
			method:"POST",
			dataType:'json',
			data:{
				id_torre:id_torre, 
				id_parte:id_parte, 
				ds_descricao:ds_descricao, 
				nr_identificacao:nr_identificacao, 
				nr_comprimento:nr_comprimento, 
				nr_peso_unit:nr_peso_unit, 
				cod_cliente:cod_cliente, 
				nr_posicao:nr_posicao, 
				nr_qtde:nr_qtde
			},
			success:function(j)
			{
				for (var i = 0; i < j.length; i++) {

					var id_torre_rt = j[i].id_torre;
					var id_parte_rt = j[i].id_parte;

					if(j[i].info == "0"){

						$('#formCadPeca')[0].reset();
						$('#tabela').load('data/torre/consulta_torre_sql.php?search=',{id_torre:id_torre_rt, id_parte:id_parte_rt});
						$('#Novoitem').modal('show');
						$('#retModCadPecaOk').css("display", "block");
						$('#btnFormCadPeca').prop("disabled", false);

					}else if(j[i].info == "1"){

						$('#formCadPeca')[0].reset();
						$('#Novoitem').modal('show');
						$('#tabela').load('data/torre/consulta_torre_sql.php?search=',{id_torre:id_torre_rt, id_parte:id_parte_rt});
						$('#retModCadPecaOk').css("display", "block");
						$('#btnFormCadPeca').prop("disabled", false);

					}else if(j[i].info == "2"){

						$('#formCadPeca')[0].reset();
						$('#Novoitem').modal('show');
						$('#tabela').load('data/torre/consulta_torre_sql.php?search=',{id_torre:id_torre_rt, id_parte:id_parte_rt});
						$('#retModCadPecaOk').css("display", "block");
						$('#btnFormCadPeca').prop("disabled", false);

					}
				}					
			}
		});
		return false;
	});
</script-->