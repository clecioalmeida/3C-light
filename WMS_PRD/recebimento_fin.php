<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Operacional</li><li>Recebimento</li>
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
						Operacional 
					<span>|  
						Recebimento | finalizadas
					</span>
				</h1>
			</div>
			<!-- end col -->
					
			<!-- right side of the page with the sparkline graphs -->
			<!-- col -->
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8"></div>
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
													<h2>Recebimento de produtos</h2>				
													<button type="submit" id="btnNovoRec" class="btn btn-default btn-xs" style="float:right; margin-top: 4px; margin-right: 12px">Novo</button>	
														
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
														<h2 id="retFinORPrint" style="background-color: #F08080"></h2>
														
															<table id="dt_basic" class="table table-striped table-bordered table-hover table-checkable order-column"  style="overflow-y: auto">
															        <thead>
																		<tr>
																			<th colspan="4"> Ações </th>
																			<th> O.R. </th>
																			<th> Data</th>
																			<th> Tipo de recebimento </th>
																			<th> Peso  </th>
																			<th> Volume  </th>
																			<th> Criado por </th>
																			<th> Conferente 1</th>
															            	<th> Conferente 2</th>
																			<th colspan="2"  style="text-align: center; width: 20px"> NF </th>
																			<th  style="text-align: center; width: 20px"> Finalizar </th>
																		</tr>
															        </thead>
															        <tbody>
															            <?php 
															            require_once('data/recebimento/list_recebimento_fin.php');                                                          
															            while($dados = mysqli_fetch_array($res)) {?>
															            <tr class="odd gradeX">
															                <td style="text-align: center; width: 5px">
															                    <button type="submit" id="btnDtlRec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">Detalhe</button>
															                </td>
															                <td style="text-align: center; width: 5px">
															                    <button type="submit" id="btnUpdRec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">Alterar</button>
															                </td>
															                <td style="text-align: center; width: 5px">
															                    <button type="submit" id="btnDelRec" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">Excluir</button>
															                </td>
															                <td style="text-align: center; width: 5px">
															                    <button type="submit" id="btnPrintRecFin" class="btn btn-default btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">Imprimir</button>
															                </td>
															                <td style="text-align: center; width: 10px"> <?php echo $dados['cod_recebimento']; ?> </td>
															                <td> <?php
															                	if($dados['dt_recebimento_previsto'] < 1){
															                		echo '';
															                	}else{
															                		echo date('d/m/Y', strtotime($dados['dt_recebimento_previsto']));
															                	} ?> 
															                </td>
															                <td> <?php echo $dados['nm_tipo']; ?> </td>
															                <td style="text-align: right;"> <?php echo $dados['nr_peso_previsto']; ?> </td>
															                <td style="text-align: right;"> <?php echo $dados['nr_volume_previsto']; ?> </td>
															                <td> <?php echo $dados['nm_user_criado_por']; ?> </td>
															                <td> <?php echo $dados['nm_user_recebido_por']; ?> </td>
															                <td> <?php echo $dados['nm_user_autorizado_por']; ?> </td>
															                <td  style="text-align: center; width: 20px">  
															                    <button type="submit" id="btnNfRec" class="btn btn-default btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">Notas fiscais</button>
															                </td>
															                <td  style="text-align: center; width: 20px">  
															                    <button type="submit" id="btnProdRec" class="btn btn-default btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">Produtos</button>
															                </td>
															                <td  style="text-align: center; width: 5px">  
															                    <button type="submit" id="btnFimRec" class="btn btn-default btn-xs" value="<?php echo $dados['cod_recebimento']; ?>">Finalizar</button>
															                </td>
															            </tr>
																			 <?php } ?> 
																	</tbody>
																</table>
														
															</div>
															<!-- end widget content -->
														
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