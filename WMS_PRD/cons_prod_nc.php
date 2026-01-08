<?php
require_once('data/movimento/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();

$sql_local = "select * from tb_armazem";
$res_local = mysqli_query($link, $sql_local);

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
						Consulta 
					<span>|  
						Estoque | Produtos não conforme
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
															<h2>Consulta saldo produtos não conforme</h2>	
														
														</header>
											</div>
														
												<div>
														
													<!-- widget edit box -->
													<div class="jarviswidget-editbox">
														<!-- This area used as dropdown edit box -->
														
													</div>
													<!-- end widget edit box -->
														
														
													<!-- widget content -->
													<div class="widget-body no-padding" id="dados">

														<div id="retorno"></div>
														<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 30px">
														
														<form class="form-inline" method="POST" id="formProdEstoque" action="">
							                                <div class="form-group">
							                                    <label for="conGalpao" style="color: black"> Local</label>
							                                    <select class="form-control" id="conGalpao" name="conGalpao">
							                                        <option>Escolha o local</option>
							                                        <?php
							                                        while ($row_select_local = mysqli_fetch_assoc($res_local)) {
							                                        echo '<option value="'.$row_select_local['id'].'">'.$row_select_local['nome'].'</option>';
							                                         } ?>
							                                    </select>
							                                </div>
							                                <div class="form-group">
							                                    <label for="conRua" style="color: black"> Rua / Módulo</label>
							                                    <select class="form-control" id="conRua" name="conRua">
							                                        <option>Selecione a rua</option>
							                                    </select>
							                                </div>
							                                <div class="form-group">
							                                    <label for="conColuna" style="color: black"> Coluna</label>
							                                    <select class="form-control" id="conColuna" name="conColuna">
							                                        <option>Selecione a coluna</option>
							                                    </select>
							                                </div>
							                                <div class="form-group">
							                                    <label for="conAltura" style="color: black"> Altura</label>
							                                    <select class="form-control" id="conAltura" name="conAltura">
							                                        <option>Selecione a altura</option>
							                                    </select>
							                                </div>
							                                <div class="form-group form-inline" style="float:right; margin-right: 60px">
												                <input type="submit" class="form-control btn-info" id="btnPesquisaProdEstoqNc" value="Pesquisar">
												            </div>
							                            </form>
													</article>
													<div id="retornoEstoque"></div>
													</div>
													<div>		
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