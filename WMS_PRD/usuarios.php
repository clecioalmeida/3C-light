<div id="main" role="main">
	<div id="content">
		<section id="widget-grid" class="">
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
												<h2>Cadastro de usuários </h2>				
												<button type="submit" id="btnNewUser" class="btn btn-default btn-xs" style="float:right; margin-top: 4px; margin-right: 12px">Novo</button>	
											</header>
											<div>
												<div class="jarviswidget-editbox">
												</div>
												<div class="widget-body no-padding" id="dados">
													<div id="retorno"></div>
													<table class="table order-column" id="sample_1" style="width: 50%">
														<thead>
															<tr>
																<th> Ações </th>
																<th> Código</th>
																<th> Nome </th>
																<th> Depto </th>
																<th> # </th>
															</tr>
														</thead>
														<tbody>
															<?php require_once('data/empresa/list_usuario.php');                                  
															while($dados = mysqli_fetch_array($res)) {?>
																<tr class="odd gradeX">
																	<td style="text-align: center; width: 200px">  
																		<button type="submit" id="btnDtlUser" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>" disabled>Detalhe</button>
																		<button type="submit" id="btnUpdUser" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>" disabled>Alterar</button>
																		<button type="submit" id="btnDelUser" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>" disabled>Excluir</button>
																	</td>
																	<td style="text-align: center; width: 10px"> <?php echo $dados['id']; ?> </td>
																	<td> <?php echo $dados['nm_user']; ?> </td>
																	<td> <?php echo $dados['nm_cargo']; ?> </td>
																	<td style="text-align: center; width: 10px">
																		<button type="submit" id="btnPermUser" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>" disabled>Permissões</button>
																	</td>
																</tr> 
															<?php } ?> 
														</tbody>
													</table>
												</div>
											</div>
										</div>	
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
</div>