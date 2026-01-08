<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Cadastros</li><li>Clientes</li>
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
						Clientes
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
													<h2>Cadastro de Clientes </h2>				
													<button type="submit" id="btnNewUser" class="btn btn-default btn-xs" style="float:right; margin-top: 4px; margin-right: 12px">Novo</button>	
														
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
														
														<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
													        <thead>
													            <tr>
													                <th colspan="3"> Ações </th>
													                <th> Código</th>
													                <th> Razão Social </th>
													                <th> Apelido </th>
													                <th> CNPJ </th>
													                <th> I.E. </th>
													                <th> Cidade </th>
													                <th> UF </th>
													                <th> Telefone </th>
													                <th> Contato </th>
													                <th> Usuários </th>
													            </tr>
													        </thead>
													        <tbody>
													            <?php 
													            require_once('data/entidade/list_cliente.php');                                                          
													            while($dados = mysqli_fetch_array($res)) {?>
													            <tr class="odd gradeX">
													                <td style="text-align: center; width: 5px">  
													                    <button type="submit" id="btnDtlCliente" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Detalhe</button>
													                </td>
													                <td style="text-align: center; width: 5px">
													                	<button type="submit" id="btnUpdCliente" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Alterar</button>
													                </td>
													                <td style="text-align: center; width: 5px">
													                    <button type="submit" id="btnDelCliente" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Excluir</button>
													                </td>
													                <td style="text-align: center; width: 10px"><?php echo $dados['cod_cliente']; ?></td>
													                <td><?php echo $dados['nm_cliente']; ?></td>
													                <td><?php echo $dados['nm_fantasia']; ?></td>
													                <td><?php echo $dados['nr_cnpj_cpf']; ?></td>
													                <td><?php echo $dados['ds_ie_rg']; ?></td>
													                <td><?php echo $dados['ds_cidade']; ?></td>
													                <td><?php echo $dados['ds_uf']; ?></td>
													                <td><?php echo $dados['nr_telefone']; ?></td>
													                <td><?php echo $dados['nm_contato']; ?></td>
													                <td style="text-align: center">  
													                   <button type="submit" id="btnUsrCliente" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Usuários</button>
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