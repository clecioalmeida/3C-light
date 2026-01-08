<?php 
require_once('data/produto/bd_class.php');
$objDb = new db();
$link = $objDb->conecta_mysql();
$SQL = "select * from tb_kit";

$res_kit = mysqli_query($link,$SQL); 
$tr = mysqli_num_rows($res_kit);

$link->close();
?>
<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Cadastros</li><li>Kit de produtos</li>
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
						Kit de produtos
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
													<h2>Cadastro de Kit de produtos </h2>				
													<button type="submit" id="btnNovoKit" class="btn btn-default btn-xs" style="float:right; margin-top: 4px; margin-right: 12px">Novo</button>		
														
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
													                <th colspan="3">Ações</th>
													                <th data-toggle="tooltip" data-placement="left" title="Código do WMS"> Código</th>
													                <th> Descrição </th>
													                <th> Estoque mínimo </th>
													                <th> Situação </th>
													                <th> Detalhes </th>
													                <th> Produtos </th>
													                <th> Variação </th>
													            </tr>
													            </thead>
													            <tbody>
													                <?php                                                           
													                while($dados = mysqli_fetch_array($res_kit)) {?>
													                <tr class="odd gradeX">
													                    <td style="text-align: center; width: 5px">  
													                        <button type="submit" id="btnDtlKit" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">Detalhe</button>
													                    </td>
													                    <td style="text-align: center; width: 5px">
													                    	<button type="submit" id="btnUpdKit" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">Alterar</button>
													                    </td>
													                    <td style="text-align: center; width: 5px">
													                        <button type="submit" id="btnDelKit" class="btn btn-primary btn-xs" value="<?php echo $dados['id']; ?>">Excluir</button>
													                    </td>
													                    <td style="text-align: center; width: 10px"> <?php echo $dados['cod_cliente']; ?> </td>
													                    <td> <?php echo $dados['descricao']; ?> </td>
													                    <td> <?php echo $dados['estoque_minimo']; ?> </td>
													                    <td style="text-align: center; width: 10px">  </td>
													                    <td> <?php echo $dados['detalhe_kit']; ?> </td>
													                    <td style="text-align: center; width: 10px">  
													                        <button type="submit" id="btnProdKit" class="btn btn-default btn-xs" value="<?php echo $dados['id']; ?>">Produtos</button>
													                    </td>
													                    <td style="text-align: center; width: 10px">  
													                        <button type="submit" id="btnVarKit" class="btn btn-default btn-xs" value="<?php echo $dados['id']; ?>">Variação</button>
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