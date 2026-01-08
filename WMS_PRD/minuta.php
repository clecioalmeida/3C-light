<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Movimentação</li><li>Expedição</li>
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
						Movimentação 
					<span>|  
						Expedição | Minutas
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
													<h2>Minutas </h2>		
														
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
														<form method="POST" id="" action="">
												            <fieldset>
												                <div class="row"><br><br>
												                    <div class="col-sm-8" style="text-align: right;width: 300px">
												                        <div class="input-group">
												                            <input type="btn" id="expede" class="form-control" aria-describedby="basic-addon2">
												                            <span class="input-group-addon" id="btnConsMin">Pesquisar</span>
												                        </div>
												                    </div>
												                    <!--div class="col-sm-4" style="text-align: left;width: 150px">
																		<div class="form-group">
																			<input type="submit" class="btn-info form-control" id="btnGerarMinuta" value="Gerar minuta">
																		</div>
												                    </div>
												                    <div class="col-sm-4" style="text-align: left;width: 200px">
																		<div class="form-group">
																			<input type="submit" class="btn-success form-control" id="btnConsVeic" value="Veículos disponíveis">
																		</div>
												                    </div-->
												                </div> 
												            </fieldset>
												        </form>

												        <div id="info" class="row">
													</article>
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
	<script type="text/javascript">
		
		function expedir(expedicao)
    {
        var page = "data/movimento/expede_list_sql.php";
        $.ajax
        ({
            type: 'POST',
            dataType: 'html',
            url: page,
            beforeSend: function () {
                $("#info").html("Carregando...");
            },
            data: {expedicao: expedicao},
            success: function (msg)
            {
                $("#info").html(msg);
            }
        });
    }


    $('#btnFormExpede').click(function () {
        expedir($("#expede").val())
    });

	</script>