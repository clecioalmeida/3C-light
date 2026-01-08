t<div id="main" role="main">
	<div id="ribbon">
		<ol class="breadcrumb">
			<li>Home</li><li>Inventário</li><li>Parâmetros de programação</li>
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
						Inventário 
					<span>|  
						Parâmetros de programação
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
								<form class="form-inline" method="post" action="" id="formInv" role="form">
											<fieldset>
												<header>
													<h4>Parâmetros</h4>
												</header>
												<div class="col-md-10">
													<label>Período</label>
													<div class="form-group">
														<select class="form-control" name="ds_tipo" id="ds_tipo">
															<option value="R">Rotativo</option>
															<option value="A">Anual</option>
														</select> 
													</div>
												</div>
											</fieldset>
											<fieldset>
												<header>
													<h4>Data</h4>
												</header>
												<div class="col-md-10">
													<label>De:</label>
													<div class="form-group">
														<input type="date" name="dt_inicio" class="form-control" id="datainicio" placeholder="Início">
													</div>
													<label>Até:</label>
													<div class="form-group">
														<input type="date" name="dt_fim" class="form-control" id="dt_fim" placeholder="Início">
													</div>
												</div>
											</fieldset>
											<hr>
											<fieldset>
												<header>
													<h4>Endereço</h4>
												</header>
												<div class="col-md-10">
													<label class="form-group">Armazém</label>
													<div class="form-group">
														<select class="form-control" name="id_galpao" id="id_galpao">
															<option>Selecione o armazém</option>
															<?php
																require_once('data/inventario/bd_class.php');
																$objDb = new db();
    															$link = $objDb->conecta_mysql();

    															$local="select * from tb_armazem";
    															$res_local = mysqli_query($link, $local);
    															while ($dados_local=mysqli_fetch_assoc($res_local)) {?>
    																<option id="local" value="<?php echo $dados_local['id']; ?>"><?php echo $dados_local['nome']; ?></option>
    															<?php } ?>
														</select>
													</div>
												</div>
											</fieldset>
											<br>
											<fieldset>
												<div class="col-md-10">
													<label class="form-group">De:</label>
													<div class="form-group">
														<select class="form-control" name="id_rua_inicio" id="id_rua_inicio">
															<option>Selecione a rua</option>
														</select> 
													</div>
													<div class="form-group">
														<select class="form-control" name="id_coluna_inicio" id="id_coluna_inicio">
															<option>Selecione a coluna</option>
														</select> 
													</div>
												</div>
											</fieldset>
											<fieldset>
												<div class="col-md-10">
													<label>Até:</label>
													<div class="form-group">
														<select class="form-control" name="id_rua_fim" id="id_rua_fim">
															<option>Selecione a rua</option>
														</select> 
														<select class="form-control" name="id_coluna_fim" id="id_coluna_fim">
															<option>Selecione a coluna</option>
														</select> 
													</div>
												</div>
											</fieldset>
											<hr>
											<fieldset>
												<header>
													<h4>Produto</h4>
												</header>
												<div class="col-md-10">
													<div class="form-group">
														<select class="form-control" name="id_grupo" id="id_grupo">
															<option>Selecione o grupo</option>
															<?php
    															$grupo="select * from tb_grupo";
    															$res_grupo = mysqli_query($link, $grupo);
    															while ($dados_grupo=mysqli_fetch_assoc($res_grupo)) {?>
    																<option id="local" value="<?php echo $dados_grupo['cod_grupo']; ?>"><?php echo $dados_grupo['nm_grupo']; ?></option>
    															<?php } ?>
														</select> 
													</div>
													<div class="form-group">
														<select class="form-control" name="id_sub_grupo" id="id_sub_grupo">
															<option>Selecione o sub-grupo</option>
														</select> 
													</div>
													<div class="form-group">
														<input type="text" class="form-control" name="id_produto" id="cod_produto" placeholder="Digite o código do produto">
													</div>
												</div>
											</fieldset>
											<hr>
											<button type="submit" id="btnInventario" class="btn btn-primary">
												Salvar
											</button>
										</form>
										<div id="retorno"></div>
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
    $('#btnInventario').click(function(){
        $('#formInv').ajaxForm({
            target:'#retorno',
            url:'data/inventario/ins_prog.php',
        });
    });

    $(function(){
    	$('#id_galpao').change(function(){
    		if( $(this).val() ) {
    			$('.carregando').show();
    			$.getJSON('data/inventario/consulta_rua.php?search=',{id_rua: $(this).val(), ajax: 'true'}, function(j){
    				var options = '<option value="0">Selecione a rua</option>'; 
    				for (var i = 0; i < j.length; i++) {
    					options += '<option value="' + j[i].rua + '">' + j[i].rua + '</option>';
    				}   
    				$('#id_rua_inicio').html(options);
    				$('#id_rua_fim').html(options);
    				$('.carregando').hide();
    			});
    		} else {
    			$('#id_rua_inicio').html('<option value="0">Selecione a rua</option>');
    		}
    	});

    	$('#id_rua_inicio').change(function(){
    		if( $(this).val() ) {
    			$('.carregando').show();
    			$.getJSON('data/inventario/consulta_coluna.php?search=',{id_coluna: $(this).val(), id_galpao: $('#id_galpao').val(), ajax: 'true'}, function(j){
    				var options = '<option value="0">Selecione a coluna</option>'; 
    				for (var i = 0; i < j.length; i++) {
    					options += '<option value="' + j[i].coluna + '">'  + j[i].coluna + '</option>';
    				}   
    				$('#id_coluna_inicio').html(options);
    				$('#id_coluna_fim').html(options);
    				$('.carregando').hide();
    			});
    		} else {
    			$('#id_coluna_inicio').html('<option value="0">Selecione a coluna</option>');
    		}
    	});

    	$('#id_grupo').change(function(){
    		if( $(this).val() ) {
    			$('.carregando').show();
    			$.getJSON('data/inventario/consulta_subgrupo.php?search=',{id_grupo: $(this).val(), ajax: 'true'}, function(j){
    				var options = '<option value="">Selecione o sub-grupo</option>'; 
    				for (var i = 0; i < j.length; i++) {
    					options += '<option value="' + j[i].cod_sub_grupo + '">' + j[i].nm_sub_grupo + '</option>';
    				}   
    				$('#id_sub_grupo').html(options);
    				$('.carregando').hide();
    			});
    		} else {
    			$('#id_sub_grupo').html('<option value="">– Selecione o sub-grupo –</option>');
    		}
    	});
    });
</script>