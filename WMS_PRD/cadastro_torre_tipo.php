<?php
require_once('data/movimento/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_torre = "select * from tb_tipo_torre where fl_status <> 'E'";
$res_torre = mysqli_query($link, $sql_torre);

?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Cadastros</li><li>Torres</li>
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
						Torres
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
														<h2>Cadastro tipos de Torre</h2>	
														
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
														
														<form method="POST" id="formPesquisaProduto" action=""><br><br>
															<fieldset>
																<div class="row">
																	<div class="col-sm-4" style="text-align: right;">
																		<div class="form-group">
																			<select class="form-control" id="selectTipoTorre" name="id_torre">
											                                    <option value="1">Escolha a Torre</option>
											                                    <?php
											                                    while ($torre=mysqli_fetch_assoc($res_torre)) {
											                                    echo '<option value="'.$torre['id'].'">'.$torre['id'].' '.$torre['ds_tensao'].' '.'KV '.' '.$torre['ds_torre'].' '.$torre['ds_tipo'].' '.$torre['ds_linhao'].' '.$torre['ds_circuito'].'</option>';
											                                    } ?>
											                                </select>
																		</div>
																		
																	</div>
																	
                            										<button type="submit" class="btn btn-primary" id="consultaTipo" value="" style="float:right;">Consultar tipo</button>
                            										<button type="submit" class="btn btn-info" id="btnCadTipoTorre" value="" style="float:right;">Cadastrar tipo</button>

                            											
                            										</div>
                            										<div class="row">
                            											<div id="tabela"></div>	
                            										</div>
                            										
																</div> 
															</fieldset>
														</form>
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