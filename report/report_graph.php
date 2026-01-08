<?php 
require_once('bd_class_dsv.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$SQL = "select t1.*, t2.nome from tb_inv_prog t1 left join tb_armazem t2 on t1.id_galpao = t2.id where t1.fl_status <> 'E'";
$res_inv = mysqli_query($link,$SQL); 

$link->close();
?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Cadastro</li><li>Tarefas</li>
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
						Cadastro 
					<span>|  
						Tarefas
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
													<span class="widget-icon"> <i class="fa fa-table"></i> </span>
													<h2>Tarefas cadastradas </h2>
														
												</header>
														
												<div>
														
													<!-- widget edit box -->
													<div class="jarviswidget-editbox">
														<!-- This area used as dropdown edit box -->
														
													</div>
													<!-- end widget edit box -->
														
													<!-- widget content -->
													<div class="widget-body no-padding">

														<div id="retorno_task"></div>
													<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<form method="POST" class="form-inline" id="formAlocCod" action=""><br><br>
												            <fieldset>
																<div class="col-sm-8" style="text-align: left;">
																	<div class="form-group">
																		<input type="text" class="form-control" id="tarDesc" name="tarDesc" aria-describedby="basic-addon2" placeholder="Pesquisar descrição da tarefa">
																		<select class="form-control" id="tarStatus" name="tarStatus">
																			<option>Selecione</option>
																			<option value="P">Pendentes</option>
																			<option value="L">Liberados</option>
																			<option value="F">Finalizados</option>
																		</select>
																		<select class="form-control" id="tarProject" name="tarProject" style="width: 250px">
																			<option>Projetos</option>
																		</select>
																		<input type="submit" class="btn-info form-control" id="btnPesqtarefa" value="Pesquisar">
																	</div>
																</div>
																<div class="col-sm-4" style="text-align: right;">
																	<div class="form-group">
																		<input type="submit" class="btn-primary form-control" id="btnInsTarefa" value="Novo" style="width: 100px">
																	</div>
																</div>
															</fieldset>
												        </form>
													</article>
														
													</div>
													<!-- end widget content -->
														<div id="dados" class="row"></div>
														<div id="retorno" class="row"></div>
														
												</div>
												<!-- end widget div -->
														
											</div>
										<!-- end widget -->
														
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