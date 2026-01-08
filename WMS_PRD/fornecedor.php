<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Cadastros</li><li>Fornecedores</li>
		</ol>
	</div>
	<div id="content">
		<section id="widget-grid" class="">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				</header>
				<div>
					<div class="jarviswidget-editbox">
						<input class="form-control" type="text">	
					</div>
					<div class="widget-body">
						<section id="widget-grid" class="">
							<div class="row">														
								<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
										<header>
											<span class="widget-icon"> <i class="fa fa-cog"></i> </span>
											<h2>Cadastro de Fornecedores </h2>				
											<button type="submit" id="btnNewFornecedor" class="btn btn-default btn-xs" style="float:right; margin-top: 4px; margin-right: 12px">Novo</button>	

										</header>

										<div>
											<div class="jarviswidget-editbox">
											</div>
											<div class="widget-body no-padding" id="dados">

												<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
													<thead>
														<tr>
															<th> Ações </th>
															<th> Código</th>
															<th> Razão Social </th>
															<th> E-mail </th>
															<th> CNPJ </th>
															<th> I.E. </th>
															<th> Cidade </th>
															<th> UF </th>
															<th> Telefone </th>
															<th> Contato </th>
														</tr>
													</thead>
													<tbody>
														<?php 
														require_once('data/entidade/list_fornecedor.php');                                                          
														while($dados = mysqli_fetch_array($res)) {?>
															<tr class="odd gradeX">
																<td style="text-align: center; width: 300px">  
																	<button type="submit" id="btnDtlDestinatario" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Detalhe</button>
																	<button type="submit" id="btnUpdDestinatario" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Alterar</button>
																	<button type="submit" id="btnDelDestinatario" class="btn btn-primary btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Excluir</button>
																	<button type="submit" id="btnInsInstrucao" class="btn btn-success btn-xs" value="<?php echo $dados['cod_cliente']; ?>">Instruções</button>
																</td>
																<td style="text-align: center; width: 10px"><?php echo $dados['cod_cliente']; ?></td>
																<td><?php echo $dados['nm_cliente']; ?></td>
																<td><?php echo $dados['ds_email']; ?></td>
																<td><?php echo $dados['nr_cnpj_cpf']; ?></td>
																<td><?php echo $dados['ds_ie_rg']; ?></td>
																<td><?php echo $dados['ds_cidade']; ?></td>
																<td><?php echo $dados['ds_uf']; ?></td>
																<td><?php echo $dados['nr_telefone']; ?></td>
																<td><?php echo $dados['nm_contato']; ?></td>
															</tr> 
														<?php } ?> 
													</tbody>
												</table>

											</div>
										</div>
									</div>
									<div id="retorno"></div>
									<div id="retornoConf"></div>

								</article>	
							</div>	
						</section>
					</div>
				</div>
			</article>
		</div>
		<div class="row">
			<div class="col-sm-12">
			</div>

		</div>
	</section>
</div>